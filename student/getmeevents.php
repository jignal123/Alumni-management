<?php
require "../dbconfig.php";
session_start();
$q = "SELECT
        em.*
      FROM
        event_master em
      JOIN event_day ed ON
        em.event_id = ed.event_id
      JOIN event_registration er ON
        ed.day_id = er.day_id
      WHERE
        er.user_id = ? 
        AND em.deleted = 0 ";

if (isset($_POST["search"])) {
    $q .= "AND (em.event_title LIKE '%" . $_POST["search"] . "%' ";
    $q .= "OR em.location LIKE '%" . $_POST["search"] . "%') ";
}

$q .= " GROUP BY em.event_id ";
$q .= "ORDER BY em.start_date " . $_POST["order"] . " ";
$ar = [$_SESSION["student_id"]];
$html = '
<br>
<br>
    <div class="row">';
$r = query($q,$ar);
if ($r->rowCount() > 0) {
    $ev = $r->fetchAll();
    foreach ($ev as $e) {
        $html .= '<div class="col-md-6 mb-4">
                    <div class="event-card1">
                        <div class="event-image1">
                            <img src="../admin/' . $e["event_image"] . '" alt="Event Image">
                        </div>
                        <div class="event-details">
                            <h2>' . $e["event_title"] . '</h2>
                            <p><i class="fas fa-clock pe-2"></i>';
        if (date("d-m-Y", strtotime($e["start_date"])) == date("d-m-Y", strtotime($e["end_date"]))) {
            $html .= date("F j, Y | h:i A", strtotime($e["start_date"]));
        } else {
            $html .= date("F j, Y | h:i A", strtotime($e["start_date"])) . "<br> <span class='ps-4'>" . date("F j, Y | h:i A", strtotime($e["end_date"])) . "</span>";
        }

        $html .= '  </p>
                            <p><i class="fas fa-map-marker-alt pe-2"></i>' . $e["location"] . '</p>
                            <button class="register"><a
                                    href="view_event.php?event=' . $e["event_id"] . '">VIEW</a></button>
                        </div>
                    </div>
                </div>';
    }
} else {
    $html .= "<h2 class='text-center'>You Haven't Attended Any Events</h2>";
}
$html .= '        </div>';
$output = array("html" => $html);

echo json_encode($output);
?>