<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventiqo</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="public/css/main.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Navbar Start -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow animate__animated animate__fadeInDown" aria-label="navbar">
            <div class="container-fluid mx-lg-5 mx-3 my-1">
                <div class="d-flex align-items-center">
                    <a class="navbar-brand" href="#">Eventiqo</a>
                    <span class="text-secondary me-3 mt-2 divider vr" style="height: 25px;"></span>
                    <span class="text-secondary date" style="font-size: 14px;"><?php include_once "../scripts/date.php"; ?></span>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-mobile" aria-controls="navbar-mobile" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="navbar-nav ms-auto gap-3 mt-2 mb-2 mt-lg-0 mb-lg-0">
                        <li class="nav-item">
                            <a class="btn btn-dark px-3" aria-current="page" href="pages/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light px-3" href="pages/signup.php"><i class="fa-solid fa-sm fa-user-plus me-2"></i>Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <header>
    <!-- Navbar End -->