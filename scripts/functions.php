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

    $name = htmlspecialchars(stripslashes($data["name"]));
    $email = htmlspecialchars(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // Check email if exist or not
    $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

    if (mysqli_fetch_assoc($result)) {
        echo "
            <script>
                alert('Email sudah terdaftar!');
            </script>";
        return false;
    }

    // Encrypt Password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Add to database
    mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

    // Add user id to user profiles
    $newUserID = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO user_profiles (user_id) VALUES ('$newUserID')");

    return mysqli_affected_rows($conn);
}

function loginAccount($data) {
    global $conn;

    $email = htmlspecialchars(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);

    // Check if data is available in the database
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        // Check password match
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {
            // Set session
            session_start();
            $_SESSION["login"] = true;
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["name"] = $row["name"];

            // Check remember me
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
    $_SESSION = [];
    session_destroy();

    header("Location: login.php");
    exit;
}

function createEvent($data) {
    global $conn;

    $userID = $data['userID'];
    $eventName = mysqli_real_escape_string($conn, htmlspecialchars($data['eventName']));
    $eventDesc = mysqli_real_escape_string($conn, htmlspecialchars($data['eventDesc']));
    $eventDate = mysqli_real_escape_string($conn, htmlspecialchars($data['eventDate']));
    $eventDeadline = mysqli_real_escape_string($conn, htmlspecialchars($data['eventDeadline']));
    $eventLocation = mysqli_real_escape_string($conn, htmlspecialchars($data['eventLoc']));
    $maxParticipants = mysqli_real_escape_string($conn, htmlspecialchars($data['maxParticipants']));
    $fee = isset($data['fee']) ? mysqli_real_escape_string($conn, htmlspecialchars($data['fee'])) : '0';
    $organizerName = mysqli_real_escape_string($conn, htmlspecialchars($data['organizerName']));
    $organizerEmail = mysqli_real_escape_string($conn, htmlspecialchars($data['organizerEmail']));    

    // Upload image
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
    $eventName = mysqli_real_escape_string($conn, htmlspecialchars($data['eventName']));
    $eventDesc = mysqli_real_escape_string($conn, htmlspecialchars($data['eventDesc']));
    $eventDate = mysqli_real_escape_string($conn, htmlspecialchars($data['eventDate']));
    $eventDeadline = mysqli_real_escape_string($conn, htmlspecialchars($data['eventDeadline']));
    $eventLocation = mysqli_real_escape_string($conn, htmlspecialchars($data['eventLoc']));
    $maxParticipants = mysqli_real_escape_string($conn, htmlspecialchars($data['maxParticipants']));
    $fee = isset($data['fee']) ? mysqli_real_escape_string($conn, htmlspecialchars($data['fee'])) : '0';
    $organizerName = mysqli_real_escape_string($conn, htmlspecialchars($data['organizerName']));
    $organizerEmail = mysqli_real_escape_string($conn, htmlspecialchars($data['organizerEmail']));
    $eventImage = '';

    // Fetch the old profile picture
    $query = sqlQuery("SELECT event_image FROM user_profiles WHERE event_id = '$eventID'");
    $oldEventImage = $query[0]['event_image'];

    if (!empty($_FILES['image']['name'])) {
        // If a new image is uploaded, delete the old one first
        if (!empty($oldEventImage)) {
            unlink("../public/img/uploads/" . $oldEventImage);
        }

        // Upload the new profile picture
        $eventImage = uploadImage();
        if (!$eventImage) {
            return false;
        }
    } else {
        $eventImage = $oldEventImage;
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

function searchEvent($keyword, $userID) {
    global $conn;
    global $currentFile;

    $query = "SELECT * FROM events WHERE
                (event_name LIKE '%$keyword%' OR
                event_date LIKE '%$keyword%' OR
                event_location LIKE '%$keyword%' OR
                max_participants LIKE '%$keyword%' OR
                registration_fee LIKE '%$keyword%' OR
                organizer_name LIKE '%$keyword%')";

    if ($currentFile == "my_events.php") {
        $query .= " AND user_id = '$userID'";
    }
    
    else if ($currentFile == "home.php") {
        $query .= " AND user_id != '$userID'";
    }

    else {
        $query = "SELECT events.* 
                  FROM participants 
                  JOIN events ON participants.event_id = events.event_id 
                  WHERE participants.user_id = '$userID' AND
                  (event_name LIKE '%$keyword%' OR
                  event_date LIKE '%$keyword%' OR
                  event_location LIKE '%$keyword%' OR
                  max_participants LIKE '%$keyword%' OR
                  registration_fee LIKE '%$keyword%' OR
                  organizer_name LIKE '%$keyword%')";
    }

    return sqlQuery($query);
}

function deleteEvent($data) {
    global $conn;

    $eventID = htmlspecialchars($data['eventID']);
    $query = "DELETE FROM events WHERE event_id = $eventID";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function joinEvent($data) {
    global $conn;

    $eventID = $data['eventID'];
    $userID = $data['userID'];

    $query = "INSERT INTO participants (event_id, user_id, registration_date) VALUES ('$eventID', '$userID', NOW())";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function unjoinEvent($data) {
    global $conn;

    $eventID = $data['eventID'];
    $userID = $data['userID'];

    $query = "DELETE FROM participants WHERE event_id = '$eventID' AND user_id = '$userID'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function isUserJoined($userID, $eventID) {
    global $conn;

    $query = "SELECT * FROM participants WHERE user_id = '$userID' AND event_id = '$eventID'";
    $result = mysqli_query($conn, $query);

    return mysqli_num_rows($result) > 0;
}

function isEventFull($eventID, $maxParticipants) {
    global $conn;

    $query = "SELECT COUNT(*) AS total FROM participants WHERE event_id = '$eventID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total = $row['total'];

        return $total == $maxParticipants;
    } else {
        return false;
    }
}

function isDatePassed($date) {
    $dateTimestamp = strtotime($date);
    $currentTimestamp = time();

    return $currentTimestamp > $dateTimestamp;
}

function timeToEvent($eventDate) {
    $eventTimestamp = strtotime($eventDate);
    $currentTimestamp = time();
    $difference = $eventTimestamp - $currentTimestamp;

    $days = floor($difference / (60 * 60 * 24));
    $hours = floor(($difference % (60 * 60 * 24)) / (60 * 60));

    // Construct the string for time remaining
    $timeRemaining = '';
    if ($days > 0) {
        $timeRemaining .= "$days days ";
    }
    if ($hours > 0) {
        $timeRemaining .= "$hours hours";
    }

    return trim($timeRemaining);
}

function editProfile($data) {
    global $conn;
    global $currentFile;

    $userID = $data['userID'];
    $username = mysqli_real_escape_string($conn, htmlspecialchars($data['username']));
    $bio = mysqli_real_escape_string($conn, htmlspecialchars($data['bio']));
    $birthdate = mysqli_real_escape_string($conn, htmlspecialchars($data['birthdate']));
    $address = mysqli_real_escape_string($conn, htmlspecialchars($data['address']));
    $profileImage = '';

    // Fetch the old profile picture
    $query = sqlQuery("SELECT profile_image FROM user_profiles WHERE user_id = '$userID'");
    $oldProfileImage = $query[0]['profile_image'];

    if (!empty($_FILES['image']['name'])) {
        // If a new image is uploaded, delete the old one first
        if (!empty($oldProfileImage)) {
            unlink("../public/img/avatars/" . $oldProfileImage);
        }

        // Upload the new profile picture
        $profileImage = uploadImage();
        if (!$profileImage) {
            return false;
        }
    } else {
        $profileImage = $oldProfileImage;
    }

    // Update the user profile with the new information
    $query = "UPDATE user_profiles SET
                username = '$username',
                bio = '$bio',
                profile_image = '$profileImage',
                date_of_birth = '$birthdate',
                address = '$address'
              WHERE user_id = '$userID'";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function uploadImage() {
    global $currentFile;

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $error = $_FILES["image"]["error"];
    $tmpName = $_FILES["image"]["tmp_name"];

    // Handle errors
    if ($error !== UPLOAD_ERR_OK) {
        echo "<script>alert('Error uploading image!')</script>";
        return false;
    }

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
    if ($currentFile == "my_events") {
        move_uploaded_file($tmpName, "../public/img/uploads/" . $newImageName);
    } else if ($currentFile == "profile.php") {
        move_uploaded_file($tmpName, "../public/img/avatars/" . $newImageName);
    }

    return $newImageName;
}