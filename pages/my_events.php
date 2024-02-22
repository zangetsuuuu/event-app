<?php
session_start();
include "../includes/header.logged.php";
require "../scripts/functions.php";

$id = $_SESSION['user_id'];
$events = sqlQuery("SELECT * FROM events WHERE user_id = '$id'");
$users = sqlQuery("SELECT * FROM users WHERE user_id = '$id'");

if ($events == null) {
    $noData = true;
}

if (isset($_POST['createEvent'])) {

    if (createEvent($_POST) > 0) {
        echo "
            <script>
                alert('New Event Has Been Successfully Created!');
                window.location.href = 'my_events.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Something Wrong!');
            </script>";
    }
}

else if (isset($_POST["editEvent"])) {
    
    if (editEvent($_POST) > 0) {
        echo "
            <script>
                alert('Data saved!');
                document.location.href = 'my_events.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Data not saved!');
                document.location.href = 'my_events.php';
            </script>";
    }
}

else if (isset($_POST['deleteEvent'])) {

    if (deleteEvent($_POST) > 0) {
        echo "
            <script>
                alert('Event Has Been Deleted!');
                window.location.href = 'my_events.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Something Wrong!');
            </script>";
    }
}

else if (isset($_POST["logout"])) {
    logoutAccount();
}
?>

<main>
    <!-- My Events Card List Start -->
    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between mb-4 border-bottom animate__animated animate__fadeInDown animate__delay-1s">
            <div class="h3">My Events</div>
            <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#newEvent">
                <i class="fa-solid fa-plus me-2"></i>New Event
            </button>
        </div>

        <!-- If user don't have an event Start -->
        <?php if (isset($noData)): ?>
            <div class="alert alert-light text-center" role="alert">You don't have an event</div>
        <?php endif; ?>
        <!-- If user don't have an event End -->

        <div class="row g-4 d-flex justify-content-center">
            <?php foreach ($events as $row): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm animate__animated animate__fadeInUp animate__delay-1s">
                        <!-- Isi card event -->
                        <div class="position-relative">
                            <img src="../public/img/uploads/<?= $row['event_image']; ?>"
                                class="card-img-top img-fluid object-fit-cover" alt="<?= $row['event_name']; ?>"
                                style="height: 220px;">
                            <div class="position-absolute bottom-0 start-0 px-3 py-2 w-100"
                                style="backdrop-filter: blur(6px); background-color: rgba(0, 0, 0, 0.1);">
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
                            <div class="card-text mb-4">
                                <div class="overflow-y-auto" style="height: 48px;">
                                    <?= $row['event_description']; ?>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-12 col-lg-8">
                                    <button class="btn btn-dark w-100" data-bs-toggle="modal"
                                        data-bs-target="#editID<?= $row['event_id']; ?>">
                                        <i class="fa-solid fa-pen me-2"></i>Edit Event
                                    </button>
                                </div>
                                <div class="col-6 col-lg-2">
                                    <a href="event_details.php?id=<?= $row['event_id']; ?>"
                                        class="btn btn-outline-secondary w-100">
                                        <i class="fa-solid fa-info-circle"></i>
                                        <span class="d-lg-none ms-2">Details</span>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-2">
                                    <button class="btn btn-outline-danger w-100" data-bs-toggle="modal"
                                        data-bs-target="#deleteID<?= $row['event_id']; ?>">
                                        <i class="fa-solid fa-trash"></i>
                                        <span class="d-lg-none ms-2">Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit event Start -->
                <?php include "../includes/events.edit.php"; ?>
                <!-- Edit event End -->

                <!-- Delete event Start -->
                <?php include "../includes/events.delete.php"; ?>
                <!-- Delete event End -->

            <?php endforeach; ?>
        </div>
    </div>
    <!-- My Events Card List End -->

    <!-- New Events Modal Start -->
    <?php include "../includes/events.create.php"; ?>
    <!-- New Events Modal End -->

    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>