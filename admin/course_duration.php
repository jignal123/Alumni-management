<?php
require "admin_header.php";
?>
<div class="card">
    <div class="card-header text-center" style="background-color:purple;">
        <h1 class="text-white">Add Course Duration</h1>
    </div>
    <div class="card-body">
        <div class="container col-md-8 mt-3">
            <form action="" method="post" class="row shadow rounded p-4 bg-light" id="durationfrm">
                <div class="col-md-6">
                    <label for="dcourse" class="form-label">Course Name</label>
                    <div class="input-field">
                        <select name="dcourse" id="dcourse" class="form-select">
                            <option value="" selected disabled>Select-Course</option>
                            <?php
                            $qu = "SELECT *FROM course_master";
                            $r = query($qu);
                            $res = $r->fetchAll();
                            foreach ($res as $row) {
                                echo "<option value='" . $row['course_id'] . "'>" . $row['course_nm'] . "</option>";
                            }
                            ?>
                        </select>
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="dduration" class="form-label">New Duration(in Year)</label>
                    <div class="input-field">
                        <input type="number" name="dduration" id="dduration" class="form-control" min="1" max="5">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="dfrom" class="form-label">Applicable From(Year)</label>
                    <div class="input-field">
                        <input type="number" name="dfrom" id="dfrom" class="form-control" size="4" min="1970">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="dto" class="form-label">Applicable To(Year)</label>
                    <div class="input-field">
                        <input type="number" name="dto" id="dto" class="form-control" size="4"
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
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mt-5 align-middle shadow-lg" id="duration_data"
                width="100%">
                <thead class="table-danger">
                    <tr>
                        <th>Duration Id</th>
                        <th>Course Name</th>
                        <th>Duration</th>
                        <th>Applicable From</th>
                        <th>Applicable Till</th>
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
        var datatable = $("#duration_data").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "duration_fetch.php",
                method: "POST"
            },
            columnDefs: [{
                "target": [0, 5, 6],
                "orderable": false
            }],
            layout: {
                top1start: {
                    buttons: ['colvis']
                }
            }
        });
        var cnm = document.getElementById("dcourse");
        var dur = document.getElementById("dduration");
        var from = document.getElementById("dfrom");
        var to = document.getElementById("dto");
        from.addEventListener("keyup", checkfrom);
        $("#add").on("click", function (e) {
            var dform = document.getElementById("durationfrm");
            e.preventDefault();
            checkfrom();
            checkcourse();
            checkduration();
            checkto();
            cnm.addEventListener("change", checkcourse);
            dur.addEventListener("keyup", checkduration);
            to.addEventListener("keyup", checkto);
            if (submitf(dform) == true) {
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
                        var formdata = new FormData(dform);
                        $.ajax({
                            type: "POST",
                            url: "admin_backend.php",
                            data: formdata,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                $('.loader').hide();
                                //alert(data);
                                $("#durationfrm")[0].reset();
                                $("#duration_data").DataTable().ajax.reload();
                                if (data == 'add') {
                                    // $('.loader').hide();
                                    Swal.fire({
                                        title: "Added!",
                                        text: "Duration Added Successfully",
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
                                    })
                                } else {
                                    // $('.loader').hide();
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Some Error Occurred In Adding Duration",
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
                                    })
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
            if (cv == "") {
                seterror(cnm, "It Should Not Be Blank");
            }
            else {
                setsuccess(cnm);
            }
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
            $.ajax({
                type: "post",
                url: "admin_backend.php",
                data: { ed_cdid: cnm.value, ed_from: fv },
                success: function (response) {
                    if (fv == "") {
                        seterror(from, "It Should Not Be Blank");
                    }
                    else if (response > 0) {
                        seterror(from, "It Should Be Grater Than Old Course's End Year");
                    }
                    else {
                        setsuccess(from);
                    }
                }
            });
        }

        function checkto() {
            tv = to.value;
            if (tv != "" && tv <= from.value) {
                seterror(to, "It Should Be Less Than From Year");
            } else {
                setsuccess(to);
            }
        }

        $(document).on("click", ".update", function () {
            var ed_id = $(this).attr("id");
            $.ajax({
                type: "post",
                url: "admin_backend.php",
                data: { du_id: ed_id },
                dataType: "json",
                success: function (data) {
                    $("#editmodal").modal("show");
                    $("#course").val(data.course);
                    $("#edduration").val(data.dur);
                    $("#edfrom").val(data.from);
                    $("#edto").val(data.to);
                    $("#hidden_id").val(ed_id);
                }
            });
        });
    });
</script>
<!--Edit Modal -->
<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Duration</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="row p-1" id="edurationfrm">
                    <div class="col-md-12">
                        <label for="edduration" class="form-label">New Duration(in Year)</label>
                        <div class="input-field">
                            <input type="number" name="edduration" id="edduration" class="form-control" min="1" max="5">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="edfrom" class="form-label">Applicable From(Year)</label>
                        <div class="input-field">
                            <input type="number" name="edfrom" id="edfrom" class="form-control" size="4" min="1970">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="edto" class="form-label">Applicable To(Year)</label>
                        <div class="input-field">
                            <input type="number" name="edto" id="edto" class="form-control" size="4"
                                placeholder="Leave it blank if it has no fix year">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <input type="hidden" name="course" id="course">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="activel fs-6 rounded" id="edit">Edit</button>
            </div>
        </div>
    </div>
</div>
<script>
    var edur = document.getElementById("edduration");
    var efrom = document.getElementById("edfrom");
    var eto = document.getElementById("edto");
    $("#edit").on("click", function (e) {
        var edform = document.getElementById("edurationfrm");
        e.preventDefault();
        checkefrom();
        checkeduration();
        checketo();
        edur.addEventListener("keyup", checkeduration);
        efrom.addEventListener("keyup", checkefrom);
        eto.addEventListener("keyup", checketo);
        if (submitf(edform) == true) {
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
                    var formdata = new FormData(edform);
                    $.ajax({
                        type: "POST",
                        url: "admin_backend.php",
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            $('.loader').hide();
                            $("#editmodal").modal("hide");
                            //alert(data);
                            $("#edurationfrm")[0].reset();
                            $("#duration_data").DataTable().ajax.reload();
                            if (data == 'edit') {
                                // $('.loader').hide();
                                Swal.fire({
                                    title: "Edited!",
                                    text: "Duration Edited Successfully",
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
                                })
                            } else {
                                // $('.loader').hide();
                                Swal.fire({
                                    title: "Error!",
                                    text: "Some Error Occurred In Editing Duration",
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
                                })
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
    function checkeduration() {
        dv = edur.value;
        if (dv == "") {
            seterror(edur, "It Should Not Be Blank")
        } else if (dv > 5) {
            seterror(edur, "Duration Should Not exceed 5 Years");
        }
        else {
            setsuccess(edur);
        }
    }

    function checkefrom() {
        fv = efrom.value;
        $.ajax({
            type: "post",
            url: "admin_backend.php",
            data: { edd_cid: $("#course").val(), edd_from: fv, edu_id: $("#hidden_id").val() },
            success: function (response) {
                if (fv == "") {
                    seterror(efrom, "It Should Not Be Blank");
                } else if (response > 0) {
                    seterror(efrom, "It Should Be Grater Than Old Course's End Year");
                }
                else {
                    setsuccess(efrom);
                }
            }
        });
    }

    function checketo() {
        tv = eto.value;
        if (tv != "" && tv <= efrom.value) {
            seterror(eto, "It Should Be Less Than From Year");
        } else {
            setsuccess(eto);
        }
    }
    $(document).on("click", ".delete", function () {
        Swal.fire({
            title: "Are you sure to Delete Course Duration?",
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
                $.ajax({
                    type: "POST",
                    url: "admin_backend.php",
                    data: { delete_duration: $(this).attr("id")},
                    dataType: "json",
                    success: function (data) {
                        $('.loader').hide();
                        //alert(data);
                        $("#duration_data").DataTable().ajax.reload();
                        // $('.loader').hide();
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
<?php require "admin_footer.php"; ?>