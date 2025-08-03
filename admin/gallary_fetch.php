<?php 
include "../dbconfig.php";
$query ="";
$query.="SELECT *FROM event_gallary eg JOIN event_master em ON eg.event_id = em.event_id ";
if(isset($_POST["search"]["value"])){
    $query.= " WHERE em.event_title LIKE'%".$_POST["search"]["value"]."%' ";
}
if(isset($_POST['order'])){
    $query .= "ORDER BY ".$_POST['order']['0']['column']." " .$_POST['order']['0']['dir'] ." ";
}
else{
    $query .= "ORDER BY gallary_id DESC ";
}
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
    $sub_array[] = $row['gallary_id'];
    $sub_array[] =  "<img src ='".$row['image']."' class='img-thumbnail' width='200' height='95'>";
    $sub_array[] = $row['event_title'];
    $sub_array[] = "<button type='button' name='update' id='".$row['gallary_id']."' class='update btn btn-warning'><i class='fa-solid fa-pen-to-square'></i></button>";
    $sub_array[] = "<button type='button' name='delete' id='".$row['gallary_id']."' class='btn btn-danger delete'><i class='fa-regular fa-trash-can'></i></button>";
    $data[] = $sub_array;
}

$stmt = query("SELECT COUNT(gallary_id) as total FROM event_gallary");
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