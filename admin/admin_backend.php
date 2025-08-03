<?php
include("../dbconfig.php");
session_start();
//adding event
if (
    isset($_POST["title"]) &&
    isset($_POST["start"]) &&
    isset($_POST["end"]) &&
    isset($_POST["loc"]) &&
    isset($_FILES["eimg"])
) {
    extract($_POST);
    // echo $des;exit;
    $img = $_FILES['eimg']['name'];
    $temp = $_FILES['eimg']['tmp_name'];
    //echo $img;exit;
    $folder = "event/" . $img;
    move_uploaded_file($temp, $folder);
    $qu = "INSERT INTO event_master(event_title,description,location,start_date,end_date,event_image,reg_status) VALUES
    (?,?,?,?,?,?,?)";
    $arr = array($title, $description, $loc, $start, $end, $folder, $status);
    $ans = query($qu, $arr);
    if ($ans->rowCount() == 1) {
        $ans->closeCursor();
        $q = "SELECT event_id,start_date,end_date FROM event_master ORDER BY event_id DESC LIMIT 1";
        $r = query($q);
        $ans = $r->fetch();
        $start_date = $ans['start_date'];
        $end_date = $ans['end_date'];
        $eid = $ans['event_id'];
        $r->closeCursor();
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end, DatePeriod::INCLUDE_END_DATE);
        foreach ($period as $date) {
            $event_date = $date->format('Y-m-d');
            $q = 'INSERT INTO event_day(event_id,event_date) VALUES(?,?)';
            $array = array($eid, $event_date);
            $res = query($q, $array);
            if ($res->rowCount() == 1) {
                $flag = true;
            } else {
                $flag = false;
            }
            $res->closeCursor();
        }
        if ($flag == true) {
            echo "add";
        }
    } else {
        echo "er";
    }
}
//display data for update
if (isset($_POST['user_id']) && count($_POST) == 1) {
    $output = array();
    $q = "SELECT *FROM user_master WHERE user_id=?";
    $arr = array($_POST['user_id']);
    $r = query($q, $arr);
    $row = $r->fetch();
    if ($row) {
        $output["fnm"] = $row["first_name"];
        $output["lnm"] = $row["last_name"];
        $output["status"] = $row["status"];
        $output["gender"] = $row["gender"];
        $output["birth"] = $row["dob"];
        $output["state"] = $row["u_state"];
        $output["city"] = $row["u_city"];
        $output["address"] = $row["address"];
        $output["course"] = $row["course_id"];
        $output["year"] = intval($row["start_year"]);
        $output["profession"] = $row["profession"];
        $output["email"] = $row["email"];
        $output["phone"] = $row["phone"];
        $output["img"] = "<img src ='." . $row["image"] . "' class='img-thumbnail' width='50' height='35'>";
        $output["imgpt"] = $row["image"];
    }

    echo json_encode($output);
}

if (isset($_POST['op'])) {
    $res = "";
    //Adding Alumni
    if ($_POST['op'] == "add") {
        $form_data = filter($_POST);
        extract($form_data);
        $select = "SELECT * FROM course_duration WHERE course_id=? AND COALESCE(end_year,YEAR(CURRENT_DATE))>=?";
        $arr = array($acourse, $ayear);
        $d = query($select, $arr);
        $durations = $d->fetch();
        $duration_id = $durations['duration_id'];
        //echo $duration_id;
        $d->closeCursor();
        $img = $_FILES['aphoto']['name'];
        $temp_nm = $_FILES['aphoto']['tmp_name'];
        $folder = "./user_image/" . $img;
        move_uploaded_file($temp_nm, "." . $folder);
        $q = "INSERT INTO user_master (password,status,first_name,last_name,dob,u_state,
        u_city,address,email,phone,course_id,start_year,duration_id,gender,profession,role_id,image) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $array = array(md5($apwd), $status, $afnm, $alnm, $abirth, $astate, $acity, $aaddress, $aemail, $aphone, $acourse, $ayear, $duration_id, $agender, $aprofession, '2', $folder);
        $r = query($q, $array);
        $sub = 'Confirmation Of Registration';
        $msg = '<span style="color:green;"><strong>Success!!</strong></span>You Have Successfully Registred<br> <strong>Welcome</strong> To Alumni Portal';
        if ($r->rowCount() == 1) {
            $res = "add";
            send_email($aemail, $msg, $sub);
        } else {
            $res = "error";
        }
        $r->closeCursor();
    }
    echo $res;
}

