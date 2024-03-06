<?php
$pageData = 20;

if ($currentFile == 'home.php') {
    $queryCount = "SELECT COUNT(*) AS total FROM events";
}

else if ($currentFile == 'my_events.php') {
    $queryCount = "SELECT COUNT(*) AS total FROM events WHERE user_id = $id";
}

else if ($currentFile == 'joined_events.php') {
    $queryCount = "SELECT COUNT(*) AS total FROM participants WHERE user_id = $id";
}

$resultCount = mysqli_query($conn, $queryCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalRows = $rowCount['total'];

$totalPages = ceil($totalRows / $pageData);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $pageData;