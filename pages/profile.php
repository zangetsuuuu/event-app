<?php
session_start();
ob_start();

include "../includes/header.logged.php";
require "../includes/session.php";
require "../scripts/functions.php";

$id = $_SESSION['user_id'];
$profile = sqlQuery("SELECT * FROM user_profiles WHERE user_id = '$id'");

if (isset($_POST["editProfile"])) {

    if (editProfile($_POST) > 0) {
        echo "
            <script>
                alert('Profile updated!');
                window.location.href = 'profile.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Profile not updated!');
            </script>";
    }
}

else if (isset($_POST["logout"])) {
    logoutAccount();
    exit;
}
?>

<main>
    <!-- Event Details Card Start -->
    <div class="container mt-5 pt-5 mb-5">
        <div class="card border shadow p-4 p-lg-5 animate__animated animate__fadeInLeft animate__delay-1s">
            <div class="card-title h3 fw-bold mb-4 pb-3">
                <i class="fa-solid fa-sm fa-user-circle me-3"></i>Profile
            </div>

            <?php foreach ($profile as $row): ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="userID" value="<?= $id; ?>">
                    <div class="row g-5 row-gap-5">
                        <div class="col-12 col-lg-4">
                            <div class="mx-auto" style="width: 280px; height: 280px;">
                                <?php if (empty($row['profile_image'])): ?>
                                    <img src="../public/img/avatars/blank_avatar.png"
                                        class="img-fluid object-fit-cover rounded-circle border border-2 h-100 w-100 shadow" alt="">
                                <?php else: ?>
                                    <img src="../public/img/avatars/<?= $row['profile_image']; ?>"
                                        class="img-fluid object-fit-cover rounded-circle border border-2 h-100 w-100 shadow" alt="">
                                <?php endif; ?>
                                <div class="text-center mt-4">
                                    <label for="image" class="btn btn-sm btn-outline-secondary">Change Image</label>
                                    <input type="file" name="image" id="image" class="form-control d-none">
                                    <div id="file-name" class="mt-3" style="font-size: 14px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="form-label mb-3">
                                <label for="username" class="fw-medium mb-2">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?= $row['username']; ?>" placeholder="Enter username">
                            </div>
                            <div class="form-label mb-3">
                                <label for="birthdate" class="fw-medium mb-2">Birthdate</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?= !empty($row['date_of_birth']) ? date('Y-m-d', strtotime($row['date_of_birth'])) : '' ?>">
                            </div>
                            <div class="form-label mb-3">
                                <label for="bio" class="fw-medium mb-2">Bio</label>
                                <textarea class="form-control" name="bio" id="bio" cols="30" rows="3" style="resize: none;" placeholder="Enter bio"><?= $row['bio']; ?></textarea>
                            </div>
                            <div class="form-label mb-3">
                                <label for="address" class="fw-medium mb-2">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="3" style="resize: none;" placeholder="Enter address"><?= $row['address']; ?></textarea>
                            </div>
                            <button type="submit" name="editProfile" class="btn btn-dark mt-3 w-100">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Event Details Card End -->

    <?php include "../includes/events.join.php"; ?>

    <!-- Full Image Start -->
    <div class="modal fade" id="eventFullImage" tabindex="-1" aria-labelledby="fullImage" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <?php foreach ($events as $row): ?>
                        <img src="../public/img/uploads/<?= $row['event_image']; ?>"
                            class="img-fluid object-fit-cover rounded-3 border border-2 h-100 w-100"
                            alt="<?= $row['event_name']; ?>">
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Image End -->

    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>