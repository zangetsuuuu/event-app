<?php
$pageData = 20;

$queryCount = "SELECT COUNT(*) AS total FROM events";
$resultCount = mysqli_query($conn, $queryCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalRows = $rowCount['total'];

$totalPages = ceil($totalRows / $pageData);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $pageData;