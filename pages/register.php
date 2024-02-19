<?php
include "../includes/header.php";
require "../scripts/functions.php";

if (isset($_POST["register"])) {
    
    if (registerAccount($_POST) > 0) {
        echo "
            <script>
                alert('User baru berhasil ditambahkan!');
                document.location.href = 'login.php';
            </script>";
    } else {
        echo "
            <script>
                document.location.href = 'register.php';
            </script>";
    }
}
?>

<main>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col col-lg-10">
                <div class="card border rounded-4 shadow animate__animated animate__fadeInDown">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-5 d-none d-md-block">
                            <img src="../public/img/webp/event-img-2.webp" alt="Event Img" class="img-fluid rounded-start-4">
                        </div>
                        <div class="col-md-6 col-lg-7 d-flex align-items-center">
                            <div class="card-body p-5 text-black">
                                <form action="" method="post">
                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <i class="fa-solid fa-user-plus fa-2xl me-3"></i>
                                        <span class="h2 fw-bold mb-0">Register</span>
                                    </div>
                                    <div class="h5 fw-normal mb-3 pb-3" style="letter-spacing: 1px;">
                                        Create an account.
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="John Doe" required>
                                        <label for="name">Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="name@example.com" required>
                                        <label for="email">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="8" required>
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="pt-1 mb-4 pb-2">
                                        <button class="btn btn-dark btn-lg w-100" type=submit" name="register" style="letter-spacing: 1.5px;">
                                            Register
                                        </button>
                                    </div>
                                    <p class="text-muted text-center">Already have an account? 
                                        <a href="login.php" class="text-muted">Login</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>