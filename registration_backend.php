<?php
include("dbconfig.php");


// Registration
if (
    isset($_POST['pwd']) &&
    isset($_POST['fnm']) &&
    isset($_POST['lnm']) &&
    isset($_POST['birth']) &&
    isset($_POST['state']) &&
    isset($_POST['city']) &&
    isset($_POST['semail']) &&
    isset($_POST['phone']) &&
    isset($_POST['course']) &&
    isset($_POST['year']) &&
    isset($_POST['gender'])
) {
    $form_data = filter($_POST);
    extract($form_data);
    $select = "SELECT * FROM course_duration WHERE course_id=? AND COALESCE(end_year,YEAR(CURRENT_DATE))>?";
    $arr = array($course, $year);
    $d = query($select, $arr);
    $durations = $d->fetch();
    $duration_id = $durations['duration_id'];
    //echo $duration_id;
    $d->closeCursor();
    $img = $_FILES['photo']['name'];
    $temp_nm = $_FILES['photo']['tmp_name'];
    $folder = "./user_image/" . $img;
    move_uploaded_file($temp_nm, $folder);
    $q = "INSERT INTO user_master (password,status,first_name,last_name,dob,u_state,
    u_city,address,email,phone,course_id,start_year,duration_id,gender,profession,role_id,image) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $array = array(md5($pwd), 'un', $fnm, $lnm, $birth, $state, $city, $address, $semail, $phone, $course, $year, $duration_id, $gender, $sprofession, '2', $folder);
    $r = query($q, $array);
    $a = $r->rowCount();
    $sub = 'Confirmation Of Registration';
    $msg = '<span style="color:green;"><strong>Success!!</strong></span>You Have Successfully Registred<br> <strong>Welcome</strong> To Alumni Portal';
    if ($a == 1) {
        echo "reg";
        send_email($semail, $msg, $sub);
    } else {
        echo false;
    }
}


// //password exist validation
// if (isset($_POST['password'])) {
//     $pw = $_POST['password'];
//     $q = "SELECT password FROM user_master WHERE password = ?";
//     $ar = array($pw);
//     $ans = query($q, $ar);
//     echo $ans->rowCount();
// }

//email exist validation
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $q = "SELECT email FROM user_master WHERE email = ?";
    $ar = array($email);
    $ans = query($q, $ar);
    echo $ans->rowCount();
}
