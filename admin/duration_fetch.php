<?php 
require "../dbconfig.php";
$query = "";
$query .= "SELECT *FROM course_duration cd JOIN course_master cm ON cm.course_id = cd.course_id ";
//echo $_POST['search']['value'];exit;
if(isset($_POST["search"]["value"])) {
    $query .= "WHERE cm.course_nm LIKE '%".$_POST["search"]["value"]."%' ";
    $query .= "OR cd.duration LIKE '%".$_POST["search"]["value"]."%' ";
    $query .= "OR cd.start_year LIKE '%".$_POST["search"]["value"]."%' ";
    $query .= "OR cd.end_year LIKE '%".$_POST["search"]["value"]."%' ";
}

$query .="GROUP BY cd.duration_id ";
if(isset($_POST['order'])){
    $query .= "ORDER BY ".$_POST['order']['0']['column']." " .$_POST['order']['0']['dir'] ." ";
}
else{
    $query .= "ORDER BY cd.duration_id DESC ";
}
//echo $query;exit;
$qu1="";
if($_POST["length"] != -1){
    $qu1 .= "LIMIT ".$_POST['start'].", ". $_POST['length'];
}

$statement =$con->prepare($query);
$statement->execute();
$filtered_rows=$statement->rowCount();
$statement->closeCursor();
$statement = $con->prepare($query.$qu1);
$statement->execute();
$res = $statement->fetchAll();
$statement->closeCursor();
$data = [];
foreach($res as $row){
    $sub_array = [];
    $sub_array[] = $row['duration_id'];
    $sub_array[] = $row['course_nm'];
    $sub_array[] = $row['duration'];
    $sub_array[] = $row['start_year'];
    $sub_array[] = $row['end_year'] == NULL ? "Present" : $row['end_year'];
    $sub_array[]= "<button type='button' name='update' id='".$row['duration_id']."' class='update btn btn-warning'><i class='fa-solid fa-pen-to-square'></i></button>";
    $sub_array[]= "<button type='button' name='delete' id='".$row['duration_id']."' class='btn btn-danger delete'><i class='fa-regular fa-trash-can'></i></button>";
    $data [] = $sub_array;
}

$statement =query("SELECT COUNT(duration_id)as total FROM course_duration");
$res=$statement->fetch();
$total_num_rows =$res['total'];

$output = array(
    'draw'            => intval($_POST['draw']),
    'recordsTotal'    => $total_num_rows,
    "recordsFiltered" => $filtered_rows,
    "data"            => $data
);

echo json_encode($output);
?>
