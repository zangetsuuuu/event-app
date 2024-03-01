<?php
session_start();
ob_start();

include "../includes/header.logged.php";
require "../includes/session.php";
require "../scripts/functions.php";

$id = $_SESSION["user_id"];
$participants = [];

if (isset($_GET["id"])) {
    $eventID = htmlspecialchars($_GET["id"]);

    $isUserValid = sqlQuery("SELECT * FROM events WHERE event_id = '$eventID' AND user_id = '$id'");

    // Check if the user is the event owner
    if (!$isUserValid) {
        header("location: my_events.php");
        exit;
    }

    // Check if the event ID is a number
    if (is_numeric($eventID)) {
        $_SESSION["event_id"] = $eventID;
        $participants = sqlQuery("SELECT participants.*, users.name, users.email 
                                  FROM participants 
                                  INNER JOIN users ON participants.user_id = users.user_id 
                                  WHERE participants.event_id = '$eventID'
                                  ORDER BY participants.registration_date DESC");
    } else {
        $string = true;
    }
}

if (isset($_POST["logout"])) {
    logoutAccount();
    exit;
}
?>

<main>
    <!-- Event Participants Start -->
    <div class="container mt-5 pt-5 mb-5">
        <div class="card border shadow p-4 p-lg-5 animate__animated animate__fadeInLeft animate__delay-1s">
            <div class="card-title h3 fw-bold mb-3 mb-lg-4 pb-1 d-flex justify-content-between">
                <div>
                    <i class="fa-solid fa-sm fa-users me-3"></i>Participants
                </div>
                <form action="report.php" method="post" target="_blank">
                    <input type="hidden" name="eventID" value="<?= $eventID; ?>">
                    <button class="btn btn-outline-dark d-none d-lg-block" name="printReport" <?= (empty($participants)) ? 'disabled' : '' ?>>
                        <i class="fa-solid fa-file-pdf me-2"></i>Print
                    </button>
                    <button class="btn btn-outline-dark d-lg-none" name="printReport" <?= (empty($participants)) ? 'disabled' : '' ?>>
                        <i class="fa-solid fa-file-pdf"></i>
                    </button>
                </form>
            </div>

            <?php if (empty($participants)): ?>
                <div class="alert alert-light text-center" role="alert">
                    <i class="fa-solid fa-info-circle me-2 pe-1"></i>This Event Doesn't Have Any Participants!
                </div>
                <?php unset($participants); ?>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        <?php $no = 1; ?>
                        <?php foreach ($participants as $row): ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['email']; ?></td>
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