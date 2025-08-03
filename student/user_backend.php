<?php
require "../dbconfig.php";
session_start();
//Display Data For Event Registration 
if (isset($_POST["event"])) {
  $q = "SELECT *
          FROM 
            event_day
          WHERE
            event_id= ?";
  $arr = [$_POST["event"]];
  $res = query($q, $arr);
  $html = "";
  if ($res->rowCount() > 0) {
    if ($res->rowCount() == 1) {
      $row = $res->fetch();
      $html .= "
       <script>
             Swal.fire({
            title: 'Are you sure to submit?',
            icon: 'warning',
            showClass: {
                popup: `
                animate__animated
                animate__fadeInDown
                animate__faster
              `
            },
            hideClass: {
                popup: `
                 animate__animated
                 animate__fadeOutUp
                 animate__faster
               `
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader').show();
                var dayid =" . $row["day_id"] . ";
                var date = " . $row["event_date"] . ";
                $.ajax({
                    type: 'POST',
                    url: 'user_backend.php',
                    data: {day : dayid, eventid : " . $_POST["event"] . ",date : date},
                    success: function (data) {
                        $('.loader').hide();
                        if (data == 'reg') {
                            Swal.fire({
                                title: 'Submitted!',
                                text: 'Registered Successfully',
                                icon: 'success',
                                showClass: {
                                    popup: `
                                animate__animated
                                animate__fadeInDown
                                animate__faster
                              `
                                },
                                hideClass: {
                                    popup: `
                                 animate__animated
                                 animate__fadeOutUp
                                 animate__faster
                               `
                                }
                            }).then((result)=>{
                               window.location.reload();
                            });

                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Some error occurred',
                                icon: 'error',
                                showClass: {
                                    popup: `
                                animate__animated
                                animate__fadeInDown
                                animate__faster
                              `
                                },
                                hideClass: {
                                    popup: `
                                 animate__animated
                                 animate__fadeOutUp
                                 animate__faster
                               `
                                }
                            });
                        }
                    }
                });
            }
        });
       </script>
       ";
    } else {
      $row = $res->fetchAll();
      $html .= "
          <!-- Modal -->
          <div class='modal fade' id='eventreg' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h1 class='modal-title fs-5' id='staticBackdropLabel'>Select Days</h1>
                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                <div class='row container text-center'>
                <form id='eventdays'>";
      $num = 0;
      foreach ($row as $r) {
        $num++;
        if ($r["event_date"] <= date("Y-m-d")) {
          continue;
        }
        $html .= "<div class='col-md-12'>
                        <input type='checkbox' name='days[]' value='" . $r["day_id"] . "' class='btn-check' id='" . $r["day_id"] . "' autocomplete='off'>
                        <label class='btn btn-outline-success' for='" . $r["day_id"] . "'>Day $num " . date("dS M Y", strtotime($r["event_date"])) . "</label><br><br>
                   </div> ";
      }
      $html .= "
      <input type='hidden' name='eventid' value='" . $_POST["event"] . "'>
      </form>
      </div>
      </div>
                <div class='modal-footer'>
                  <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                  <button type='button' class='activel fs-6 rounded' id='reg'>Register</button>
                </div>
              </div>
            </div>
          </div>
        ";

      $html .= "<script>
              $('#eventreg').modal('show');
        </script>";
    }
    $output = ["html" => $html];

    echo json_encode($output);
  }
}


//Registration Of One Day
if (
  isset($_POST["day"]) &&
  isset($_POST["eventid"]) &&
  isset($_POST["date"])
) {
  $qu = "INSERT INTO 
              event_registration(user_id,day_id) 
           VALUES
              (?,?)";
  $arr = [$_SESSION["student_id"], $_POST["day"]];
  $res = query($qu, $arr);
  if ($res->rowCount() == 1) {
    $res->closeCursor();
    $q = "SELECT *
             FROM 
                event_master 
             WHERE  
                event_id = ?";

    $arr = [$_POST["eventid"]];
    $res = query($q, $arr);
    $event = $res->fetch();
    $msg = "<h3> Hello <b>" . ucwords($_SESSION["sname"] . " " . $_SESSION["ssurname"]) . "</b> </h3>
                  <br><br> Your Registration In  " . $event["event_title"] . " is Successfull here is the Details....<br><br>
                  <b> Registration Date And Time: <span style='color:green'>" . date("l , F j , Y | h:i A ", strtotime($event["start_date"])) . " " . date("- h:i A", strtotime($event["end_date"])) . "</span>
                  <br>Location : " . $event["location"] . "</b>
                  <br><br><br><hr><br>
                  " . $event["description"] . "
                  ";
    send_email($_SESSION["alumni"], $msg, "Event Registration Status");
    echo "reg";
  } else {
    echo "error";
  }
}

