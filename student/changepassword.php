<?php
require "student_header.php";
?>
<div class="container">
    <div class="card mt-2">
        <div class="card-header text-center" style="background-color:purple;">
            <h1 class="text-white">Change Password</h1>
        </div>
        <div class="card-body">
            <form action="" method="post" id="changepsw" class="col-md-6 container">
                <div class="col-md-12">
                    <label for="old" class="form-label">Old Password</label>
                    <div class="input-field">
                        <input type="password" name="old" id="old" class="form-control">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="new" class="form-label">New Password</label>
                    <div class="input-field">
                        <input type="password" name="new" id="new" class="form-control">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="confirm" class="form-label">Confirm Password</label>
                    <div class="input-field">
                        <input type="password" name="confirm" id="confirm" class="form-control">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex"></span>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <input type="submit" value="Change" class="fs-6 rounded activel" id="change">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const changef = document.getElementById("changepsw");
    var old = document.getElementById("old");
    var newp = document.getElementById("new");
    var confirm = document.getElementById("confirm");
    old.addEventListener("keyup", checkold);
    newp.addEventListener("keyup", checknew);
    confirm.addEventListener("keyup", checkconf);
    $("#change").on("click", function (e) {
        e.preventDefault();
        checkold();
        checknew();
        checkconf();
        if (submitf(changef) == true) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure to Change Password?",
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
                    $('.loader').show();
                    var formdata = new FormData(changef);
                    $.ajax({
                        type: "POST",
                        url: "user_backend.php",
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('.loader').hide();
                            //alert(data);
                            $("#changepsw")[0].reset();
                            if (data == 'change') {
                                // $('.loader').hide();
                                Swal.fire({
                                    title: "Changed!",
                                    text: "Password Changed Successfully",
                                    icon: "success",
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
                            } else {
                                // $('.loader').hide();
                                Swal.fire({
                                    title: "Error!",
                                    text: "Some Error Occurred In Changing Password",
                                    icon: "error",
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
        }
    });
    function checkold() {
        var ov = old.value;
        var a = true;
        $.ajax({
            type: "post",
            url: "user_backend.php",
            data: { ov: ov },
            success: function (response) {
                if (ov == "") {
                    seterror(old, "It Should Not Be Blank");
                    a = false;
                }
                else if (response == 0) {
                    seterror(old, "Old Password Doesn't Match");
                    a = false;
                }
                else {
                    setsuccess(old);
                    a = true;
                }
            }
        });
        return a;
    }

    function checknew() {
        var nv = newp.value;
        if (nv == "") {
            seterror(newp, "It Should Not Be Blank");
        }
        else if (nv == old.value) {
            seterror(newp, "New Password Should Not Same As Old Password")
        }
        else {
            setsuccess(newp);
        }
    }

    function checkconf() {
        var cv = confirm.value;
        if (cv == "") {
            seterror(confirm, "It Should Not Be Blank");
        } else if (cv != newp.value) {
            seterror(confirm, "Confirm Password Doesn't Match");
        } else {
            setsuccess(confirm);
        }
    }
</script>
<?php
require "student_footer.php";
?>