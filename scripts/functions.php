<?php
require "database.php";

function registerAccount($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
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
    mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
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
            $_SESSION["username"] = $row["username"];

            // Cek remember me
            if (isset($_POST["rememberMe"])) {
                // Set cookie
                setcookie("id", $row["id"], time() + 3600);
                setcookie("key", hash("sha256", $row["username"]), time() + 3600);
            }
            return true;
        }
    }
}