<?php
if (isset($_GET["event"])) {
    include "dbconfig.php";
    $qu = "UPDATE 
            event_master 
          SET 
            reg_status = 'closed' 
          WHERE 
            DATE(end_date) <= CURDATE()";
    $res = query($qu);
    $res->closeCursor();
    //echo $_GET["event"];
    $q = "SELECT *FROM event_master WHERE event_id= ?";
    $arr = array($_GET["event"]);
    $res = query($q, $arr);
    $event = $res->fetch();
    ?>
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="./admin/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="style.css">
    <style>
        .alumni-event-view {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        td {
            padding-right: 10px;
        }

        .register-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .register-btn:hover {
            background-color: #3e8e41;
            transform: translateY(-5px);
        }

        .register-btn:focus {
            outline: unset;
        }
    </style>
    <div class="alumni-event-view">
        <div class="event-image">
            <img src="./admin/<?= $event["event_image"] ?>" alt="Event Image">
        </div>
        <div class="event-details">
            <h2><?= $event["event_title"] ?></h2>
            <p class="event-date">
                <?php if (date("d-m-Y", strtotime($event["start_date"])) == date("d-m-Y", strtotime($event["end_date"]))) {
                    echo date("l, F j , Y | h:i A ", strtotime($event["start_date"])) . date("- h:i A", strtotime($event["end_date"]));
                } else {
                    echo "Starts: " . date("l, F j ,Y | h:i A", strtotime($event["start_date"])) . "<br><span>Ends: " . date("l, F j ,Y | h:i A", strtotime($event["end_date"]));
                } ?>
            </p>
            <p class="event-location"><?= $event["location"] ?></p>
            <hr>
            <p class="event-description">
                <?= $event["description"] ?>
            </p>
            <?php
}?>