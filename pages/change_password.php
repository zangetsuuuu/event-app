<?php
session_start();
ob_start();
$id = $_SESSION['user_id'];

include "../includes/header.logged.php";
require "../includes/session.php";
require "../scripts/functions.php";

if (isset($_POST["changePassword"])) {

    if (changePassword($_POST) > 0) {
        echo "
            <script>
                alert('Password changed!');
                window.location.href = 'change_password.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Password not changed!');
            </script>";
    }
}

else if (isset($_POST["logout"])) {
    logoutAccount();
    exit;
}
?>

<main>
    <div class="container mt-5 pt-5 mb-5">
        <div class="card border shadow p-4 p-lg-5 animate__animated animate__fadeInLeft animate__delay-1s">
            <div class="card-title h3 fw-bold mb-4 pb-3">
                <i class="fa-solid fa-sm fa-key me-3"></i>Change Password
            </div>

            <form action="" method="post">
                <input type="hidden" name="userID" value="<?= $id; ?>">
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="Old Password">
                    <label for="oldPassword">Old Password</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" name="newPassword" id="newPassword"
                        placeholder="New Password">
                    <label for="newPassword">New Password</label>
                </div>
                <button type="submit" name="changePassword" class="btn btn-dark w-100">Change Password</button>
            </form>
        </div>
    </div>

    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>