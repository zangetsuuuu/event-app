<?php include '../includes/header.guest.php'; ?>

<main>
    <div class="px-4 pt-5 mt-2 text-center">
        <h1 class="display-4 fw-bold">Welcome to Eventiqo!</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Our platform are offering unforgettable experiences in the world of events. Discover thousands of exciting events across various categories to suit your taste. Join now to gain exclusive access and don't miss out on special moments!</p>
            <div class="d-grid gap-1 d-sm-flex justify-content-sm-center mb-5">
                <a href="pages/signup.php">
                    <button type="button" class="btn btn-dark btn-lg px-4 me-sm-3"><i class="fa-solid fa-location-arrow me-3"></i>Get Started!</button>
                </a>
            </div>
        </div>
        <div class="overflow-hidden" style="max-height: 50vh;">
            <div class="container px-5">
                <img src="public/img/event-img-1.jpg" class="img-fluid border rounded-3 shadow-lg mb-4"
                    alt="Example image" width="700" height="500" loading="lazy">
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>