if (isset($_POST['operation'])) {
    $res = "";
    //Edit Alumni
    if ($_POST['operation'] == "edit") {
        $form_data = filter($_POST);
        extract($form_data);
        //print_r($form_data);exit;
        $select = "SELECT * FROM course_duration WHERE course_id=? AND COALESCE(end_year,YEAR(CURRENT_DATE))>?";
        $arr = array($course, $year);
        $d = query($select, $arr);
        $durations = $d->fetch();
        $duration_id = $durations['duration_id'];
        //echo $duration_id;
        $d->closeCursor();
        if ($_FILES['photo']['name'] != "") {
            $name = $_FILES['photo']['name'];
            $temp = $_FILES['photo']['tmp_name'];
            //echo $temp;exit;
            $folder = "./user_image/" . $name;
            move_uploaded_file($temp, "." . $folder);
        } else {
            $folder = $hidden_img;
        }
        if (!isset($city) || $city == "") {
            $ucity = $hidden_city;
        } else {
            $ucity = $city;
        }

        $qu = "UPDATE user_master SET first_name=?,last_name=?,status=?,dob=?,u_state=?,u_city=?,address=?,email=?,phone=?,course_id=?,start_year=?,duration_id=?,gender=?,profession=?,role_id=2,image=? WHERE user_id =?";
        $arr = array($fnm, $lnm, $estatus, $birth, $state, $ucity, $address, $semail, $phone, $course, $year, $duration_id, $gender, $sprofession, $folder, $user_id);
        $ans = query($qu, $arr);
        if ($ans->rowCount() == 1) {
            $res = "edit";
        } else {
            $res = "error";
        }
        $ans->closeCursor();
    }
    echo $res;
}

//checking email in update exist
if (isset($_POST['email']) && isset($_POST['id'])) {
    extract($_POST);
    $q = "SELECT email FROM user_master WHERE user_id != ? AND email = ?";
    $arr = array($id, $email);
    $ans = query($q, $arr);
    echo $ans->rowCount();
    $ans->closeCursor();
}

//checking email exist
if (isset($_POST['asemail'])) {
    extract($_POST);
    $q = "SELECT email FROM user_master WHERE email =?";
    $arr = array($asemail);
    $ans = query($q, $arr);
    $r = $ans->rowCount();
    if ($r > 0) {
        echo $r;
    }
    $ans->closeCursor();
}

//Delete the particular data
if (isset($_POST['delete_id'])) {
    $q = "UPDATE user_master SET deleted = 1 WHERE user_id = ?";
    $arr = array($_POST['delete_id']);
    $ans = query($q, $arr);
    if ($ans->rowCount() > 0) {
        $output = array("status" => "success", "message" => "Data Deleted Successfully", "title" => "Success");
    } else {
        $output = array("status" => "error", "message" => "Some error occurred", "title" => "Error");
    }
    $ans->closeCursor();
    echo json_encode($output);

}

//event Delete 
if (isset($_POST['ed_id'])) {
    $qu = "UPDATE event_master SET deleted = 1 WHERE event_id = ?";
    $arr = array($_POST["ed_id"]);
    $ans = query($qu, $arr);
    if ($ans->rowCount() == 1) {
        $output = array("status" => "success", "message" => "Event Deleted Successfully", "title" => "Success");
    } else {
        $output = array("status" => "error", "message" => "Error in deleting Event", "title" => "Error");
    }
    $ans->closeCursor();
    echo json_encode($output);
}

//display data of event
if (isset($_POST["e_id"])) {
    $output = array();
    $q = "SELECT *FROM event_master WHERE event_id =?";
    $arr = array($_POST["e_id"]);
    $res = query($q, $arr);
    $r = $res->fetch();
    if ($r) {
        $output['title'] = $r['event_title'];
        $output['start'] = $r['start_date'];
        $output['end'] = $r['end_date'];
        $output['loc'] = $r['location'];
        $output['status'] = $r['reg_status'];
        $output['himg'] = $r['event_image'];
        $output['img'] = "<img src='" . $r['event_image'] . "'  class='img-thumbnail' width='50' height='35'>";
        $output["des"] = $r['description'];
    }
    echo json_encode($output);
}


