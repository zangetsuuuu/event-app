<?php
session_start();
ob_start();

include "../includes/header.logged.php";
require "../includes/session.php";
require "../scripts/functions.php";

$id = $_SESSION['user_id'];
$events = [];

if (isset($_GET['id'])) {
    $eventID = htmlspecialchars($_GET['id']);

    // Check if the event ID is a number
    if (is_numeric($eventID)) {
        $events = sqlQuery("SELECT * FROM events WHERE event_id = '$eventID'");
        $totalParticipants = sqlQuery("SELECT COUNT(*) AS total FROM participants WHERE event_id = '$eventID'");
    } else {
        $notNumeric = true;
    }
}

if (isset($_POST["joinEvent"])) {

    if (joinEvent($_POST) > 0) {
        echo "
            <script>
                alert('You have joined the event!');
                window.location.href = 'joined_events.php';
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
    <!-- Event Details Card Start -->
    <div class="container mt-5 pt-5 mb-5">
        <div class="card border shadow p-4 p-lg-5 animate__animated animate__fadeInLeft animate__delay-1s">
            <div class="card-title h3 fw-bold mb-4">
                <i class="fa-solid fa-sm fa-info-circle me-3"></i>Event Details
            </div>

            <?php if (empty($events)): ?>
                <div class="alert alert-danger text-center" role="alert">Event Doesn't Exist!</div>
            <?php elseif (isset($notNumeric)): ?>
                <div class="alert alert-danger text-center" role="alert">Something Wrong!</div>
            <?php endif; ?>

            <?php foreach ($events as $row): ?>
                <div class="position-relative rounded-3 mb-4 w-100 detail-img" style="height: 400px;">
                    <img src="../public/img/uploads/<?= $row['event_image']; ?>"
                        class="img-fluid object-fit-cover rounded-3 border border-2 h-100 w-100"
                        alt="<?= $row['event_name']; ?>">
                    <button class="btn btn-outline-secondary btn-sm position-absolute top-0 end-0 m-3"
                        data-bs-toggle="modal" data-bs-target="#eventFullImage"><i
                            class="fa-solid fa-arrows-up-down-left-right"></i>
                    </button>
                </div>
                <div class="h3 mb-4 mb-md-3">
                    <?= $row['event_name']; ?>
                </div>
                <div class="row g-0 g-md-2 text-secondary mb-3 mb-lg-0">
                    <div class="col-md-auto me-md-4 mb-2 mb-lg-4">
                        <i class="fa-solid fa-user-group me-2"></i>
                        <span>
                            <?= $row['organizer_name']; ?>
                        </span>
                    </div>
                    <div class="col-md-auto me-md-4 mb-2 mb-lg-4">
                        <i class="fa-solid fa-envelope me-2"></i>
                        <span>
                            <?= $row['organizer_email']; ?>
                        </span>
                    </div>
                    <div class="col-md-auto me-md-4 mb-2 mb-lg-4">
                        <i class="fa-solid fa-clock me-2"></i>
                        <span>Created on
                            <?= date('d M Y', strtotime($row['created_at'])); ?>
                        </span>
                    </div>
                </div>
                <div class="mb-1 mb-lg-2">
                    <div>
                        <?= $row['event_description']; ?>
                    </div>
                </div>
                <hr class="w-25">
                <div class="row g-4 mb-2 mb-lg-4 pt-3 pb-lg-1">
                    <div class="col-12 col-lg-6">
                        <div class="fw-semibold mb-2 pb-1">Datetime:</div>
                        <div><?= date('d F Y, H:i', strtotime($row['event_date'])); ?> WIB</div>
                    </div>
                    <div class="col-12 col-lg-6 mb-2 pb-2 mb-lg-0 pb-lg-0">
                        <label class="fw-semibold mb-2 pb-1">Registration Deadline:</label>
                        <div><?= date('d F Y, H:i', strtotime($row['registration_deadline'])); ?> WIB</div>
                    </div>
                </div>
                <div class="row g-4 mb-2 mb-lg-4 pb-lg-1">
                    <div class="col-12 col-lg-6">
                        <label class="fw-semibold mb-2 pb-1">Participants:</label>
                        <?php foreach ($totalParticipants as $participants): ?>
                            <div><?= $participants['total'] . '/' . $row['max_participants']; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-12 col-lg-6 mb-2 pb-2 mb-lg-0 pb-lg-0">
                        <label class="fw-semibold mb-2 pb-1">Fee:</label>
                        <div>
                            <?= $row['registration_fee'] == 0 ? "Free" : 'Rp. ' . number_format($row['registration_fee'], 0, ',', '.'); ?>
                        </div>
                    </div>
                </div>
                <div class="mb-4 pb-2">
                    <label class="fw-semibold mb-2 pb-1">Location:</label>
                    <div><?= $row['event_location']; ?></div>
                </div>
                <?php if ($row['user_id'] != $id): ?>
                    <?php
                    $isJoined = isUserJoined($id, $row['event_id']);
                    $isFull = isEventFull($row['event_id'], $row['max_participants']);
                    $isPassed = isDatePassed($row['registration_deadline']);
                    $isUpcoming = timeToEvent($row['event_date']);
                    $isEventPassed = isDatePassed($row['event_date']);
                    ?>
                    <?php if ($isUpcoming && $isJoined): ?>
                        <button class="btn btn-dark w-100" disabled>
                            <i class="fa-solid fa-hourglass-start me-2"></i>
                            <?= $isUpcoming; ?>
                        </button>
                    <?php elseif ($isFull && !$isPassed): ?>
                        <button class="btn btn-danger w-100" disabled>
                            <i class="fa-solid fa-calendar-xmark me-2"></i>Event Full
                        </button>
                    <?php elseif ($isPassed && !$isJoined): ?>
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="fa-solid fa-lock me-2"></i>Closed
                        </button>
                    <?php elseif ($isEventPassed && $isJoined): ?>
                        <button class="btn btn-success w-100" disabled>
                            <i class="fa-solid fa-check me-2"></i>Event Passed
                        </button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#joinID<?= $eventID; ?>">
                            <i class="fa-solid fa-calendar-plus me-2"></i>Join Event
                        </button>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="event_participants.php?id=<?= $row['event_id']; ?>" class="btn btn-dark w-100">
                        <i class="fa-solid fa-users me-2"></i>Participants
                    </a>
                <?php endif; ?>
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