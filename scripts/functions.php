<?php
require "database.php";

function sqlQuery($query) {
    global $conn;

    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function registerAccount($data) {
    global $conn;

    $name = strtolower(stripslashes($data["name"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // Cek email sudah ada atau tidak
    $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

    if (mysqli_fetch_assoc($result)) {
        echo "
            <script>
                alert('Email sudah terdaftar!');
            </script>";
        return false;
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambah ke database
    mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    return mysqli_affected_rows($conn);
}

function loginAccount($data) {
    global $conn;

    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // Cek apakah data tersedia di database
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        // Cek kesesuaian password
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            // Set session
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["name"] = $row["name"];

            // Cek remember me
            if (isset($_POST["rememberMe"])) {
                // Set cookie
                setcookie("id", $row["id"], time() + 3600);
                setcookie("key", hash("sha256", $row["name"]), time() + 3600);
            }
            return true;
        }
    }
}

function logoutAccount() {
    session_start();
    session_unset();
    session_destroy();

    setcookie("id", "", time() - 3600);
    setcookie("key", "", time() - 3600);

    header("Location: login.php");
    exit;
}

function createEvent($data) {
    global $conn;

    $userID = $data['userID'];
    $eventName = htmlspecialchars($data['eventName']);
    $eventDesc = htmlspecialchars($data['eventDesc']);
    $eventDate = htmlspecialchars($data['eventDate']);
    $deadline = htmlspecialchars($data['deadline']);
    $maxParticipants = htmlspecialchars($data['maxParticipants']);
    $feeFree = isset($data['feeFree']) ? 0 : '';
    $fee = isset($data['fee']) ? htmlspecialchars($data['fee']) : ($feeFree ? 0 : NULL);
    $organizerName = htmlspecialchars($data['organizerName']);
    $organizerEmail = htmlspecialchars($data['organizerEmail']);

    $query = "INSERT INTO events (user_id, event_name, event_description, event_date, registration_deadline, max_participants, registration_fee, organizer_name, organizer_email, created_at, modified_at) VALUES ('$userID', '$eventName', '$eventDesc', '$eventDate', '$deadline', '$maxParticipants', '$fee', '$organizerName', '$organizerEmail', NOW(), NOW())";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function deleteEvent($data) {
    global $conn;

    $eventID = htmlspecialchars($data['eventID']);
    $query = "DELETE FROM events WHERE event_id = $eventID";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}