<?php 
include "../dbconfig.php";
 $query = "";
 $query .= "SELECT * FROM course_master ";
 if(isset($_POST['search']['value'])){
    $query .="WHERE course_nm LIKE '%".$_POST['search']['value']."%' "; 
 }
 if(isset($_POST['order'])){
    $query .= "ORDER BY ".$_POST['order']['0']['column']." " .$_POST['order']['0']['dir'] ." ";
}
else{
    $query .= "ORDER BY course_id DESC ";
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
    $sub_array[] = $row['course_id'];
    $sub_array[] = $row['course_nm'];
    $sub_array[]= "<button type='button' name='update' id='".$row['course_id']."' class='update btn btn-warning'><i class='fa-solid fa-pen-to-square'></i></button>";
    $sub_array[]= "<button type='button' name='delete' id='".$row['course_id']."' class='btn btn-danger delete'><i class='fa-regular fa-trash-can'></i></button>";
    $data[] = $sub_array;
}
$statement =query("SELECT COUNT(course_id)as total FROM course_master");
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