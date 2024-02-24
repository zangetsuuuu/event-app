<?php
session_start();
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
}
?>

<main>
    <!-- Event Details Card Start -->
    <div class="container mt-5 pt-5 mb-5">
        <div class="card border shadow p-4 p-lg-5 animate__animated animate__fadeInLeft animate__delay-1s">
            <div class="card-title h3 fw-bold mb-4">
                <i class="fa-solid fa-sm fa-info-circle me-3"></i>Event Details
            </div>

            <!-- If event id doesn't exist Start -->
            <?php if (empty($events)): ?>
                <div class="alert alert-danger text-center" role="alert">Event Doesn't Exist!</div>
            <?php endif; ?>
            <!-- If event id doesn't exist End -->

            <!-- If event id is string Start -->
            <?php if (isset($notNumeric)): ?>
                <div class="alert alert-danger text-center" role="alert">Something Wrong!</div>
            <?php endif; ?>
            <!-- If event id is string End -->

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
                <div class="row g-2 g-md-3 g-lg-4 mb-2 mb-lg-4 pt-3">
                    <div class="col-12 col-lg-6">
                        <div class="fw-medium mb-3">Date:</div>
                        <div class="mb-2">
                            <?= date('d F Y', strtotime($row['event_date'])); ?>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="fw-medium mb-3">Registration Deadline:</label>
                        <div class="mb-2">
                            <?= date('d F Y', strtotime($row['registration_deadline'])); ?>
                        </div>
                    </div>
                </div>
                <div class="row g-0 g-md-1 g-lg-4 mb-2 mb-lg-4">
                    <div class="col-12 col-lg-6">
                        <label class="fw-medium mb-2">Participants:</label>
                        <?php foreach ($totalParticipants as $participants): ?>
                            <input type="text" class="form-control-plaintext" value="<?= $participants['total'] . '/' . $row['max_participants']; ?>">
                        <?php endforeach; ?>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="fw-medium mb-2">Fee:</label>
                        <input type="text" class="form-control-plaintext"
                            value="<?= $row['registration_fee'] == 0 ? "Free" : 'Rp. ' . number_format($row['registration_fee'], 0, ',', '.'); ?>">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="fw-medium mb-2">Location:</label>
                    <input type="text" class="form-control-plaintext" value="<?= $row['event_location']; ?>">
                </div>
                <?php if ($row['user_id'] != $id): ?>
                    <?php $isJoined = isUserJoined($id, $row['event_id']); ?>
                    <?php $isFull = isEventFull($row['event_id'], $row['max_participants']); ?>
                    <form action="" method="post">
                        <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                        <input type="hidden" name="userID" value="<?= $id; ?>">
                        <?php if ($isJoined): ?>
                            <button class="btn btn-dark w-100" name="joinEvent" disabled>
                                <i class="fa-solid fa-calendar-check me-2"></i>Joined
                            </button>
                        <?php elseif ($isFull): ?>
                            <button class="btn btn-danger w-100" name="joinEvent" disabled>
                                <i class="fa-solid fa-lock me-2"></i>Event Full
                            </button>
                        <?php else: ?>
                            <button class="btn btn-dark w-100" name="joinEvent">
                                <i class="fa-solid fa-calendar-plus me-2"></i>Join Event
                            </button>
                        <?php endif; ?>
                    </form>
                <?php else: ?>
                    <a href="event_participants.php?id=<?= $row['event_id']; ?>" class="btn btn-dark w-100">
                        <i class="fa-solid fa-users me-2"></i>Participants
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Event Details Card End -->

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