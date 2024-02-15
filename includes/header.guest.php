<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventiqo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/main.css">
    <script src="https://kit.fontawesome.com/a404219d80.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navbar Start -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="navbar">
            <div class="container-fluid mx-5 my-1">
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
                            <a class="btn btn-outline-light px-3" href="pages/signup.php"><i class="fa-solid fa-sm fa-user-plus me-2"></i>Sign Up</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <header>
    <!-- Navbar End -->