//Editing Event
if (
    isset($_POST['etitle']) &&
    isset($_POST['estart']) &&
    isset($_POST['eend']) &&
    isset($_POST['eloc'])
) {
    extract($_POST);
    if (isset($_FILES['eeimg']['name']) && $_FILES['eeimg']['name'] != "") {
        $temp = $_FILES['eeimg']['tmp_name'];
        $img = $_FILES['eeimg']['name'];
        $folder = "event/" . $img;
        move_uploaded_file($temp, $folder);
    } else {
        $folder = $hidden_img;
    }

    $qu = "UPDATE event_master SET event_title =?,location=?,description=?,start_date=?,end_date=?,event_image=?,reg_status=? WHERE event_id=?";
    $array = array($etitle, $eloc, $edescription, $estart, $eend, $folder, $estatus, $ev_id);
    $re = query($qu, $array);
    if ($re->rowCount() == 1) {
        $q = "DELETE FROM event_day WHERE event_id=?";
        $ar = array($ev_id);
        $r = query($q, $ar);
        $c = $r->rowCount();
        if ($c > 0) {
            $start = new DateTime($estart);
            $end = new DateTime($eend);
            $interval = new DateInterval('P1D');
            $period = new DatePeriod($start, $interval, $end, DatePeriod::INCLUDE_END_DATE);
            foreach ($period as $date) {
                $event_date = $date->format('Y-m-d');
                $q = 'INSERT INTO event_day(event_id,event_date) VALUES(?,?)';
                $array = array($ev_id, $event_date);
                $res = query($q, $array);
                if ($res->rowCount() == 1) {
                    $flag = true;
                } else {
                    $flag = false;
                }
                $res->closeCursor();
            }
            if ($flag == true) {
                echo "edit";
            } else {
                echo "error";
            }
        }
    }

}

//check course name exist
if (isset($_POST['cval'])) {
    extract($_POST);
    $q = "SELECT COUNT(course_id) as count FROM course_master WHERE course_nm = ?";
    $ar = [$cval];
    $r = query($q, $ar);
    $c = $r->fetch();
    echo $c["count"];
}

