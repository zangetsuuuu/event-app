<?php
session_start();
include "../includes/header.logged.php";
require "../scripts/functions.php";

$events = sqlQuery("SELECT * FROM events");

if (isset($_POST["logout"])) {
    logoutAccount();
}
?>

<main>
    <div class="container mt-5 pt-5">
        <div class="d-flex mb-4 border-bottom animate__animated animate__fadeInDown animate__delay-1s">
            <div class="h3">Featured Events</div>
        </div>
        <div class="row g-4 d-flex justify-content-center">
            <?php foreach ($events as $row): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm animate__animated animate__fadeInLeft animate__delay-2s">
                        <div class="position-relative">
                            <img src="../public/img/uploads/<?= $row['event_image']; ?>"
                                class="card-img-top img-fluid object-fit-cover" alt="<?= $row['event_name']; ?>"
                                style="height: 220px;">
                            <div class="position-absolute bottom-0 start-0 px-3 py-2 w-100"
                                style="backdrop-filter: blur(6px); background-color: rgba(0, 0, 0, 0.2);">
                                <div class="d-flex justify-content-between" style="font-size: 14px;">
                                    <div class="text-light">
                                        <i class="fa-solid fa-calendar me-1"></i>
                                        <?= date('d M Y', strtotime($row['event_date'])); ?>
                                    </div>
                                    <div class="text-light">
                                        <?= $row['registration_fee'] == 0 ? "Free" : 'Rp. ' . number_format($row['registration_fee'], 0, ',', '.'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-2">
                                <?= $row['event_name']; ?>
                            </h5>
                            <p class="card-text text-secondary d-flex align-items-center">
                                <i class="fa-solid fa-xs fa-user-group me-2"></i>
                                <?= $row['organizer_name']; ?>
                            </p>
                            <p class="card-text mb-4 overflow-y-auto" style="height: 48px;">
                                <?= $row['event_description']; ?>
                            </p>
                            <div class="row g-2">
                                <div class="col-12 col-lg-10">
                                    <a href="#" class="btn btn-dark w-100">
                                        <i class="fa-solid fa-calendar-plus me-2"></i>Join Event
                                    </a>
                                </div>
                                <div class="col-12 col-lg-2">
                                    <a href="event_details.php?id=<?= $row['event_id']; ?>"
                                        class="btn btn-outline-secondary w-100">
                                        <i class="fa-solid fa-info-circle"></i>
                                        <span class="d-lg-none ms-2">Details</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>