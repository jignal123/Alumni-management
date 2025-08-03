<?php require "admin_header.php" ?>
<div class="card">
    <div class="card-header text-center" style="background-color:purple">
        <h1 class="text-white">Add Course</h1>
    </div>
    <div class="card-body">
        <div class="container col-md-8 mt-3">
            <form action="" method="post" class="row shadow bg-light rounded p-4" id="coursefrm">
                <div class="col-md-6">
                    <label for="course" class="form-label">Course Name</label>
                    <div class="input-field">
                        <input type="text" name="course" id="course" class="form-control">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="duration" class="form-label">Duration(in Year)</label>
                    <div class="input-field">
                        <input type="number" name="duration" id="duration" class="form-control" max="5">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="from" class="form-label">Applicable From(Year)</label>
                    <div class="input-field">
                        <input type="number" name="from" id="from" class="form-control" size="4" min="1970">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="to" class="form-label">Applicable To(Year)</label>
                    <div class="input-field">
                        <input type="number" name="to" id="to" class="form-control" size="4"
                            placeholder="Leave it blank if it has no fix year">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <input type="submit" value="Add" id="add" class="fs-6 activel">
                </div>
            </form>
        </div>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover mt-5 align-middle shadow-lg"
                    id="course_data" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th>Course Id</th>
                            <th>Course Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var datatable = $("#course_data").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "course_fetch.php",
                method: "POST"
            },
            columnDefs: [{
                "target": [0, 2, 3],
                "orderable": false
            }],
            layout: {
                top1start: {
                    buttons: ['colvis']
                }
            }
        });
    });

    $(document).on("click", ".update", function () {
        var c_id = $(this).attr("id");
        $.ajax({
            type: "post",
            url: "admin_backend.php",
            data: { c_id: c_id },
            dataType: "json",
            success: function (response) {
                $("#c_edit").modal("show");
                $("#ecourse").val(response.name);
                $("#hidden_id").val(c_id);
            }
        });
    });
    $(document).on("click", ".delete", function () {
        Swal.fire({
            title: "Are you sure to Delete Course?",
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
                var cd_id = $(this).attr("id");
                $.ajax({
                    type: "POST",
                    url: "admin_backend.php",
                    data: { cd_id: cd_id },
                    dataType: "json",
                    success: function (data) {
                        $("#course_data").DataTable().ajax.reload();
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
    $(document).ready(function () {
        var cnm = document.getElementById("course");
        var dur = document.getElementById("duration");
        var from = document.getElementById("from");
        var to = document.getElementById("to");
        $("#add").on("click", function (e) {
            var cform = document.getElementById("coursefrm");
            e.preventDefault();
            checkcourse();
            checkduration();
            checkfrom();
            checkto();
            cnm.addEventListener("keyup", checkcourse);
            dur.addEventListener("keyup", checkduration);
            from.addEventListener("keyup", checkfrom);
            to.addEventListener("keyup", checkto);
            if (submitf(cform) == true) {
                // alert(submitf(aform));
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure to Save Changes?",
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
                        var formdata = new FormData(cform);
                        $.ajax({
                            type: "POST",
                            url: "admin_backend.php",
                            data: formdata,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                $('.loader').hide();
                                //alert(data);
                                $("#coursefrm")[0].reset();
                                $("#course_data").DataTable().ajax.reload();
                                if (data == 'add') {
                                    // $('.loader').hide();
                                    Swal.fire({
                                        title: "Added!",
                                        text: "Course Added Successfully",
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
                                    })//.then((result) => {
                                    //     if (result.isConfirmed) {
                                    //         window.location.assign("manage_alumni.php");
                                    //     }
                                    // });

                                } else {
                                    // $('.loader').hide();
                                    Swal.fire({
                                        title: "Error!",
                                        text: data,
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
                                    })//.then((result) => {
                                    //     if (result.isConfirmed) {
                                    //         window.location.assign("add_course.php");
                                    //     }
                                    // });
                                }
                            }
                        });
                    }
                });
            }
            else {
                e.preventDefault();
            }
        });
        function checkcourse() {
            cv = cnm.value;
            $.ajax({
                type: "post",
                url: "admin_backend.php",
                data: { cval: cv },
                success: function (response) {
                    if (cv == "") {
                        seterror(cnm, "It Should Not Be Blank");
                    }
                    else if (response > 0) {
                        seterror(cnm, "Course Already Exist");
                    } else {
                        setsuccess(cnm);
                    }
                }
            });
        }

        function checkduration() {
            dv = dur.value;
            if (dv == "") {
                seterror(dur, "It Should Not Be Blank")
            } else if (dv > 9) {
                seterror(dur, "Duration Should Not exceed 9 Years");
            }
            else {
                setsuccess(dur);
            }
        }

        function checkfrom() {
            fv = from.value;
            if (fv == "") {
                seterror(from, "It Should Not Be Blank");
            } else if (fv < 1970) {
                seterror(from, "Year Should Be Greater Than 1969");
            }
            else {
                setsuccess(from);
            }
        }

        function checkto() {
            tv = to.value;
            if (tv != "" && tv <= from.value) {
                seterror(to, "It Should Be Less Than From Year");
            } else {
                setsuccess(to);
            }
        }
    });
</script>
<!-- edit -->
<div class="modal fade" id="c_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="edit_form">
                    <div class="col-md-12">
                        <label for="ecourse" class="form-label">Course Name</label>
                        <div class="input-field">
                            <input type="text" name="ecourse" id="ecourse" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="hidden_id" id="hidden_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="activel rounded fs-6" id="e_course">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#e_course").click(function () {
        var ecform = document.getElementById("edit_form");
        checkecourse();
        edit.addEventListener("keyup", checkecourse);
        if (submitf(ecform) == true) {
            $.ajax({
                type: "post",
                url: "admin_backend.php",
                data: { hc_id: h_id.value, cnm: edit.value },
                success: function (response) {
                    $("#edit_form")[0].reset();
                    $("#c_edit").modal("hide");
                    $("#course_data").DataTable().ajax.reload();
                    if (response == "edit") {
                        Swal.fire({
                            title: "Edited!",
                            text: "Course Name Edited Successfully",
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
                        Swal.fire({
                            title: "Error!",
                            text: "Some Error Occurred In Editing",
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
    var edit = document.getElementById("ecourse");
    var h_id = document.getElementById("hidden_id");
    function checkecourse() {
        cv = edit.value;
        $.ajax({
            type: "post",
            url: "admin_backend.php",
            data: { ecval: cv, h_id: h_id.value },
            success: function (response) {
                if (cv == "") {
                    seterror(edit, "It Should Not Be Blank");
                }
                else if (response > 0) {
                    seterror(edit, "Course Already Exist");
                } else {
                    setsuccess(edit);
                }
            }
        });
    }
</script>
<?php require "admin_footer.php"; ?>