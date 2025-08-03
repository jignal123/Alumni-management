<?php
include ("../dbconfig.php");
$path = basename($_SERVER['PHP_SELF']);
studentlogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../admin/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/8e55652a63.js" crossorigin="anonymous"></script>
    <script src="../jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="magnific-popup.css">
    <link rel="stylesheet" href="student_style.css">
</head>

<body>
    <div class="loader">
    </div>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <img src="../admin/logo.jpg" alt="" class="img-fluid" style="height: 4vw;">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end offset-4" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                        Menu
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav flex-grow-1 pe-3">
                        <li>
                            <a class="nav-link <?= $path == "index.php" ? "actives" : "" ?>" href="index.php"><i
                                    class="fa-solid fa-house mt-1 pe-1"></i>Home</a>
                        </li>
                        <li>
                            <a class="nav-link <?= $path == "alumni.php" ? "actives" : "" ?>"
                                href="<?= $_SESSION["status"] == "v" ? "alumni.php" : "index.php?denied=1" ?>"><i
                                    class="fa-solid fa-user-graduate pe-1"></i>Alumni</a>
                        </li>
                        <li>
                            <a class="nav-link <?= $path == "event.php" || $path == "view_event.php" ? "actives" : "" ?>"
                                href="event.php"><i class="fa-solid fa-calendar-days mt-1 pe-1"></i>Events</a>
                        </li>
                        <li class="li">
                            <a class="nav-link <?= $path == "eventsforgallery.php" || $path == "eventgallery.php" ? "actives" : "" ?>"
                                href="eventsforgallery.php"><i class="fa-regular fa-images mt-1 pe-1"></i>Gallery</a>
                        </li>
                        <li class="li">
                            <a class="nav-link <?= $path == "profile.php" || $path == "changepassword.php" ? "actives" : "" ?>"
                                href="profile.php"><i class="fa-regular fa-id-badge mt-1 pe-1"></i>Profile</a>
                        </li>
                        <hr>
                        <li>
                            <a class="actives" href="logout.php"><i
                                    class="fa-solid fa-right-from-bracket mt-1 me-1"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="main">