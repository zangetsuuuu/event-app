<?php
require_once __DIR__ . "/../vendor/autoload.php";
require "../scripts/functions.php";

use \Mpdf\Mpdf;

$mpdf = new Mpdf(['mode' => 'utf-8', 'format'  => [240, 297]]);

$eventID = htmlspecialchars($_POST["eventID"]);

$participants = sqlQuery("SELECT participants.*, users.name, users.email 
                              FROM participants 
                              INNER JOIN users ON participants.user_id = users.user_id 
                              WHERE participants.event_id = '$eventID'
                              ORDER BY participants.registration_date DESC");

$events = sqlQuery("SELECT * FROM events WHERE event_id = '$eventID'");
$eventName = $events[0]['event_name'];
$eventDate = $events[0]['event_date'];
$eventLocation = $events[0]['event_location'];
$eventOrganizer = $events[0]['organizer_name'];
$organizerEmail = $events[0]['organizer_email'];

$html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Participants Report</title>
        <link rel="stylesheet" href="../public/css/report.css">
    </head>
    <body>
        <h1 class="event-title">' . $eventName . '</h1>
        <div class="event-info">
            <table>
                <tr>
                    <td>Datetime:</td>
                    <td>' . date('d M Y, H:i', strtotime($eventDate)) . ' WIB</td>
                </tr>
                <tr>
                    <td>Location:</td>
                    <td>' . $eventLocation . '</td>
                </tr>
                <tr>
                    <td>Organizer:</td>
                    <td>' . $eventOrganizer . '</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>' . $organizerEmail . '</td>
                </tr>
            </table>
        </div>

        <h2 class="table-title">Participants</h2>

        <table>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registration Date</th>
            </tr>';

$no = 1;
foreach ($participants as $row) {
    $html .= '
            <tr>
                <td>' . $no . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . date('d F Y, H:i', strtotime($row['registration_date'])) . ' WIB</td>
            </tr>';
    $no++;
}

$html .= '
        </table>
    </body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output('event-participants-report-' . $eventID . '.pdf', \Mpdf\Output\Destination::INLINE);