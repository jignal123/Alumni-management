<!DOCTYPE html>
<html lang="en">
<?php
include ("../dbconfig.php");
adminlogin();
$page = explode("/", $_SERVER['REQUEST_URI']);
$page = end($page);
if (isset($_SESSION["admin"])) {
    $q = "SELECT *FROM user_master WHERE email=?";
    $arr = array($_SESSION['admin']);
    $res = query($q, $arr);
    if ($res->rowCount() == 1) {
        $login = $res->fetch();
        $_SESSION['admin_id'] = $login['user_id'];
        $_SESSION['pass'] = $login['password'];
        $_SESSION['name'] = $login['first_name'];
        $_SESSION['surname'] = $login['last_name'];
        $_SESSION['dob'] = $login['dob'];
        $_SESSION['state'] = $login['u_state'];
        $_SESSION['city'] = $login['u_city'];
        $_SESSION['phone'] = $login['phone'];
        $_SESSION['gender'] = $login['gender'];
        $_SESSION['role_id'] = $login['role_id'];
    }
}
//echo $page;
?>
<style>
    .modal-header {
        background-color: purple;
        color: white;
    }

    .modal-header .btn-close {
        background-color: white;
    }

    .modal-body .form-label {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .profile-img {
        margin-bottom: 1rem;
        text-align: center;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="datatables1.min.css">
    <link rel="stylesheet" href="datatables.bs5.css">
    <link rel="stylesheet" href="bs5buttons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
    <link rel="stylesheet" href="admin_style.css">
    <script src="../jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/8e55652a63.js" crossorigin="anonymous"></script>
    <style>
        .dropdown-menu {
            max-height: 200px;
            /* Adjust the height as needed */
            overflow-y: auto;
        }
    </style>
    <title>Admin</title>
</head>

<body>
    <div class="loader">
    </div>
    <div class="wrapper">
        <aside id="sidebar" class="">
            <!-- content of sidebar-->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="" class="text-uppercase">Department of computer science Alumni</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Admin Elements
                    </li>
                    <li class="sidebar-item">
                        <a href="index.php" class="sidebar-link <?= $page == "index.php" ? "activel" : "" ?>">
                            <i class="fa-solid fa-list pe-1"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href=""
                            class="sidebar-link collapsed <?= $page == "add_event.php" || $page == "event_report_ui.php" ? "activel" : "" ?>"
                            data-bs-target="#pages" data-bs-toggle="collapse" aria-expanded="false"><i
                                class="fa-solid fa-calendar-days pe-2"></i>
                            Events
                        </a>
                        <ul id="pages"
                            class="sidebar-bropdown list-unstyled collapse <?= $page == "add_event.php" || $page == "event_report_ui.php" ? "show" : "" ?>"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="add_event.php"
                                    class="sidebar-link <?= $page == "add_event.php" ? "activel" : "" ?>"><i
                                        class="fa-solid fa-list-check pe-2"></i>Manage Events</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="event_report_ui.php"
                                    class="sidebar-link <?= $page == "event_report_ui.php" ? "activel" : "" ?>"><i
                                        class="fa-solid fa-file-lines pe-2"></i>Event
                                    Reports</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="manage_alumni.php"
                            class="sidebar-link <?= $page == "manage_alumni.php" ? "activel" : "" ?>">
                            <i class="fa-solid fa-user-graduate pe-1"></i>
                            Alumni
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="event_gallary.php"
                            class="sidebar-link <?= $page == "event_gallary.php" ? "activel" : "" ?>">
                            <i class="fa-solid fa-images pe-1"></i>
                            Event Gallary
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href=""
                            class="sidebar-link collapsed <?= $page == "add_course.php" || $page == "course_duration.php" ? "activel" : "" ?>"
                            data-bs-target="#auth" data-bs-toggle="collapse" aria-expanded="false">
                            <i class="fa-solid fa-book-open-reader pe-2"></i>
                            Course
                        </a>
                        <ul id="auth"
                            class="sidebar-bropdown list-unstyled collapse <?= $page == "add_course.php" || $page == "course_duration.php" ? "show" : "" ?>"
                            data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="add_course.php"
                                    class="sidebar-link <?= $page == "add_course.php" ? "activel" : "" ?>"><i
                                        class="fa-solid fa-file-circle-plus pe-2"></i>Add course</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="course_duration.php"
                                    class="sidebar-link <?= $page == "course_duration.php" ? "activel" : "" ?>"><i
                                        class="fa-regular fa-calendar-check pe-2"></i>Add Duration</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="change_password.php"
                            class="sidebar-link <?= $page == "change_password.php" ? "activel" : "" ?>">
                            <i class="fa-solid fa-key pe-1"></i>
                            Change Password
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="modal fade" id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Admin Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <img src="<?php if (isset($_SESSION['image'])) {
                                    echo "." . $_SESSION['image'];
                                } ?>" alt="Profile Image" class="rounded-circle img-thumbnail profile-img"
                                    width="100" height="100">
                            </div>
                            <div class="col-md-6">
                                <p class="form-label"><strong>First Name:</strong> <?= $_SESSION['name']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="form-label"><strong>Last Name:</strong> <?= $_SESSION['surname']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="form-label"><strong>Date Of Birth:</strong>
                                    <?= date("d-m-Y", strtotime($_SESSION['dob'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="form-label"><strong>Gender:</strong> <?= $_SESSION['gender']; ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="form-label"><strong>State:</strong> <?= $_SESSION['state']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p class="form-label"><strong>City:</strong> <?= $_SESSION['city']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="form-label"><strong>Phone:</strong> <?= $_SESSION['phone']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main" id="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="<?php if (isset($_SESSION['image'])) {
                                    echo "." . $_SESSION['image'];
                                } ?>" class="avatar img-fluid rounded" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="" class="dropdown-item" id="profile" data-bs-target="#profile"
                                    data-bs-toggle="modal">Profile</a>
                                <a href="admin_logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2">