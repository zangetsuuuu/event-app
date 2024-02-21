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
                    <div class="card shadow-sm animate__animated animate__fadeInLeft animate__delay-2s">
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

                <!-- Modal konfirmasi penghapusan untuk event ini -->
                <div class="modal fade" id="deleteID<?= $row['event_id']; ?>" tabindex="-1" aria-labelledby="deleteLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="text-center mb-4">
                                    <svg clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round"
                                        stroke-miterlimit="2" viewBox="0 0 24 24" width="80" height="80" fill="#DC3545"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="m20.015 6.506h-16v14.423c0 .591.448 1.071 1 1.071h14c.552 0 1-.48 1-1.071 0-3.905 0-14.423 0-14.423zm-5.75 2.494c.414 0 .75.336.75.75v8.5c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-8.5c0-.414.336-.75.75-.75zm-4.5 0c.414 0 .75.336.75.75v8.5c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-8.5c0-.414.336-.75.75-.75zm-.75-5v-1c0-.535.474-1 1-1h4c.526 0 1 .465 1 1v1h5.254c.412 0 .746.335.746.747s-.334.747-.746.747h-16.507c-.413 0-.747-.335-.747-.747s.334-.747.747-.747zm4.5 0v-.5h-3v.5z"
                                            fill-rule="nonzero" />
                                    </svg>

                                    <p class="mt-3">
                                        Are you sure you want to delete "<?= $row['event_name']; ?>"?
                                    </p>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <button type="button" class="btn btn-outline-secondary w-50"
                                        data-bs-dismiss="modal">Cancel
                                    </button>
                                    <form action="" method="post" class="w-50">
                                        <input type="hidden" name="eventID" value="<?= $row['event_id']; ?>">
                                        <button type="submit" name="deleteEvent"
                                            class="btn btn-danger w-100">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- My Events Card List End -->

    <!-- New Events Modal Start -->
    <div class="modal fade" id="newEvent" tabindex="-1" aria-labelledby="newEventLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bold" id="newEventLabel">
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
                                        <label for="eventDate" class="fw-medium mb-2">Date</label>
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
                                            <input type="text" class="form-control" name="fee" id="fee" placeholder="Rp.">
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

    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>