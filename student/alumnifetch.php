<?php
require "../dbconfig.php";
session_start();
$qry = "SELECT 
            CONCAT(um.first_name,' ',um.last_name) AS fullname,
            um.user_id,
            cm.course_nm,
            um.profession,
            um.image,
            (SELECT 
                (um.start_year+duration) 
            FROM 
                course_duration cd 
            WHERE 
                cd.duration_id = um.duration_id
            ) AS class
        FROM 
            user_master um 
        JOIN course_master cm ON 
            um.course_id = cm.course_id 
        WHERE 
            um.user_id != ?
        AND um.deleted = 0 ";

if (isset($_POST["search"])) {
    $qry .= "AND( first_name LIKE '%" . $_POST["search"] . "%' ";
    $qry .= "OR last_name LIKE '%" . $_POST["search"] . "' ";
    $qry .= "OR u_state LIKE '%" . $_POST["search"] . "%' ";
    $qry .= "OR u_city LIKE '%" . $_POST["search"] . "%' ";
    $qry .= "OR course_nm LIKE '%" . $_POST["search"] . "%' ";
    $qry .= "OR gender LIKE '%" . $_POST["search"] . "%' ";
    $qry .= "OR address LIKE '%" . $_POST["search"] . "%' ";
    $qry .= "OR profession LIKE '%" . $_POST["search"] . "%' ";
    $qry .= "OR dob LIKE '%" . $_POST["search"] . "%' ) ";
}

if (isset($_POST["batch"]) && $_POST["batch"] == "my") {
    $qry .= "AND um.start_year =" . $_SESSION['start_year'] . " AND um.duration_id =" . $_SESSION['duration_id'] . " AND user_id!=" . $_SESSION["student_id"] . " ";
}

$qry .= "ORDER BY user_id DESC ";
//echo $qry;exit;
$arr = [$_SESSION["student_id"]];
$res = query($qry,$arr);
$count = $res->rowCount();
$html = "";
if ($count > 0) {
    $row = $res->fetchAll();
    foreach ($row as $alumni) {
        $html .= '<div class="alumni-profile-card">
            <img src=".' . $alumni["image"] . '" alt="Alumni Image">
            <h2>' . $alumni["fullname"] . '</h2>
            <p> Class Of ' . $alumni["class"] . '</p>
            <p>' . $alumni["course_nm"] . '</p>
            <p>' . $alumni["profession"] . '</p>
            <button class="activel fs-6 rounded" name="view" id="' . $alumni["user_id"] . '">View Full Profile</button>
        </div>';
    }
} else {
    $html .= "<h2>No Alumni Found</h2>";
}
$output = array("html" => $html);
echo json_encode($output);
?>