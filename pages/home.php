<?php
include "../includes/header.php";
session_start();
?>

<main>
    <?= $_SESSION["username"]; ?>
</main>