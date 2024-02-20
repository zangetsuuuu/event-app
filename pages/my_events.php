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
        <div class="d-flex justify-content-between mb-4 border-bottom">
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
            <?php $no = 1; ?>
            <?php foreach ($events as $row): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="position-relative">
                            <img src="../public/img/uploads/<?= $row['event_image']; ?>"
                                class="card-img-top img-fluid object-fit-cover" alt="<?= $row['event_name']; ?>"
                                style="height: 220px;">
                            <div class="position-absolute bottom-0 start-0 px-3 py-1 w-100" style="backdrop-filter: blur(5px); background-color: rgba(0, 0, 0, 0.1);">
                                <div class="d-flex justify-content-between" style="font-size: 14px;">
                                    <div class="text-light">
                                        <i class="fa-solid fa-calendar me-1"></i>
                                        <?= date('d F Y', strtotime($row['event_date'])); ?>
                                    </div>
                                    <div class="text-light">
                                        <?= $row['registration_fee'] == 0 ? 'Free' : 'Rp. ' . $row['registration_fee']; ?>
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
                                <div class="overflow-y-auto" style="max-height: 3rem;">
                                    <?= $row['event_description']; ?>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-12 col-lg-8">
                                    <a href="#" class="btn btn-dark w-100">
                                        <i class="fa-solid fa-pen me-2"></i>Edit Event
                                    </a>
                                </div>
                                <div class="col-6 col-lg-2">
                                    <a href="event_partcipants.php?id=<?= $row['event_id']; ?>"
                                        class="btn btn-outline-secondary w-100">
                                        <i class="fa-solid fa-users"></i>
                                        <span class="d-lg-none ms-2">Participants</span>
                                    </a>
                                </div>
                                <div class="col-6 col-lg-2">
                                    <form action="" method="post">
                                        <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                                        <button type="submit" class="btn btn-outline-danger w-100" name="deleteEvent"
                                            onclick="return confirm('Delete <?= $row['event_name']; ?>?')">
                                            <i class="fa-solid fa-trash"></i>
                                            <span class="d-lg-none ms-2">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $no++ ?>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- My Events Card List End -->

    <!-- New Events Modal Start -->
    <div class="modal fade" id="newEvent" tabindex="-1" aria-labelledby="newEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newEventLabel">
                        <i class="fa-solid fa-calendar-day me-2"></i>New Event
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($users as $row): ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="userID" value="<?= $row['user_id']; ?>">
                            <div class="form-label mb-3">
                                <label for="eventName" class="fw-medium mb-2">Event Name</label>
                                <input type="text" class="form-control" name="eventName" id="eventName"
                                    placeholder="Enter event name" required>
                            </div>
                            <div class="form-label mb-3">
                                <label for="eventDesc" class="fw-medium mb-2">Description</label>
                                <textarea type="text" class="form-control" name="eventDesc" id="eventDesc"
                                    style="resize: none;" placeholder="Enter event description" required></textarea>
                            </div>
                            <div class="row g-0 g-md-1 g-lg-4">
                                <div class="col-12 col-lg-3">
                                    <div class="form-label mb-3">
                                        <label for="eventDate" class="fw-medium mb-2">Event Date</label>
                                        <input type="date" class="form-control" name="eventDate" id="eventDate"
                                            placeholder="Select event date" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-label mb-3">
                                        <label for="eventDeadline" class="fw-medium mb-2">Registration Deadline</label>
                                        <input type="date" class="form-control" name="eventDeadline" id="eventDeadline"
                                            placeholder="Select registration deadline" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-label mb-3">
                                        <label for="eventLoc" class="fw-medium mb-2">Location</label>
                                        <input type="text" class="form-control" name="eventLoc" id="eventLoc"
                                            placeholder="Enter event location" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-0 g-md-1 g-lg-4">
                                <div class="col-12 col-lg-3">
                                    <div class="form-label mb-3">
                                        <label for="maxParticipants" class="fw-medium mb-2">Max Participants</label>
                                        <input type="text" class="form-control" name="maxParticipants" id="maxParticipants"
                                            placeholder="e.g. 100" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="form-label mb-3">
                                        <label for="fee" class="fw-medium mb-2">Fee</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="fee" id="fee"
                                                placeholder="Rp.">
                                            <div class="input-group-append">
                                                <div class="input-group-text rounded-start-0">
                                                    <input type="checkbox" class="me-2" id="feeFree" name="feeFree">
                                                    <label for="feeFree" class="form-check-label">Free</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-label mb-3">
                                        <label for="eventImage" class="fw-medium mb-2">Image</label>
                                        <input type="file" class="form-control" name="image" id="eventImage" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-0 g-md-1 g-lg-4">
                                <div class="col-12 col-lg-6">
                                    <div class="form-label mb-3">
                                        <label for="organizerName" class="fw-medium mb-2">Organizer Name</label>
                                        <input type="hidden" name="organizerName" value="<?= $row['name']; ?>">
                                        <input type="text" class="form-control-plaintext" id="organizerName"
                                            value="<?= $row['name']; ?>" disabled readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-label mb-3">
                                        <label for="organizerEmail" class="fw-medium mb-2">Organizer Email</label>
                                        <input type="hidden" name="organizerEmail" value="<?= $row['email']; ?>">
                                        <input type="email" class="form-control-plaintext" id="organizerEmail"
                                            value="<?= $row['email']; ?>" disabled readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="createEvent" class="btn btn-success">
                                    <i class="fa-solid fa-plus me-2"></i>Create Event
                                </button>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- New Events Modal End -->
</main>

<?php include "../includes/footer.php"; ?>