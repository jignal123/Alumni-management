<?php include ("admin_header.php");
?>

<div class="container-fluid">
    <div class="mb-4">
        <h2>Dashboard</h2>
    </div>
    <div class="row d-flex justify-content-around">
        <div class="card text-bg-primary mb-3 col-md-3 z-1 border border-0 shadow-lg" style="max-width: 15rem;">
            <div class="card-body">
                <h5 class="card-title">Total Alumni</h5>
                <h1 class="text-center" style="font-size:79px;"><i
                        class="fa-solid fa-user-graduate pe-1 opacity-25"></i></h1>
                <div class="card-img-overlay mt-5">
                    <?php
                    $qu = "SELECT COUNT(user_id) as total FROM user_master WHERE role_id =2 AND deleted = 0 ";
                    $res = query($qu);
                    $row = $res->fetch();
                    echo "<h1 class='text-center' style='font-size:65px;'>" . $row['total'] . "</h1>";
                    $res->closeCursor();
                    ?>
                </div>
            </div>
            <div class="card-footer bg-primary z-1">
                <a href="manage_alumni.php" class="card-link text-white">View Details <i
                        class="fa-solid fa-chevron-right pt-1"></i></a>
            </div>
        </div>
        <div class="card text-bg-warning mb-3 col-md-3 z-1 border border-0 shadow-lg" style="max-width: 15rem;">
            <div class="card-body">
                <h5 class="card-title text-white">Total Courses</h5>
                <h1 class="text-center" style="font-size:79px;">
                    <i class="fa-solid fa-book-open-reader opacity-25"></i>
                </h1>
                <div class="card-img-overlay mt-5 text-white">
                    <?php
                    $qu = "SELECT COUNT(*) as total FROM course_master";
                    $res = query($qu);
                    $row = $res->fetch();
                    echo "<h1 class='text-center' style='font-size:65px;'>" . $row['total'] . "</h1>";
                    $res->closeCursor();
                    ?>
                </div>
            </div>
            <div class="card-footer z-1 bg-warning">
                <a href="add_course.php" class="card-link text-white">View Details <i
                        class="fa-solid fa-chevron-right pt-1"></i></a>
            </div>
        </div>
        <div class="card text-bg-success mb-3 col-md-3 z-1 border border-0 shadow-lg" style="max-width: 15rem;">
            <div class="card-body">
                <h5 class="card-title">Total Events</h5>
                <h1 class="text-center" style="font-size:79px;">
                    <i class="fa-solid fa-calendar-days opacity-25"></i>
                </h1>

                <div class="card-img-overlay mt-5">
                    <?php
                    $qu = "SELECT COUNT(event_id) as total FROM event_master WHERE deleted = 0 ";
                    $res = query($qu);
                    $row = $res->fetch();
                    echo "<h1 class='text-center' style='font-size:65px;'>" . $row['total'] . "</h1>";
                    $res->closeCursor();
                    ?>
                </div>
            </div>
            <div class="card-footer bg-success z-1">
                <a href="add_event.php" class="card-link text-white">View Details <i
                        class="fa-solid fa-chevron-right pt-1"></i></a>
            </div>
        </div>
        <div class="card text-bg-danger mb-3 col-md-3 z-1 border border-0 shadow-lg" style="max-width: 15rem;">
            <div class="card-body">
                <h5 class="card-title">Event Registrations</h5>
                <h1 class="text-center" style="font-size:79px;">
                    <i class="fa-solid fa-calendar-check opacity-25"></i>
                </h1>
                <div class="card-img-overlay mt-5">
                    <?php
                    $qu = "SELECT COUNT(*) as total FROM event_registration";
                    $res = query($qu);
                    $row = $res->fetch();
                    echo "<h1 class='text-center' style='font-size:65px;'>" . $row['total'] . "</h1>";
                    $res->closeCursor();
                    ?>
                </div>
            </div>
            <div class="card-footer bg-danger z-1">
                <a href="event_report_ui.php" class="card-link text-white">View Details <i
                        class="fa-solid fa-chevron-right pt-1"></i></a>
            </div>
        </div>
    </div>
    <button class="btn btn-secondary" id="backup">Database Backup <i class="bi bi-database-down"></i></button>
    <script>
        $(document).ready(function () {
            $('#backup').click(function () {
                $(".loader").show();
                $.ajax({
                    type: "post",
                    url: "backup.php",
                    data: {backup : "yes"},
                    dataType : "json",
                    success: function (response) {
                        $(".loader").hide();
                        swal.fire({
                            title: response.title,
                            icon:response.icon,
                            text :response.msg
                        });
                    }
                });
            })
        });
    </script>
    <?php include "admin_footer.php" ?>