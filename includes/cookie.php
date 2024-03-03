<?php
require_once "../scripts/database.php";

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {

    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash("sha256", $row["name"])) {
        $_SESSION["login"] = true;
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["name"] = $row["name"];
    }
}