//Registration Of Multiple Days
if (
  isset($_POST["days"]) &&
  isset($_POST["eventid"])
) {
  $flag = false;
  foreach ($_POST["days"] as $d) {
    $qu = "INSERT INTO 
              event_registration (user_id,day_id) 
           VALUES
              (?,?)";
    $arr = [$_SESSION["student_id"], $d];
    $res = query($qu, $arr);
    if ($res->rowCount() == 1) {
      $flag = true;
    }
    $res->closeCursor();
  }
  if ($flag == true) {
    $day_id = implode(",", $_POST["days"]);
    $q = "SELECT 
            event_date 
          FROM 
            event_day 
          WHERE 
            day_id IN($day_id)";
    $ans = query($q);
    $row = $ans->fetchAll();
    //print_r($row);exit;
    $count = $ans->rowCount();
    $ans->closeCursor();
    $qu = "SELECT *
    FROM 
       event_master 
    WHERE  
       event_id = ?";

    $arr = [$_POST["eventid"]];
    $res = query($qu, $arr);
    $event = $res->fetch();
    $res->closeCursor();
    if ($count === 1) {
      $msg = "<h3> Hello <b>" . ucwords($_SESSION["sname"] . " " . $_SESSION["ssurname"]) . "</b> </h3>
                  <br><br> Your Registration In  " . $event["event_title"] . " is Successfull here is the Details....<br><br>
                  <b> Registration Date: <span style='color:green'>" . date("l , F j , Y", strtotime($row[0]["event_date"])) . "</span>
                  <br>Location : " . $event["location"] . "</b>
                  <br><br><br><hr><br>
                  " . $event["description"] . "
                  ";
    } else {
      $date = [];
      //print_r($row);exit;
      foreach ($row as $r) {
        $date[] = date("l , F j , Y", strtotime($r["event_date"]));
      }
      $rdate = implode("<br> Registred Date: ", $date);
      $msg = "<h3> Hello <b>" . ucwords($_SESSION["sname"] . " " . $_SESSION["ssurname"]) . "</b> </h3>
                  <br><br> Your Registration In  " . $event["event_title"] . " is Successfull here is the Details....<br><br>
                  <b> Registred Date: " . $rdate . "
                  <br>Location : " . $event["location"] . "</b>
                  <br><br><br><hr><br>
                  " . $event["description"] . "
                  ";
    }
    send_email($_SESSION["alumni"], $msg, "Event Registration Status");
    $ans->closeCursor();
    echo "reg";
  } else {
    echo "error";
  }
}


//Registration Canceled
if (isset($_POST["del_reg"])) {
  $qu = "DELETE er.*
        FROM 
          event_registration er
        JOIN event_day ed ON
          er.day_id = ed.day_id
        WHERE 
          ed.event_id = ? AND er.user_id = ? ";
  $arr = [$_POST["del_reg"], $_SESSION["student_id"]];
  $del = query($qu, $arr);
  if ($del->rowCount() > 0) {
    $del->closeCursor();
    $q = "SELECT 
              event_title
           FROM 
              event_master
           WHERE
              event_id = ? ";
    $ar = [$_POST["del_reg"]];
    $ev = query($q, $ar);
    $event = $ev->fetch();
    $msg = "<h4>Hello <b>" . ucwords($_SESSION["sname"] . " " . $_SESSION["ssurname"]) . "</b> </h4>
              <br>Your Registration Of <b>" . $event["event_title"] . "</b> Has Been <span style='color:red;'>Canceled</span>";
    send_email($_SESSION["alumni"], $msg, "Registration Canceled");
    echo "del";
  } else {
    echo "error";
  }
}

