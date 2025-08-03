<?php 
include("../dbconfig.php");
$query ="";
$query .="SELECT *FROM event_master WHERE deleted = 0 ";
if(isset($_POST["search"]["value"])){
    $query .= "AND( event_id LIKE '%".$_POST['search']['value']."%' ";
    $query .= "OR event_title LIKE '%".$_POST['search']['value']."%' ";
    $query .= "OR location LIKE '%".$_POST['search']['value']."%' ";
    $query .= "OR start_date LIKE '%".$_POST['search']['value']."%' ";
    $query .= "OR end_date LIKE '%".$_POST['search']['value']."%' ";
    $query .= "OR reg_status LIKE '%".$_POST['search']['value']."%') ";
}

if(isset($_POST["order"])){
    $query .= "ORDER BY ".$_POST['order']['0']['column']." " .$_POST['order']['0']['dir'] ." ";
}
else{
    $query .= "ORDER BY event_id DESC ";
}
$qu1="";
if($_POST["length"] != -1){
    $qu1 .= "LIMIT ".$_POST['start'].", ". $_POST['length'];
}
//echo $query;exit;
$statement =$con->prepare($query);
$statement->execute();
$filtered_rows=$statement->rowCount();
$statement->closeCursor();
$statement = $con->prepare($query.$qu1);
$statement->execute();
$res = $statement->fetchAll();
$statement->closeCursor();
$data =array();
foreach ($res as $row){
    $sub_array = array();
    $sub_array[] = $row['event_id'];
    $sub_array[] = "<img src ='".$row['event_image']."' class='img-thumbnail' width='200' height='95'>";
    $sub_array[] = $row['event_title'];
    $sub_array[] = $row['location'];
    $sub_array[] = date("d-m-Y h:i:s A",strtotime($row['start_date']));
    $sub_array[] = date("d-m-Y h:i:s A",strtotime($row['end_date']));
    $class = $row['reg_status'] == 'open'?'text-bg-success':'text-bg-danger';
    $sub_array[] = "<span class='badge ".$class."' style='font-size: 12px;'>".$row['reg_status']."</span>";
    $sub_array[] = "<button type='button' name='update' id='".$row['event_id']."' class='update btn btn-warning'><i class='fa-solid fa-pen-to-square'></i></button>";
    $sub_array[] = "<button type='button' name='delete' id='".$row['event_id']."' class='btn btn-danger delete'><i class='fa-regular fa-trash-can'></i></button>";
    $data[] = $sub_array;
}

$stmt = query("SELECT COUNT(event_id) as total FROM event_master");
$res = $stmt->fetch();
$total_num_rows = $res['total'];

$output = array(
    'draw'            => intval($_POST['draw']),
    'recordsTotal'    => $total_num_rows,
    "recordsFiltered" => $filtered_rows,
    "data"            => $data
);

echo json_encode($output);
?>