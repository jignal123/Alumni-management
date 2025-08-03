<!doctype html>
<html lang="en">

<head>
    <?php session_start();
    if (
        isset($_SESSION['admin'])

    ) {
        header("Location: admin/index.php");
    }
    if (
        isset($_SESSION['alumni'])
    ) {
        header("Location: student/index.php");
    }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="./admin/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="style.css">
    <style>

    </style>
</head>

<body>
    <div class="navi">
        <nav class="d-flex pt-2 pb-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1">
                        <img src="./admin/logo.jpg" alt="" class="pb-1" style="height: 50px;">
                    </div>
                    <div class="col-4">
                        <h1 class="pt-1">Alumni Portal</h1>
                    </div>
                    <div class="nav col-7 justify-content-end">
                        <ul class="d-flex flex-row pt-2">
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php" class="ms-2">signup</a></li>
                            <li><a href="events.php" style="color:aliceblue;" class="active ms-2">Events</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="container mt-5">
        <div class="row">
            <?php
            include "dbconfig.php";
            $qu = "SELECT *FROM event_master WHERE deleted = 0 ORDER BY event_id DESC LIMIT 3";
            $r = query($qu);
            if ($r->rowCount() > 0) {
                $ev = $r->fetchAll();
                foreach ($ev as $e) {
                    ?>
                    <div class="col-lg-4 mb-4">
                        <div class="event-card">
                            <div class="event-image">
                                <img src="./admin/<?= $e["event_image"] ?>" alt="Event Image">
                            </div>
                            <div class="event-details">
                                <h2 class="event-title"><?= $e["event_title"] ?></h2>
                                <p class="event-location">
                                    <?= $e["location"] ?>
                                </p>
                                <p class="event-time">
                                    <?php if (date("d-m-Y", strtotime($e["start_date"])) == date("d-m-Y", strtotime($e["end_date"]))) {
                                        echo date("F j, Y | h:i A", strtotime($e["start_date"]));
                                    } else {
                                        echo date("F j, Y | h:i A", strtotime($e["start_date"])) . "<br> <span>" . date("F j, Y | h:i A", strtotime($e["end_date"])) . "</span>";
                                    } ?>
                                </p>
                            </div>
                            <div class="event-footer">
                                <button class="read-more-btn"><a href="view_event.php?event=<?= $e["event_id"] ?>">Read More
                                    </a></button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="col-md-12 text-center p-3">
                    <a href="./student/event.php" class="active p-2 ps-3 pe-3">VIEW ALL <?php $q = "SELECT COUNT(*) as total FROM event_master";
                    $r = query($q);
                    $c = $r->fetch();
                    echo $c['total'] . " EVENTS";
                    ?></a>
                </div>
                <?php
            } else {
                echo "<h1>No Events Found</h1>";
            }
            ?>
        </div>
    </div>
</body>

</html>