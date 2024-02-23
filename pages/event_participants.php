<?php
session_start();
include "../includes/header.logged.php";
require "../includes/session.php";
require "../scripts/functions.php";

$id = $_SESSION['user_id'];
$participants = [];

if (isset($_GET['id'])) {
    $eventID = htmlspecialchars($_GET['id']);

    // Check if the event ID is a number
    if (is_numeric($eventID)) {
        $participants = sqlQuery("SELECT participants.*, users.name 
                                  FROM participants 
                                  INNER JOIN users ON participants.user_id = users.user_id 
                                  WHERE participants.event_id = '$eventID'");
    } else {
        $string = true;
    }
}

if (isset($_POST["logout"])) {
    logoutAccount();
}
?>

<main>
    <!-- Event Participants Start -->
    <div class="container mt-5 pt-5 mb-5">
        <div class="card border shadow p-4 p-lg-5 animate__animated animate__fadeInLeft animate__delay-1s">
            <div class="card-title h3 fw-bold mb-4">
                <i class="fa-solid fa-sm fa-users me-3"></i>Event Participants
            </div>

            <?php if (empty($participants)): ?>
                <div class="alert alert-light text-center" role="alert">
                    This Event Doesn't Have Any Participants!
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($participants as $row): ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $row['name']; ?></td>
                                    <td>
                                        <?= date('d F Y, H:i', strtotime($row['registration_date'])); ?> WIB
                                    </td>
                                </tr>
                            <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Event Participants End -->

    <?php include "../includes/logout.popup.php"; ?>
</main>

<?php include "../includes/footer.php"; ?>