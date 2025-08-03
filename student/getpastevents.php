<?php
require "../dbconfig.php";
$q = "SELECT * FROM event_master WHERE DATE(end_date) <= CURDATE() AND deleted = 0 ";

if (isset($_POST["search"])) {
    $q .= "AND (event_title LIKE '%" . $_POST["search"] . "%' ";
    $q .= "OR location LIKE '%" . $_POST["search"] . "%') ";
}

$q .= "ORDER BY start_date " . $_POST["order"] . " ";

$html = '
<br>
<br>
    <div class="row">';
$r = query($q);
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
    $html .= '<h2 class="text-center">No Past Event Found</h2>';
}
$html .= '        </div>';
$output = array("html" => $html);

echo json_encode($output);
?>