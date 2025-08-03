<?php
require "../dbconfig.php";
$qu = "SELECT
            eg.*,
            em.event_title
       FROM
            event_gallary eg
       JOIN event_master em ON
            eg.event_id = em.event_id ";

if (isset($_POST["search"])) {
    $qu .= "WHERE em.event_title LIKE '%" . $_POST["search"] . "%' ";
}

$qu .= "GROUP BY eg.event_id ORDER BY em.start_date ".$_POST["order"];

$html = "";
//echo $qu;exit;
$res = query($qu);
if($res->rowCount() > 0){
    $row = $res->fetchAll();
    //print_r($row);
    foreach($row as $r){
        $q = "SELECT COUNT(event_id) as total FROM event_gallary WHERE event_id = ?";
        $arr = [$r["event_id"]];
        $res = query($q,$arr);
        $rows = $res->fetch();
        $count = $rows["total"];
        $res->closeCursor();
        $html .='<div class="col-md-4 vstack gap-3">
                    <a href="eventgallery.php?event='.$r["event_id"].'&name='.$r["event_title"].'">
                        <img src="../admin/'.$r["image"].'" class="rounded image" alt="event" width="100%" height="250vw">
                    </a>
                    <div class="d-flex justify-content-between">
                    <h4>'.$r["event_title"].'</h4>
                    <p>'.(($count==1) ? $count.' Item' : $count .' Items').'</p>
                    </div>
                </div>';
    }
}else{
    $html = "<h1>No Gallery Found</h1>";
}
$output = array("html" => $html);

echo json_encode($output);
?>