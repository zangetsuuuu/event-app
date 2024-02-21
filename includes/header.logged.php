<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $currentFile = basename($_SERVER['PHP_SELF']);
    $title = ucwords(str_replace('_', ' ', pathinfo($currentFile, PATHINFO_FILENAME)));
    echo "<title>Eventiqo - $title</title>";
    ?>
    <link rel="shortcut icon" href="../public/img/favicon/favicon-1.svg" type="image/x-icon">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../public/css/main.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow animate__animated animate__fadeInDown" style="z-index: 999;">
            <div class="container-fluid mx-lg-5 mx-3 my-1">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand d-flex align-items-center" href="home.php">
                        <img src="../public/img/favicon/favicon-1.svg" class="me-2 pe-1" height="24" alt="">
                        <span>Eventiqo</span>
                    </a>
                    <span class="text-secondary me-3 mt-2 divider vr" style="height: 25px;"></span>
                    <span class="text-secondary date" style="font-size: 14px;">
                        <?php include_once "../scripts/date.php"; ?>
                    </span>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-mobile" aria-controls="navbar-mobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="navbar-nav ms-auto gap-3 mt-2 mb-2 mt-lg-0 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentFile == 'home.php') ? 'active' : ''; ?>" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentFile == 'my_events.php') ? 'active' : ''; ?>" href="my_events.php">My Events</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" id="settings" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>
                            <ul class="dropdown-menu" aria-labelledby="settings">
                                <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="btn btn-link dropdown-item text-danger fw-bold" data-bs-toggle="modal" data-bs-target="#logoutPopup">
                                        <i class="fa-solid fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Search">
                                <button class="btn btn-outline-light" type="submit">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header>