//adding Course
if (
    isset($_POST["course"]) &&
    isset($_POST["duration"]) &&
    isset($_POST["from"])
) {
    extract($_POST);
    $q = "INSERT INTO course_master(course_nm)VALUE(?)";
    $ar = [$course];
    $r = query($q, $ar);
    if ($r->rowCount() == 1) {
        $qu = "SELECT course_id FROM course_master ORDER BY course_id DESC LIMIT 1";
        $res = query($qu);
        $row = $res->fetch();
        if ($to != "") {
            $qur = "INSERT INTO course_duration(course_id,duration,start_year,end_year)VALUES(?,?,?,?)";
            $arr = [$row['course_id'], $duration, $from, $to];
        } else {
            $qur = "INSERT INTO course_duration(course_id,duration,start_year)VALUES(?,?,?)";
            $arr = [$row['course_id'], $duration, $from];
        }
        $r = query($qur, $arr);
        if ($r->rowCount() == 1) {
            echo "add";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}

//course name before editing
if (isset($_POST['ecval']) && isset($_POST['h_id'])) {
    extract($_POST);
    $q = "SELECT COUNT(course_id) as count FROM course_master WHERE course_nm = ? AND course_id != ?";
    $ar = [$ecval, $h_id];
    $r = query($q, $ar);
    $c = $r->fetch();
    echo $c["count"];
}

//fetching data for edit course
if (isset($_POST['c_id'])) {
    $qu = "SELECT *FROM course_master WHERE course_id = ?";
    $ar = [$_POST['c_id']];
    $r = query($qu, $ar);
    $c = $r->fetch();
    $data['name'] = $c['course_nm'];
    echo json_encode($data);

}
//delete course
if (isset($_POST['cd_id'])) {
    $output = [];
    try {
        $query = "DELETE FROM course_master WHERE course_id = ?";
        $arr = [$_POST['cd_id']];
        $r = query($query, $arr);
        if ($r->rowCount() == 1) {
            $output['status'] = 'success';
            $output['message'] = 'Course Deleted Successfully';
            $output['title'] = "Success";
        }
    } catch (PDOException) {
        $output["status"] = "error";
        $output["message"] = "You Can't Delete This Course. It has Students";
        $output["title"] = "Denied";
    }
    echo json_encode($output);
}

//edit Course
if (isset($_POST["hc_id"]) && isset($_POST['cnm'])) {
    extract($_POST);
    $qu = "UPDATE course_master SET course_nm = ? WHERE course_id = ?";
    $arr = [$cnm, $hc_id];
    $r = query($qu, $arr);
    if ($r->rowCount() == 1) {
        echo "edit";
    } else {
        echo "error";
    }
}

//Adding Course Duration
if (
    isset($_POST["dcourse"]) &&
    isset($_POST["dduration"]) &&
    isset($_POST['dfrom'])
) {
    extract($_POST);
    $qu = "UPDATE course_duration SET end_year = ? WHERE course_id = ? AND end_year IS NULL ORDER BY duration_id DESC LIMIT 1";
    $arr = [$dfrom - 1, $dcourse];
    $r = query($qu, $arr);
    $r->closeCursor();
    if ($_POST['dto'] != "") {
        $query = "INSERT INTO course_duration(course_id,duration,start_year,end_year)VALUES(?,?,?,?)";
        $array = [$dcourse, $dduration, $dfrom, $dto];
    } else {
        $query = "INSERT INTO course_duration(course_id,duration,start_year)VALUES(?,?,?)";
        $array = [$dcourse, $dduration, $dfrom];
    }
    $res = query($query, $array);
    if ($res->rowCount() == 1) {
        echo "add";
    } else {
        echo "error";
    }
}

//Checking Duration
if (
    isset($_POST["ed_cdid"]) &&
    isset($_POST["ed_from"])
) {
    extract($_POST);
    $query = "SELECT COUNT(duration_id) as total FROM course_duration WHERE course_id = ? AND COALESCE(end_year,YEAR(CURRENT_DATE))>=?";
    $array = [$ed_cdid, $ed_from];
    $r = query($query, $array);
    $row = $r->fetch();
    echo $row['total'];
}

//Providing Data For Editing Course Duration
if (isset($_POST['du_id'])) {
    $query = "SELECT *FROM course_duration WHERE duration_id =?";
    $arr = [$_POST['du_id']];
    $r = query($query, $arr);
    $res = $r->fetch();
    $output = [];
    $output["dur"] = $res["duration"];
    $output["from"] = $res["start_year"];
    $output["to"] = $res["end_year"];
    $output["course"] = $res["course_id"];
    echo json_encode($output);
}

//Checking Course Duration For Editing
if (
    isset($_POST["edd_cid"]) &&
    isset($_POST["edd_from"]) &&
    isset($_POST["edu_id"])
) {
    extract($_POST);
    $query = "SELECT COUNT(duration_id) as total FROM course_duration WHERE course_id = ? AND duration_id != ? AND COALESCE(end_year,YEAR(CURRENT_DATE))>=?";
    $array = [$edd_cid, $edu_id, $edd_from];
    $r = query($query, $array);
    $row = $r->fetch();
    echo $row['total'];
}

//Editing Course Duration
if (
    isset($_POST['edduration']) &&
    isset($_POST['edfrom']) &&
    isset($_POST['hidden_id']) &&
    isset($_POST['course'])
) {
    //print_r($_POST);
    extract($_POST);
    $query = "UPDATE course_duration SET end_year = ? WHERE course_id =? AND duration_id != ? ORDER BY duration_id DESC LIMIT 1";
    $array = [$edfrom - 1, $course, $hidden_id];
    $r = query($query, $array);
    $r->closeCursor();
    if ($edto != "") {
        $qu = "UPDATE course_duration SET duration =?,start_year=?,end_year=? WHERE duration_id = ?";
        $arr = [$edduration, $edfrom, $edto, $hidden_id];
    } else {
        $qu = "UPDATE course_duration SET duration =?,start_year=?,end_year=? WHERE duration_id =?";
        $arr = [$edduration, $edfrom, NULL, $hidden_id];
    }
    $res = query($qu, $arr);
    if ($res->rowCount() == 1) {
        echo "edit";
    } else {
        echo "error";
    }
}


//deleting Course Duration
if (isset($_POST['delete_duration'])) {
    $output = [];
    //print_r($_POST);
    try {
        $qu = "SELECT course_id FROM course_duration WHERE duration_id = ?";
        $arr = [$_POST['delete_duration']];
        $r = query($qu, $arr);
        $res = $r->fetch();
        $course = $res['course_id'];
        $r->closeCursor();
        $query = "DELETE FROM course_duration WHERE duration_id = ?";
        $arr = [$_POST['delete_duration']];
        $r = query($query, $arr);
        $r->closeCursor();
        if ($r->rowCount() == 1) {
            $qu = "UPDATE course_duration SET end_year = NULL WHERE course_id = ? ORDER BY duration_id DESC LIMIT 1";
            $arry = [$course];
            $r = query($qu, $arry);
            //echo $qu;exit;
            $output["status"] = "success";
            $output["message"] = "Duration Deleted Successfully";
            $output["title"] = "Deleted";
        }
    } catch (PDOException) {
        $output["status"] = "error";
        $output["message"] = "You Can't Delete this course Because It Has Students";
        $output["title"] = "Denied";
    }
    echo json_encode($output);
}

//Adding Event Gallary
if (isset($_POST["event"]) && isset($_FILES["ev_gal"]["name"])) {
    extract($_POST);
    $name = $_FILES['ev_gal']['name'];
    $tmp = $_FILES['ev_gal']['tmp_name'];
    $folder = "event gallary/" . $name;
    move_uploaded_file($tmp, $folder);
    $query = "INSERT INTO event_gallary(event_id,image) VALUES(?,?)";
    $arr = [$event, $folder];
    $r = query($query, $arr);
    if ($r->rowCount() == 1) {
        echo "add";
    } else {
        echo "error";
    }
}

//Deleting Gallary
if (isset($_POST["dgal_id"])) {
    extract($_POST);
    try {
        $query = "SELECT image FROM event_gallary WHERE gallary_id = ?";
        $arr = [$dgal_id];
        $r = query($query, $arr);
        $img = $r->fetch();
        unlink($img['image']);
        $r->closeCursor();
        $qu = "DELETE FROM event_gallary WHERE gallary_id=?";
        $ar = [$dgal_id];
        $res = query($qu, $ar);
        if ($res->rowCount() == 1) {
            $output["status"] = "success";
            $output["message"] = "Photo Deleted Successfully";
            $output["title"] = "Deleted";
        }
    } catch (Exception $e) {
        $output["status"] = "error";
        $output["message"] = $e->getMessage();
        $output["title"] = "Error";
    }

    echo json_encode($output);
}

//Providing Data For Editing Gallary
if (isset($_POST["egal_id"])) {
    extract($_POST);
    $output = [];
    $query = "SELECT *FROM event_gallary WHERE gallary_id = ?";
    $arr = [$egal_id];
    $r = query($query, $arr);
    $row = $r->fetch();
    $output['himg'] = $row['image'];
    $output['img'] = "<img src='" . $row['image'] . "'  class='img-thumbnail' width='100' height='55'>";
    $output["event"] = $row["event_id"];
    echo json_encode($output);
}

//Editing Gallary
if (
    isset($_POST["eevent"]) &&
    isset($_POST["hidden_img"]) &&
    isset($_POST["gal_id"])
) {
    //print_r($_POST);
    extract($_POST);
    if (isset($_FILES["egal_img"]["name"]) && $_FILES["egal_img"]["name"] != "") {
        unlink($hidden_img);
        $nm = $_FILES["egal_img"]["name"];
        $tmp = $_FILES["egal_img"]["tmp_name"];
        $folder = "event gallary/" . $nm;
        move_uploaded_file($tmp, $folder);
    } else {
        $folder = $hidden_img;
    }
    $upQ = "UPDATE event_gallary SET event_id = ?,image = ? WHERE gallary_id = ?";
    $arr = [$eevent, $folder, $gal_id];
    $r = query($upQ, $arr);
    if ($r->rowCount() == 1) {
        echo "edit";
    } else {
        echo "error";
    }
}

//Old Password Check
if (isset($_POST['ov'])) {
    extract($_POST);
    $qu = "SELECT password FROM user_master WHERE password = ? AND user_id = ?";
    $arr = [md5($ov), $_SESSION['admin_id']];
    $r = query($qu, $arr);
    echo $r->rowCount();
}

//Changing Password
if (isset($_POST['new'])) {
    extract($_POST);
    $qu = "UPDATE user_master SET password =? WHERE user_id = ?";
    $arr = [md5($new), $_SESSION['admin_id']];
    $r = query($qu, $arr);
    if ($r->rowCount() == 1) {
        echo "change";
    } else {
        echo "error";
    }
}
?>