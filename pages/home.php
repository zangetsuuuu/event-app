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
    <div class="container mt-5">
        <div class="row g-4 d-flex justify-content-center">
            <?php foreach ($events as $row): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm" style="width: 22rem;">
                    <img src="../public/img/webp/event-img-3.webp" class="card-img-top img-fluid" alt="...">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-1"><?= $row['event_name']; ?></h5>
                        <p class="card-text text-secondary"><?= $row['organizer_name']; ?></p>
                        <p class="card-text mb-4 overflow-y-auto" style="max-height: 3rem;"><?= $row['event_description']; ?></p>
                        <div class="row g-2">
                            <div class="col-12 col-lg-8">
                                <a href="#" class="btn btn-dark w-100">Join Event</a>
                            </div>
                            <div class="col-12 col-lg-4">
                                <a href="#" class="btn btn-outline-secondary w-100">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include "../includes/footer.php"; ?>