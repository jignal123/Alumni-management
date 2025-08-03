<?php
include("admin_header.php");
?>
<div class="card">
  <div class="card-header text-white text-center" style="background-color: purple;">
    <h1>Alumni Report</h1>
  </div>
  <div class="card-body">
    <div class=" d-flex justify-content-between">
      <button id="print" class="btn btn-danger"><i class="fa-solid fa-download"></i> Download PDF<i
          class="fa-solid fa-file-pdf ps-1"></i> Report</button>
      <button class="activel fs-6 rounded" data-bs-toggle="modal" data-bs-target="#usermodal"><i
          class="fa-solid fa-user-plus pe-1"></i>Add</button>
    </div>
    <div class="container w-25 shadow p-3">
      <form action="" method="post">
      <div class="col-md-12">
        <label for="fcourse" class="form-label">Course</label>
        <select name="fcourse" id="fcourse" class="form-select">
          <option value="" selected disabled>select-course</option>
          <?php
          $q = "SELECT * FROM course_master";
          $r = query($q);
          $ar = $r->fetchAll();
          if ($r->rowCount()) {
            foreach ($ar as $a) {
              echo "<option value=$a[course_id]>$a[course_nm]</option>";
            }
          }

          ?>
        </select>
      </div>
      <div class="col-md-12">
        <label for="fyear" class="form-label">From</label>
        <select name="fyear" id="fyear" class="form-select">
          <option value="" selected disabled>select-from</option>
          <?php
          $year = date("Y", time());
          $num = 1970;
          while ($num <= $year) {
            echo "<option value='$num'>$num</option>";
            $num++;
          }
          ?>
        </select>
      </div>
      <div class="col-md-12">
        <label for="tyear" class="form-label">To</label>
        <select name="tyear" id="tyear" class="form-select">
          <option value="" selected disabled>select-to</option>
          <?php
          $year = date("Y", time());
          $num = 1970;
          while ($num <= $year) {
            echo "<option value='$num'>$num</option>";
            $num++;
          }
          ?>
        </select>
      </div>
      <div class="col-md-12 text-center mt-2">
        <button type="button" id="filter" class="activel fs-6">Filter</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
      </div>

      </form>
    </div>
    <div class="table-responsive">
      <table class="table table-sm table-striped table-bordered table-hover mt-5 align-middle shadow-lg"
        id="alumni_data">
        <thead class="table-dark">
          <tr>
            <th>User_id</th>
            <th>Image</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>email</th>
            <th>Phone</th>
            <th>Course</th>
            <th>Start Year</th>
            <th>End Year</th>
            <th>Profession</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    getalumni();
    $('#filter').on('click', function () {
      var course = $("#fcourse").val();
      var start = $("#fyear").val();
      var end = $("#tyear").val();
      if (course != "" && start != "" && end != "") {
        if (start > end) {
          alert("Start year should be less than end year");
        }
        else {
          $("#alumni_data").DataTable().destroy();
          getalumni(course, start, end);
        }
      } else {
        alert("Please select all fields");
      }
    })
  });
  function getalumni(course = "", start = "", end = "") {
    var datatable = $("#alumni_data").DataTable({
      processing: true,
      serverSide: true,
      order: [],
      ajax: {
        url: "fetch.php",
        method: "POST",
        data: {
          course: course,
          from: start,
          end: end
        }
      },
      columnDefs: [{
        "target": [0, 1, 4, 14, 15],
        "orderable": false
      }],
      layout: {
        top1start: {
          buttons: ['colvis']
        }
      }
    });
  }
  $('#print').click(function (e) {
    //e.preventDefault();
    $(".loader").show();
    var tableHTML = $("#alumni_data").prop('outerHTML');
    var course = $("#fcourse").find(":selected").text();
    var start = $("#fyear").val();
    var end = $("#tyear").val();
    $.ajax({
      type: "post",
      url: "report.php",
      data: {
        tableHTML: tableHTML,
        course: course,
        start: start,
        end: end
      },
      dataType : "json",
      success: function (response) {
        //alert(response);
        $(".loader").hide();
        if (response.status === "success") {
          window.location.href = response.filePath;
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("An error occurred.");
      }
    });
  });

</script>
<!-- Add Modal -->
<div class="modal fade" id="usermodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Alumni</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="addform" class="row mt-1 p-2">
          <div class="col-md-4">
            <label for="fnm" class="form-label">First Name</label>
            <div class="input-field">
              <input type="text" name="afnm" id="afnm" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="lnm" class="form-label">Last Name</label>
            <div class="input-field">
              <input type="text" name="alnm" id="alnm" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="gender" class="form-label">Gender</label>
            <div class="input-field">
              <select class="form-select" name="agender" id="agender">
                <option value="" selected disabled>select-gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="birth" class="form-label">Birth Date</label>
            <div class="input-field">
              <input type="date" name="abirth" id="abirth" class="form-control" max="2006-12-31">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex"></span>
            </div>
          </div>
          <div class="col-md-4">
            <lable for="country" class="form-label">State</lable>
            <div class="input-field">
              <select name="astate" id="astate" class="form-select mt-2">
                <option value="">Select-state</option>
                <option value="Andra Pradesh">Andra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madya Pradesh">Madya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Orissa">Orissa</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttaranchal">Uttaranchal</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="West Bengal">West Bengal</option>
                <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadeep">Lakshadeep</option>
                <option value="Pondicherry">Pondicherry</option>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <lable for="country" class="form-label">City</lable>
            <div class="input-field">
              <select name="acity" id="acity" class="form-select mt-2">
                <option value="">Select-City</option>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-12">
            <div class="input-field">
              <lable for="address" class="form-label">Address</lable>
              <textarea name="aaddress" id="aaddress" class="form-control">
            </textarea>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="course" class="form-label">Course</label>
            <div class="input-field">
              <select name="acourse" id="acourse" class="form-select">
                <option value="" selected disabled>select-course</option>
                <?php
                $q = "SELECT * FROM course_master";
                $r = query($q);
                $ar = $r->fetchAll();
                if ($r->rowCount()) {
                  foreach ($ar as $a) {
                    echo "<option value=$a[course_id]>$a[course_nm]</option>";
                  }
                }

                ?>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <lable for="year" class="form-label">Starting Year</lable>
            <div class="input-field">
              <select name="ayear" id="ayear" class="form-select mt-2">
                <option value="" selected disabled>select-starting-year</option>
                <?php
                $year = 1974;
                while ($year != date("Y")) {
                  echo " <option value='$year'>$year</option>";
                  $year++;
                }
                ?>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="sprofession" class="form-label">Profession</label>
            <div class="input-field">
              <input type="text" name="aprofession" id="aprofession" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <label for="semail" class="form-label">Email</label>
            <div class="input-field">
              <input type="email" name="aemail" id="aemail" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <div class="input-field">
              <input type="text" name="aphone" id="aphone" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
              <option value="un" selected>Unverify</option>
              <option value="v">Verify</option>
            </select>
          </div>
          <div class="col-md-4">
            <label for="pwd" class="form-label">Password</label>
            <div class="input-field">
              <input type="password" name="apwd" id="apwd" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="cpwd" class="form-label">Confirm Password</label>
            <div class="input-field">
              <input type="password" name="acpwd" id="acpwd" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-12">
            <label for="photo" class="form-label">Your Profile Photo</label>
            <div class="input-field">
              <input type="file" name="aphoto" id="aphoto" accept="image/" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex"></span>
            </div>
          </div>
          <input type="hidden" name="op" id="op" value="add">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="button" name="add" id="add" class="activel fs-6 rounded" value="Add">
      </div>
    </div>
  </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">EDIT ALUMNI DETAILS</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="myform" class="row mt-1 p-2">
          <div class="col-md-4">
            <label for="fnm" class="form-label">First Name</label>
            <div class="input-field">
              <input type="text" name="fnm" id="fnm" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="lnm" class="form-label">Last Name</label>
            <div class="input-field">
              <input type="text" name="lnm" id="lnm" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="gender" class="form-label">Gender</label>
            <div class="input-field">
              <select class="form-select" name="gender" id="gender">
                <option value="" selected disabled>select-gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="birth" class="form-label">Birth Date</label>
            <div class="input-field">
              <input type="date" name="birth" id="birth" class="form-control" max="2006-12-31">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex"></span>
            </div>
          </div>
          <div class="col-md-4">
            <lable for="country" class="form-label">State</lable>
            <div class="input-field">
              <select name="state" id="state" class="form-select mt-2">
                <option value="">Select-state</option>
                <option value="Andra Pradesh">Andra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Madya Pradesh">Madya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Orissa">Orissa</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttaranchal">Uttaranchal</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="West Bengal">West Bengal</option>
                <option disabled style="background-color:#aaa; color:#fff">UNION Territories</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Lakshadeep">Lakshadeep</option>
                <option value="Pondicherry">Pondicherry</option>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <lable for="country" class="form-label">City</lable>
            <div class="input-field">
              <select name="city" id="city" class="form-select mt-2">
                <option value="">Select-City</option>
              </select>
              <input type="hidden" name="hidden_city" id="hidden_city">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-12">
            <div class="input-field">
              <lable for="address" class="form-label">Address</lable>
              <textarea name="address" id="address" class="form-control">
            </textarea>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="course" class="form-label">Course</label>
            <div class="input-field">
              <select name="course" id="course" class="form-select">
                <option value="" selected disabled>select-course</option>
                <?php
                $q = "SELECT * FROM course_master";
                $r = query($q);
                $ar = $r->fetchAll();
                if ($r->rowCount()) {
                  foreach ($ar as $a) {
                    echo "<option value=$a[course_id]>$a[course_nm]</option>";
                  }
                }

                ?>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <lable for="year" class="form-label">Starting Year</lable>
            <div class="input-field">
              <select name="year" id="year" class="form-select mt-2">
                <option value="" selected disabled>select-starting-year</option>
                <?php
                $year = 1974;
                while ($year != date("Y")) {
                  echo " <option value='$year'>$year</option>";
                  $year++;
                }
                ?>
              </select>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="sprofession" class="form-label">Profession</label>
            <div class="input-field">
              <input type="text" name="sprofession" id="sprofession" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="semail" class="form-label">Email</label>
            <div class="input-field">
              <input type="email" name="semail" id="semail" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="phone" class="form-label">Phone</label>
            <div class="input-field">
              <input type="text" name="phone" id="phone" class="form-control">
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex">
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select name="estatus" id="estatus" class="form-select">
              <option value="un">Unverify</option>
              <option value="v">Verify</option>
            </select>
          </div>
          <div class="col-md-8">
            <label for="photo" class="form-label">Your Profile Photo</label>
            <div class="input-field">
              <input type="file" name="photo" id="photo" accept="image/" class="form-control">
              <input type='hidden' name='hidden_img' id='hidden_img'>
              <i class="fa" aria-hidden="true"></i>
              <span class="d-flex"></span>
            </div>
          </div>
          <div class="col-md-2" id="uploded-img">
          </div>
          <input type="hidden" name="user_id" id="user_id">
          <input type="hidden" name="operation" id="operation" value="edit">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="button" name="action" id="action" class="activel fs-6 rounded" value="Edit">
      </div>
    </div>
  </div>
</div>
<script>
  $(document).on('click', '.update', function () {
    var user_id = $(this).attr("id");
    // alert(user_id);
    $.ajax({
      type: "post",
      url: "admin_backend.php",
      data: { user_id: user_id },
      dataType: "json",
      success: function (data) {
        //alert(data);
        $("#editmodal").modal('show');
        $('#fnm').val(data.fnm);
        $('#lnm').val(data.lnm);
        $("#estatus").val(data.status);
        $('#gender').val(data.gender);
        $('#birth').val(data.birth);
        $('#state').val(data.state);
        $('#city').val(data.city);
        $('#address').val(data.address);
        $('#course').val(data.course);
        $("#year").val(data.year);
        $('#sprofession').val(data.profession);
        $('#semail').val(data.email);
        $('#phone').val(data.phone);
        $('#user_id').val(user_id);
        $('#uploded-img').html(data.img);
        $("#hidden_img").val(data.imgpt);
        $('#hidden_city').val(data.city);
      }
    });
  });
  $(document).on('click', '.delete', function () {
    Swal.fire({
      title: "Are you sure to Delete Alumni?",
      icon: "warning",
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
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes!"
    }).then((result) => {
      if (result.isConfirmed) {
        //$('.loader').show();
        var delete_id = $(this).attr("id");
        $.ajax({
          type: "POST",
          url: "admin_backend.php",
          data: { delete_id: delete_id },
          dataType: "json",
          success: function (data) {
            //$('.loader').hide();
            //alert(data);
            $("#alumni_data").DataTable().ajax.reload();
            Swal.fire({
              title: data.title,
              text: data.message,
              icon: data.status,
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
            })
          }
        });
      }
    });
  });
</script>
<script>
  var AndraPradesh = ["Anantapur", "Chittoor", "East Godavari", "Guntur", "Kadapa", "Krishna", "Kurnool", "Prakasam", "Nellore", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari"];
  var ArunachalPradesh = ["Anjaw", "Changlang", "Dibang Valley", "East Kameng", "East Siang", "Kra Daadi", "Kurung Kumey", "Lohit", "Longding", "Lower Dibang Valley", "Lower Subansiri", "Namsai", "Papum Pare", "Siang", "Tawang", "Tirap", "Upper Siang", "Upper Subansiri", "West Kameng", "West Siang", "Itanagar"];
  var Assam = ["Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup Metropolitan", "Kamrup (Rural)", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli", "Morigaon", "Nagaon", "Nalbari", "Dima Hasao", "Sivasagar", "Sonitpur", "South Salmara Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong"];
  var Bihar = ["Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", "Buxar", "Darbhanga", "East Champaran", "Gaya", "Gopalganj", "Jamui", "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", "Madhepura", "Madhubani", "Munger", "Muzaffarpur", "Nalanda", "Nawada", "Patna", "Purnia", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"];
  var Chhattisgarh = ["Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband", "Janjgir Champa", "Jashpur", "Kabirdham", "Kanker", "Kondagaon", "Korba", "Koriya", "Mahasamund", "Mungeli", "Narayanpur", "Raigarh", "Raipur", "Rajnandgaon", "Sukma", "Surajpur", "Surguja"];
  var Goa = ["North Goa", "South Goa"];
  var Gujarat = ["Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", "Bhavnagar", "Botad", "Chhota Udaipur", "Dahod", "Dang", "Devbhoomi Dwarka", "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda", "Kutch", "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar", "Tapi", "Vadodara", "Valsad"];
  var Haryana = ["Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurugram", "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", "Mewat", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", "Sonipat", "Yamunanagar"];
  var HimachalPradesh = ["Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul Spiti", "Mandi", "Shimla", "Sirmaur", "Solan", "Una"];
  var JammuKashmir = ["Anantnag", "Bandipora", "Baramulla", "Budgam", "Doda", "Ganderbal", "Jammu", "Kargil", "Kathua", "Kishtwar", "Kulgam", "Kupwara", "Leh", "Poonch", "Pulwama", "Rajouri", "Ramban", "Reasi", "Samba", "Shopian", "Srinagar", "Udhampur"];
  var Jharkhand = ["Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", "Sahebganj", "Seraikela Kharsawan", "Simdega", "West Singhbhum"];
  var Karnataka = ["Bagalkot", "Bangalore Rural", "Bangalore Urban", "Belgaum", "Bellary", "Bidar", "Vijayapura", "Chamarajanagar", "Chikkaballapur", "Chikkamagaluru", "Chitradurga", "Dakshina Kannada", "Davanagere", "Dharwad", "Gadag", "Gulbarga", "Hassan", "Haveri", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysore", "Raichur", "Ramanagara", "Shimoga", "Tumkur", "Udupi", "Uttara Kannada", "Yadgir"];
  var Kerala = ["Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", "Thiruvananthapuram", "Thrissur", "Wayanad"];
  var MadhyaPradesh = ["Agar Malwa", "Alirajpur", "Anuppur", "Ashoknagar", "Balaghat", "Barwani", "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", "Hoshangabad", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Panna", "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna",
    "Sehore", "Seoni", "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", "Ujjain", "Umaria", "Vidisha"
  ];
  var Maharashtra = ["Ahmednagar", "Akola", "Amravati", "Aurangabad", "Beed", "Bhandara", "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar", "Parbhani", "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", "Thane", "Wardha", "Washim", "Yavatmal"];
  var Manipur = ["Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"];
  var Meghalaya = ["East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "North Garo Hills", "Ri Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"];
  var Mizoram = ["Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip", "Aizawl", "Champhai", "Kolasib", "Lawngtlai", "Lunglei", "Mamit", "Saiha", "Serchhip"];
  var Nagaland = ["Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", "Mon", "Peren", "Phek", "Tuensang", "Wokha", "Zunheboto"];
  var Odisha = ["Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", "Debagarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghpur", "Jajpur", "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar", "Khordha", "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nayagarh", "Nuapada", "Puri", "Rayagada", "Sambalpur", "Subarnapur", "Sundergarh"];
  var Punjab = ["Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", "Firozpur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", "Mansa", "Moga", "Mohali", "Muktsar", "Pathankot", "Patiala", "Rupnagar", "Sangrur", "Shaheed Bhagat Singh Nagar", "Tarn Taran"];
  var Rajasthan = ["Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", "Ganganagar", "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", "Sawai Madhopur", "Sikar", "Sirohi", "Tonk", "Udaipur"];
  var Sikkim = ["East Sikkim", "North Sikkim", "South Sikkim", "West Sikkim"];
  var TamilNadu = ["Ariyalur", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", "Dindigul", "Erode", "Kanchipuram", "Kanyakumari", "Karur", "Krishnagiri", "Madurai", "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Salem", "Sivaganga", "Thanjavur", "Theni", "Thoothukudi", "Tiruchirappalli", "Tirunelveli", "Tiruppur", "Tiruvallur", "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"];
  var Telangana = ["Adilabad", "Bhadradri Kothagudem", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar", "Jogulamba", "Kamareddy", "Karimnagar", "Khammam", "Komaram Bheem", "Mahabubabad", "Mahbubnagar", "Mancherial", "Medak", "Medchal", "Nagarkurnool", "Nalgonda", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", "Ranga Reddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", "Warangal Rural", "Warangal Urban", "Yadadri Bhuvanagiri"];
  var Tripura = ["Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", "Unakoti", "West Tripura"];
  var UttarPradesh = ["Agra", "Aligarh", "Allahabad", "Ambedkar Nagar", "Amethi", "Amroha", "Auraiya", "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", "Chitrakoot", "Deoria", "Etah", "Etawah", "Faizabad", "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", "Hapur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kheri", "Kushinagar", "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", "Raebareli", "Rampur", "Saharanpur", "Sambhal", "Sant Kabir Nagar", "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi"];
  var Uttarakhand = ["Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", "Nainital", "Pauri", "Pithoragarh", "Rudraprayag", "Tehri", "Udham Singh Nagar", "Uttarkashi"];
  var WestBengal = ["Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur", "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", "Paschim Bardhaman", "Paschim Medinipur", "Purba Bardhaman", "Purba Medinipur", "Purulia", "South 24 Parganas", "Uttar Dinajpur"];
  var AndamanNicobar = ["Nicobar", "North Middle Andaman", "South Andaman"];
  var Chandigarh = ["Chandigarh"];
  var DadraHaveli = ["Dadra Nagar Haveli"];
  var DamanDiu = ["Daman", "Diu"];
  var Delhi = ["Central Delhi", "East Delhi", "New Delhi", "North Delhi", "North East Delhi", "North West Delhi", "Shahdara", "South Delhi", "South East Delhi", "South West Delhi", "West Delhi"];
  var Lakshadweep = ["Lakshadweep"];
  var Puducherry = ["Karaikal", "Mahe", "Puducherry", "Yanam"];


  $("#state").change(function () {
    var StateSelected = $(this).val();
    var optionsList;
    var htmlString = "";

    switch (StateSelected) {
      case "Andra Pradesh":
        optionsList = AndraPradesh;
        break;
      case "Arunachal Pradesh":
        optionsList = ArunachalPradesh;
        break;
      case "Assam":
        optionsList = Assam;
        break;
      case "Bihar":
        optionsList = Bihar;
        break;
      case "Chhattisgarh":
        optionsList = Chhattisgarh;
        break;
      case "Goa":
        optionsList = Goa;
        break;
      case "Gujarat":
        optionsList = Gujarat;
        break;
      case "Haryana":
        optionsList = Haryana;
        break;
      case "Himachal Pradesh":
        optionsList = HimachalPradesh;
        break;
      case "Jammu and Kashmir":
        optionsList = JammuKashmir;
        break;
      case "Jharkhand":
        optionsList = Jharkhand;
        break;
      case "Karnataka":
        optionsList = Karnataka;
        break;
      case "Kerala":
        optionsList = Kerala;
        break;
      case "Madya Pradesh":
        optionsList = MadhyaPradesh;
        break;
      case "Maharashtra":
        optionsList = Maharashtra;
        break;
      case "Manipur":
        optionsList = Manipur;
        break;
      case "Meghalaya":
        optionsList = Meghalaya;
        break;
      case "Mizoram":
        optionsList = Mizoram;
        break;
      case "Nagaland":
        optionsList = Nagaland;
        break;
      case "Orissa":
        optionsList = Orissa;
        break;
      case "Punjab":
        optionsList = Punjab;
        break;
      case "Rajasthan":
        optionsList = Rajasthan;
        break;
      case "Sikkim":
        optionsList = Sikkim;
        break;
      case "Tamil Nadu":
        optionsList = TamilNadu;
        break;
      case "Telangana":
        optionsList = Telangana;
        break;
      case "Tripura":
        optionsList = Tripura;
        break;
      case "Uttaranchal":
        optionsList = Uttaranchal;
        break;
      case "Uttar Pradesh":
        optionsList = UttarPradesh;
        break;
      case "West Bengal":
        optionsList = WestBengal;
        break;
      case "Andaman and Nicobar Islands":
        optionsList = AndamanNicobar;
        break;
      case "Chandigarh":
        optionsList = Chandigarh;
        break;
      case "Dadar and Nagar Haveli":
        optionsList = DadraHaveli;
        break;
      case "Daman and Diu":
        optionsList = DamanDiu;
        break;
      case "Delhi":
        optionsList = Delhi;
        break;
      case "Lakshadeep":
        optionsList = Lakshadeep;
        break;
      case "Pondicherry":
        optionsList = Pondicherry;
        break;
    }


    for (var i = 0; i < optionsList.length; i++) {
      htmlString = htmlString + "<option value='" + optionsList[i] + "'>" + optionsList[i] + "</option>";
    }
    $("#city").html(htmlString);
  });
  $("#astate").change(function () {
    var StateSelected = $(this).val();
    var optionsList;
    var htmlString = "";

    switch (StateSelected) {
      case "Andra Pradesh":
        optionsList = AndraPradesh;
        break;
      case "Arunachal Pradesh":
        optionsList = ArunachalPradesh;
        break;
      case "Assam":
        optionsList = Assam;
        break;
      case "Bihar":
        optionsList = Bihar;
        break;
      case "Chhattisgarh":
        optionsList = Chhattisgarh;
        break;
      case "Goa":
        optionsList = Goa;
        break;
      case "Gujarat":
        optionsList = Gujarat;
        break;
      case "Haryana":
        optionsList = Haryana;
        break;
      case "Himachal Pradesh":
        optionsList = HimachalPradesh;
        break;
      case "Jammu and Kashmir":
        optionsList = JammuKashmir;
        break;
      case "Jharkhand":
        optionsList = Jharkhand;
        break;
      case "Karnataka":
        optionsList = Karnataka;
        break;
      case "Kerala":
        optionsList = Kerala;
        break;
      case "Madya Pradesh":
        optionsList = MadhyaPradesh;
        break;
      case "Maharashtra":
        optionsList = Maharashtra;
        break;
      case "Manipur":
        optionsList = Manipur;
        break;
      case "Meghalaya":
        optionsList = Meghalaya;
        break;
      case "Mizoram":
        optionsList = Mizoram;
        break;
      case "Nagaland":
        optionsList = Nagaland;
        break;
      case "Orissa":
        optionsList = Orissa;
        break;
      case "Punjab":
        optionsList = Punjab;
        break;
      case "Rajasthan":
        optionsList = Rajasthan;
        break;
      case "Sikkim":
        optionsList = Sikkim;
        break;
      case "Tamil Nadu":
        optionsList = TamilNadu;
        break;
      case "Telangana":
        optionsList = Telangana;
        break;
      case "Tripura":
        optionsList = Tripura;
        break;
      case "Uttaranchal":
        optionsList = Uttaranchal;
        break;
      case "Uttar Pradesh":
        optionsList = UttarPradesh;
        break;
      case "West Bengal":
        optionsList = WestBengal;
        break;
      case "Andaman and Nicobar Islands":
        optionsList = AndamanNicobar;
        break;
      case "Chandigarh":
        optionsList = Chandigarh;
        break;
      case "Dadar and Nagar Haveli":
        optionsList = DadraHaveli;
        break;
      case "Daman and Diu":
        optionsList = DamanDiu;
        break;
      case "Delhi":
        optionsList = Delhi;
        break;
      case "Lakshadeep":
        optionsList = Lakshadeep;
        break;
      case "Pondicherry":
        optionsList = Pondicherry;
        break;
    }


    for (var i = 0; i < optionsList.length; i++) {
      htmlString = htmlString + "<option value='" + optionsList[i] + "'>" + optionsList[i] + "</option>";
    }
    $("#acity").html(htmlString);
  });
</script>
<script src="validation.js"></script>

<?php

include("admin_footer.php");
?>