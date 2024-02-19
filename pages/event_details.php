<?php
session_start();
include "../includes/header.logged.php";
include "../scripts/functions.php";

$eventID = $_GET['id'];
$events = sqlQuery("SELECT * FROM events WHERE event_id = $eventID");
?>

<main>
    <div class="container mt-5 pt-5">
        <div class="card border shadow p-4 p-lg-5">
            <div class="card-title h3 fw-bold mb-4">
                <i class="fa-solid fa-sm fa-info-circle me-3"></i>Event Details
            </div>
            <?php foreach ($events as $row): ?>
                <div class="overflow-hidden rounded-3 mb-4 w-100 detail-img" style="height: 400px;">
                    <img src="../public/img/webp/event-img-1.webp" class="img-fluid object-fit-cover h-100 w-100" alt="">
                </div>
                <div class="h3 mb-4 mb-lg-2"><?= $row['event_name']; ?></div>
                <div class="d-flex flex-wrap align-items-center justify-content-start text-secondary">
                    <div class="me-md-4 mb-2 mb-lg-4">
                        <i class="fa-solid fa-user-group me-2"></i>
                        <span><?= $row['organizer_name']; ?></span>
                    </div>
                    <div class="mb-2 mb-4">
                        <i class="fa-solid fa-envelope me-2"></i>
                        <span><?= $row['organizer_email']; ?></span>
                    </div>
                </div>
                <div class="mb-4 mb-lg-5">
                    <?= $row['event_description']; ?>
                </div>
                <div class="row g-2 g-md-3 g-lg-4 mb-2 mb-lg-4">
                    <div class="col-12 col-lg-6">
                        <div class="fw-medium mb-3">Event Date:</div>
                        <div class="mb-2"><?= $row['event_date']; ?></div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="fw-medium mb-3">Registration Deadline:</label>
                        <div class="mb-2"><?= $row['registration_deadline']; ?></div>
                    </div>
                </div>
                <div class="row g-0 g-md-1 g-lg-4">
                    <div class="col-12 col-lg-6">
                        <div class="form-label mb-3">
                            <label class="fw-medium mb-2">Max Participants:</label>
                            <input type="text" class="form-control-plaintext" value="<?= $row['max_participants']; ?>"
                                disabled readonly>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-label mb-3">
                            <label class="fw-medium mb-2">Event Fee:</label>
                            <input type="text" class="form-control-plaintext"
                                value="<?= $row['registration_fee'] == 0 ? "Free" : '$' . $row['registration_fee']; ?>"
                                disabled readonly>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>