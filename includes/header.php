<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $currentFile = basename($_SERVER['PHP_SELF']);
    $title = ucfirst(str_replace('_', ' ', pathinfo($currentFile, PATHINFO_FILENAME)));
    echo "<title>Eventiqo - $title</title>";
    ?>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>