//Registration details
if (isset($_POST["e_id"])) {
  $qu = "SELECT 
          ed.event_date
        FROM 
          event_day ed
        JOIN event_registration er ON
          ed.day_id = er.day_id
        WHERE 
          ed.event_id = ? AND er.user_id = ?";
  $arr = [$_POST["e_id"], $_SESSION["student_id"]];
  $res = query($qu, $arr);
  $event = $res->fetchAll();
  $count = $res->rowCount();
  $res->closeCursor();
  if ($count > 0) {
    if ($count == 1) {
      $html = '<div class="modal fade" id="reg_date" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Registration Date</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-5">
                      <table class="table table-striped table-bordered shadow-lg"><th class="table-dark">Registration Date: </th><tr><td>' . date("l , dS F , Y", strtotime($event[0]["event_date"])) . '</td></tr></table>
                    </div>
                  </div>
                </div>
              </div>
              
              <script>
                $("#reg_date").modal("show");
              </script>';
    } else {
      $date = [];
      foreach ($event as $e) {
        $date[] = date("l , dS F , Y", strtotime($e["event_date"]));
      }
      $reg_date = implode("</td></tr><tr><td>", $date);
      $html = '
              <div class="modal fade" id="reg_date" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Registration Date</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-5">
                      <table class="table table-striped table-bordered shadow-lg"><th class="table-dark"> Registration Date:</th><tr><td> ' . $reg_date . '</td></tr></table>
                    </div>
                  </div>
                </div>
              </div>
              
              <script>
                $("#reg_date").modal("show");
              </script>';
    }
    $output = ["html" => $html];
    echo json_encode($output);
  }
}

if (isset($_POST["viewalumni"])) {
  $qu = "SELECT 
            *,
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
            um.user_id = ?";
  $arr = [$_POST["viewalumni"]];
  $res = query($qu, $arr);
  $row = $res->fetch();
  $res->closeCursor();
  $add=(trim($row['address'])!="")? $row['address']." , ":"";
  $html = '<div class="row">
              <div class="col-md-4">
                  <img src=".'.$row["image"].'" alt="Alumni Image" class="alumni-image">
              </div>
              <div class="col-md-8">
                  <h2>'.ucwords($row["first_name"]." ".$row["last_name"]).'</h2>
                  <p>Gender : '.$row["gender"].'</p>
                  <p>Date Of Birth: '.date("d-m-Y",strtotime($row["dob"])).'</p>
                  <p>Class of '.$row["class"].'</p>
                  <p>Course : '.$row["course_nm"].'</p>
                  <p>'.($row["profession"] != "" ? "Currrent Profession: ".$row["profession"] : "" ).'</p>
                  <p>Address: '.$add.$row['u_city']." ,".$row["u_state"].'</p>
                  <p>Contact Information:</p>
                  <ul>
                      <li>Email: <a href="'.$row["email"].'">'.$row["email"].'</a></li>
                      <li>Phone:'.$row["phone"].'</li>
                  </ul>
              </div>
          </div>
         ';
         $output = ["html" => $html];
  echo json_encode($output);
}

//Update Details of alumni
if(isset($_POST["fnm"]) &&
isset($_POST["lnm"]) &&
isset($_POST["birth"]) &&
isset($_POST["state"]) &&
isset($_POST["semail"]) &&
isset($_POST["phone"])
){
    $form_data = filter($_POST);
    extract($form_data);
    //print_r($form_data);exit;
    //echo $duration_id;
    if ($_FILES['photo']['name'] != "") {
        $name = $_FILES['photo']['name'];
        $temp = $_FILES['photo']['tmp_name'];
        unlink(".".$hidden_img);
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

    $qu = "UPDATE user_master SET first_name=?,last_name=?,dob=?,u_state=?,u_city=?,address=?,email=?,phone=?,gender=?,profession=?,role_id=2,image=? WHERE user_id =?";
    $arr = array($fnm, $lnm,$birth, $state, $ucity, $address, $semail, $phone, $gender, $sprofession, $folder, $user_id);
    $ans = query($qu, $arr);
    if ($ans->rowCount() == 1) {
        $res = "edit";
        $_SESSION["sname"] = $fnm;
        $_SESSION["ssurname"] = $lnm;
        $_SESSION["sdob"] = $birth;
        $_SESSION["sstate"] = $state;
        $_SESSION["scity"] = $ucity;
        $_SESSION["saddress"] = $address;
        $_SESSION["alumni"] = $semail;
        $_SESSION["sphone"] = $phone;
        $_SESSION["sgender"] = $gender;
        $_SESSION["simage"] = $folder;
        $_SESSION["profession"] = $sprofession;
    } else {
        $res = "error";
    }
    $ans->closeCursor();
    echo $res;
}

//Old Password Check
if (isset($_POST['ov'])) {
  extract($_POST);
  $qu = "SELECT password FROM user_master WHERE password = ? AND user_id = ?";
  $arr = [md5($ov), $_SESSION['student_id']];
  $r = query($qu, $arr);
  echo $r->rowCount();
}

//Changing Password
if (isset($_POST['new'])) {
  extract($_POST);
  $qu = "UPDATE user_master SET password =? WHERE user_id = ?";
  $arr = [md5($new), $_SESSION['student_id']];
  $r = query($qu, $arr);
  if ($r->rowCount() == 1) {
      echo "change";
  } else {
      echo "error";
  }
}
?>
