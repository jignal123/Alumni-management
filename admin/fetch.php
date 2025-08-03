<?php
include("../dbconfig.php");
$query="";
$query .= "SELECT *FROM user_master WHERE role_id=2 AND deleted = 0 ";
if(isset($_POST["search"]["value"])){
    $query .= "AND(first_name LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR user_id LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR last_name LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR email LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR u_state LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR u_city LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR start_year LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR address LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR profession LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR status LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR dob LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR phone LIKE '%".$_POST['search']['value']. "%' ";
    $query .= "OR gender LIKE '%".$_POST['search']['value']. "%' ) ";
}

if($_POST["course"]!= "" && $_POST["from"]!="" && $_POST["end"]!= ""){
    $query .= " AND course_id =".$_POST["course"]. " AND start_year BETWEEN '".$_POST["from"]."' AND '".$_POST["end"]."' ";
}
if(isset($_POST['order'])){
    $query .= "ORDER BY ".$_POST['order']['0']['column']." " .$_POST['order']['0']['dir'] ." ";
}
else{
    $query .= "ORDER BY user_id DESC ";
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
$data =array();
foreach($res as $row){
    $q="SELECT course_nm FROM course_master WHERE course_id = ?";
    $r=query($q,[$row['course_id']]);
    $re = $r->fetch();
    $course=$re['course_nm'];
    $r->closeCursor();
    $q= "SELECT duration FROM course_duration WHERE duration_id =?";
    $r=query($q,[ $row['duration_id']]);
    $re = $r->fetch();
    $end_year=$re["duration"] + $row['start_year'];
    $r->closeCursor();
    $image = "<img src='.".$row['image']."' class='img-thumbnail' width='50' height='35'>";
    $add=(trim($row['address'])!="")? $row['address'].",":"";
    $cls= $row['status'] == 'un'?'text-bg-danger':'text-bg-success';
    $sub_array=array();
    $sub_array[]= $row["user_id"];
    $sub_array[]= $image;
    $sub_array[]=$row['first_name'];
    $sub_array[]=$row['last_name'];
    $sub_array[]= $row['gender'];
    $sub_array[]= $row['dob'];
    $sub_array[]= $add.$row['u_city']." ,".$row["u_state"];
    $sub_array[]= $row['email'];
    $sub_array[]= $row['phone'];
    $sub_array[]= $course;
    $sub_array[]= $row['start_year'];
    $sub_array[]= $end_year;
    $sub_array[]= $row['profession'];
    $sub_array[]= "<span class='badge ".$cls."' style='font-size:12px;'>".($row['status'] == 'un' ? 'unverified' : 'verified')."</span>";
    $sub_array[]= "<button type='button' name='update' id='".$row['user_id']."' class='update btn btn-warning'><i class='fa-solid fa-pen-to-square'></i></button>";
    $sub_array[]= "<button type='button' name='delete' id='".$row['user_id']."' class='btn btn-danger delete'><i class='fa-regular fa-trash-can'></i></button>";

    $data[]= $sub_array;
}

$statement =query("SELECT COUNT(user_id)as total FROM user_master WHERE role_id =2");
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