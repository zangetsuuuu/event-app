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
    $eventDeadline = htmlspecialchars($data['eventDeadline']);
    $eventLocation = htmlspecialchars($data['eventLoc']);
    $maxParticipants = htmlspecialchars($data['maxParticipants']);
    $fee = isset($data['fee']) ? htmlspecialchars($data['fee']) : '0';
    $organizerName = htmlspecialchars($data['organizerName']);
    $organizerEmail = htmlspecialchars($data['organizerEmail']);

    // Upload gambar
    $eventImage = uploadImage();
    if (!$eventImage) {
        return false;
    }

    $query = "INSERT INTO events (user_id, event_name, event_description, event_date, event_location, event_image, registration_deadline, max_participants, registration_fee, organizer_name, organizer_email, created_at, modified_at) VALUES ('$userID', '$eventName', '$eventDesc', '$eventDate', '$eventLocation', '$eventImage', '$eventDeadline', '$maxParticipants', '$fee', '$organizerName', '$organizerEmail', NOW(), NOW())";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function editEvent($data) {
    global $conn;

    $eventID = $data['eventID'];
    $eventName = htmlspecialchars($data['eventName']);
    $eventDesc = htmlspecialchars($data['eventDesc']);
    $eventDate = htmlspecialchars($data['eventDate']);
    $eventDeadline = htmlspecialchars($data['eventDeadline']);
    $eventLocation = htmlspecialchars($data['eventLoc']);
    $maxParticipants = htmlspecialchars($data['maxParticipants']);
    $fee = isset($data['fee']) ? htmlspecialchars($data['fee']) : '0';
    $organizerName = htmlspecialchars($data['organizerName']);
    $organizerEmail = htmlspecialchars($data['organizerEmail']);
    $eventImage = '';

    // Check if user upload a image
    if (!empty($_FILES['image']['name'])) {
        $eventImage = uploadImage();
        if (!$eventImage) {
            return false;
        }
    } else {
        $query = sqlQuery("SELECT event_image FROM events WHERE event_id = '$eventID'");
        $eventImage = $query[0]['event_image'];
    }
    
    $query = "UPDATE events SET 
                event_name = '$eventName', 
                event_description = '$eventDesc', 
                event_date = '$eventDate', 
                event_location = '$eventLocation', 
                event_image = '$eventImage', 
                registration_deadline = '$eventDeadline', 
                max_participants = '$maxParticipants', 
                registration_fee = '$fee', 
                organizer_name = '$organizerName', 
                organizer_email = '$organizerEmail', 
                modified_at = NOW()
              WHERE event_id = '$eventID'";

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

function uploadImage() {
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $error = $_FILES["image"]["error"];
    $tmpName = $_FILES["image"]["tmp_name"];

    // Check if the uploaded file is an image
    $validImageExtensions = ["jpg", "jpeg", "png", "webp"];
    $imageExtension = explode(".", $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtensions)) {
        echo "<script>alert('The file you uploaded is not an image!')</script>";
        return false;
    }

    // Check image file size
    if ($fileSize > 2000000) {
        echo "<script>alert('The image size is too large!')</script>";
        return false;
    }

    // Generate a new image name
    $newImageName = uniqid();
    $newImageName .= ".";
    $newImageName .= $imageExtension;

    // Image passed validation, ready to be uploaded
    move_uploaded_file($tmpName, "../public/img/uploads/" . $newImageName);
    return $newImageName;
}