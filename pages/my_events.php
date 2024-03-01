<?php
session_start();
ob_start();

include "../includes/header.logged.php";
require "../includes/session.php";
require "../scripts/functions.php";

$id = $_SESSION["user_id"];
$events = sqlQuery("SELECT * FROM events WHERE user_id = '$id' ORDER BY created_at DESC");
$users = sqlQuery("SELECT * FROM users WHERE user_id = '$id'");

if (isset($_GET["keyword"])) {
    $keyword = htmlspecialchars($_GET["keyword"]);
    $events = searchEvent($keyword, $id);

    if (empty($events)) {
        $notFound = true;
    }
}

if (isset($_POST["createEvent"])) {

    if (createEvent($_POST) > 0) {
        echo "
            <script>
                alert('A new event has been successfully created!');
                window.location.href = 'my_events.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Event not created!');
            </script>";
    }
}

else if (isset($_POST["editEvent"])) {

    if (editEvent($_POST) > 0) {
        echo "
            <script>
                alert('Changes saved!');
                window.location.href = 'my_events.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Changes not saved!');
            </script>";
    }
}

else if (isset($_POST["deleteEvent"])) {

    if (deleteEvent($_POST) > 0) {
        echo "
            <script>
                alert('Event has been deleted!');
                window.location.href = 'my_events.php';
            </script>";
    } else {
        echo "
            <script>
                alert('Something wrong!');
            </script>";
    }
}

else if (isset($_POST["logout"])) {
    logoutAccount();
    exit;
}
?>

<main>
    <!-- My Events Card List Start -->
    <div class="container mt-5 pt-5">
        <div
            class="d-flex justify-content-between mb-4 border-bottom animate__animated animate__fadeInDown animate__delay-1s">
            <div class="h3">My Events</div>
            <button class="btn btn-link text-success" data-bs-toggle="modal" data-bs-target="#newEvent">
                <i class="fa-solid fa-plus me-2"></i>New Event
            </button>
        </div>

        <?php if (empty($events) && !isset($notFound)): ?>
            <div class="alert alert-light text-center animate__animated animate__fadeInDown animate__delay-1s" role="alert">
                <i class="fa-solid fa-warning me-2 pe-1"></i>You don't have an event
            </div>
        <?php elseif (isset($notFound)): ?>
            <div class="alert alert-danger text-center animate__animated animate__fadeInDown animate__delay-1s"
                role="alert">
                <i class="fa-solid fa-warning me-2 pe-1"></i>No event found
            </div>
            <?php unset($notFound); ?>
        <?php endif; ?>


        <div class="row g-4 d-flex justify-content-start">
            <?php foreach ($events as $row): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm animate__animated animate__fadeInLeft animate__delay-1s">
                        <!-- Card content -->
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
                            <h5 class="card-title fw-bold mb-2 text-truncate">
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
                                <div class="col-12 col-lg-4">
                                    <div class="dropup">
                                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button"
                                            id="eventMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="eventMenu">
                                            <li>
                                                <a class="dropdown-item" href="event_details.php?id=<?= $row['event_id']; ?>">Details</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="event_participants.php?id=<?= $row['event_id']; ?>">Participants</a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="btn btn-link dropdown-item text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteID<?= $row['event_id']; ?>">
                                                    <i class="fa-solid fa-trash me-2"></i>Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include "../includes/events.edit.php"; ?>

                <?php include "../includes/events.delete.php"; ?>

            <?php endforeach; ?>
        </div>
    </div>
    <!-- My Events Card List End -->

    <?php include "../includes/events.create.php"; ?>

    <?php include "../includes/events.search.php"; ?>

    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>