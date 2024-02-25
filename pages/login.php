<?php
session_start();

include "../includes/header.php";
require "../scripts/functions.php";

if (isset($_POST["login"])) {
    
    if (loginAccount($_POST)) {
        header("location: home.php");
        exit;
    } else {
        echo "
            <script>
                alert('Name or password are wrong!');
                window.location.href = 'login.php';
            </script>";
    }
}

if (isset($_SESSION["login"])) {
    header("location: home.php");
    exit;
}
?>

<main>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col col-lg-10">
                <div class="card border rounded-4 shadow animate__animated animate__fadeInDown">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="../public/img/webp/event-img-4.webp" alt="Event Img" class="img-fluid rounded-start-4">
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-5 text-black">
                                <!-- Login Form Start -->
                                <form action="" method="post">
                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fa-solid fa-sign-in-alt fa-2xl me-3"></i>
                                        <span class="h2 fw-bold mb-0">Login</span>
                                    </div>
                                    <div class="h5 fw-normal mb-3 pb-3" style="letter-spacing: 1px;">
                                        Enter your email and password.
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="name@example.com">
                                        <label for="email">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="rememberMe" value="" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">
                                            Remember Me
                                        </label>
                                    </div>
                                    <div class="pt-1 mb-4 pb-2">
                                        <button class="btn btn-dark btn-lg w-100" type="submit" name="login" style="letter-spacing: 1.5px;">Login</button>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="text-muted text-center">Don't have an account? 
                                            <a href="register.php" class="text-muted">Register</a>
                                        </p>
                                        <a class="text-muted" href="#!">Forgot password?</a>
                                    </div>
                                </form>
                                <!-- Login Form End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>