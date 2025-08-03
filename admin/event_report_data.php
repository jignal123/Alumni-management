<?php
include("../dbconfig.php");

$q = "SELECT *FROM event_master WHERE deleted = 0 ";
if (isset($_POST['start']) && isset($_POST['end']) && $_POST['start'] != "" && $_POST['end'] != "") {
    $q .= "AND DATE(start_date) AND DATE(end_date) BETWEEN '" . $_POST['start'] . "'AND '" . $_POST['end'] . "' ";
}

if (isset($_POST['title']) && $_POST['title'] != "") {
    $evi = implode(',', $_POST['title']);
    $q .= 'AND event_id in(' . $evi . ') ';
}
//echo $q;exit;
$ev = $con->prepare($q);
$ev->execute();
if ($ev->rowCount() > 0) {
    $html = "";
    $html .= "<html>
    <head>
         <style>
            table { width: 100%; border-collapse: collapse;}
            th, td { border: 1px solid black; padding: 5px; text-align: left; }
            td { font-size: 8pt;} /* Reduce cell font size */

            .report {
                max-width: 800px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .event {
                padding: 10px 0;
            }

            .separator {
                width: 100%;
                height: 2px;
                background-color: #d1d1d1;
                margin: 20px 0;
                position: relative;
            }

            .separator::before {
                content: '✦✦✦';
                position: absolute;
                top: -10px;
                left: 50%;
                transform: translateX(-50%);
                background-color: #ffffff;
                padding: 0 10px;
                color: #555555;
                font-size: 1.2em;
            }

                    </style>
                </head>
             <div class='report'>";
    if ($ev->rowCount() == 1) {
        $res = $ev->fetch();
        extract($res);
        // Convert start and end date to a more readable format
        $startDate = date('F j, Y, g:i a', strtotime($start_date));
        $endDate = date('F j, Y, g:i a', strtotime($end_date));
        // Create HTML content for event
        $html .= "<div class='event'>
        <h1>($event_id)$event_title</h1>
        <img src='$event_image' width='500' height='150' style='padding-top:10px'/>
        <p><strong>Start Date:</strong> $startDate</p>
        <p><strong>End Date:</strong> $endDate</p>
        <p><strong>Location:</strong> $location</p>
        <p><strong>Registration Status:</strong> $reg_status</p>
        <p><h2><strong>Description:</strong></h2><br><div style='padding: 10px;text-align:left;'>$description</div></p>
        ";
        // Create HTML content for registrations table

        $qu = "SELECT
                    user_master.image,
                    user_master.first_name,
                    user_master.last_name,
                    user_master.email,
                    user_master.phone,
                    event_day.event_date
               FROM
                    user_master
               JOIN event_registration ON 
                    user_master.user_id = event_registration.user_id
               JOIN event_day ON 
                    event_registration.day_id = event_day.day_id
               WHERE
                    event_day.event_id = ?";
        $ar = array($event_id);
        $res = query($qu, $ar);
        $registrations = $res->fetchAll();
        if ($res->rowCount() > 0) {
            $html .= "
            <h2>Registrations</h2>
            <table border='1px solid black' style='width: 100%; border-collapse: collapse;' cellpadding='4'>
                <thead>
                    <tr>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Image</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>First Name</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Last Name</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Email</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Phone</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Registration Date</th>
                    </tr>
                </thead>
                <tbody>
            ";
            foreach ($registrations as $registration) {
                $regDate = date('F j, Y', strtotime($registration['event_date']));
                $html .= "
                <tr>
                    <td><img src='." . $registration["image"] . "' width='50' height='50'></td>
                    <td>" . $registration["first_name"] . "</td>
                    <td>" . $registration["last_name"] . "</td>
                    <td>" . $registration["email"] . "</td>
                    <td>" . $registration["phone"] . "</td>
                    <td>{$regDate}</td>
                </tr>
              ";
            }

            $html .= "
                    </tbody>
                </table>
            </div>
        </div>
        <div class='separator'></div>
                ";
        } else {
            $html .= "<h3>No Registrations Found!</h3></div><div class='separator'></div><br></div>";
        }
    } else {
        $res = $ev->fetchAll();
        foreach ($res as $row) {
            $startDate = date('F j, Y, g:i a', strtotime($row['start_date']));
            $endDate = date('F j, Y, g:i a', strtotime($row['end_date']));
            // Create HTML content for event
            $html .= "<div class='event'>
            <h1>(" . $row['event_id'] . ")" . $row['event_title'] . "</h1>
            <img src='" . $row['event_image'] . "' width='500' height='150' style='padding-top:10px'/>
            <p><strong>Start Date:</strong> $startDate</p>
            <p><strong>End Date:</strong> $endDate</p>
            <p><strong>Location:</strong>" . $row['location'] . "</p>
            <p><strong>Registration Status:</strong> " . $row['reg_status'] . "</p>
            <p><h2><strong>Description:</strong></h2><br><div style='padding: 10px; text-align:left;'>" . $row['description'] . "</div></p>
            ";
            // Create HTML content for registrations table

            $qu = "SELECT
                        user_master.image,
                        user_master.first_name,
                        user_master.last_name,
                        user_master.email,
                        user_master.phone,
                        event_day.event_date
                   FROM
                        user_master
                   JOIN event_registration ON 
                        user_master.user_id = event_registration.user_id
                   JOIN event_day ON 
                        event_registration.day_id = event_day.day_id
                   WHERE
                        event_day.event_id = ?";
            $ar = array($row['event_id']);
            $res = query($qu, $ar);
            $registrations = $res->fetchAll();
            if ($res->rowCount() > 0) {
                $html .= "
            <h2>Registrations</h2>
            <table border='1px solid black' style='width: 100%; border-collapse: collapse;' cellpadding='4'>
                <thead>
                    <tr>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Image</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>First Name</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Last Name</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Email</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Phone</th>
                        <th style='font-size: 8pt; background-color:#a19c8d; font-weight:bold;'>Registration Date</th>
                    </tr>
                </thead>
                <tbody>
            ";
                foreach ($registrations as $registration) {
                    $regDate = date('F j, Y', strtotime($registration['event_date']));
                    $html .= "
                <tr>
                    <td><img src='." . $registration["image"] . "' width='50' height='50'></td>
                    <td>" . $registration["first_name"] . "</td>
                    <td>" . $registration["last_name"] . "</td>
                    <td>" . $registration["email"] . "</td>
                    <td>" . $registration["phone"] . "</td>
                    <td>{$regDate}</td>
                </tr>
             ";
                }

                $html .= "
                </tbody>
              </table>
            </div>
            <div class='separator'></div>
            ";
            } else {
                $html .= "<h3>No registration Found!</h3></div><div class='separator'></div><br>";
            }
        }
        $html .= "</div>";
    }
    echo $html;
} else {
    echo "<h1>No Data Found</h1>";
}
?>