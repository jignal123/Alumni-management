<?php
require "admin_header.php";
?>
<div class="card">
    <div class="card-header text-white" style="background-color: purple;">
        <h1 class="text-center">Add Event Pictures <i class="fa-solid fa-photo-film"></i>
        </h1>
    </div>
    <div class="card-body">
        <div class="container col-md-8 bg-white p-4 rounded mt-4 shadow-lg">
            <form action="" method="post" class="row" id="eventgallary" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="event" class="form-label">Event Name</label>
                    <div class="input-field">
                        <select name="event" id="event" class="form-select">
                            <option value="" selected disabled>Select-Event</option>
                            <?php
                            $qu = "SELECT *FROM event_master";
                            $r = query($qu);
                            $res = $r->fetchAll();
                            foreach ($res as $row) {
                                echo "<option value='" . $row['event_id'] . "'>" . $row['event_title'] . " " . date('F j, Y, g:i a', strtotime($row['start_date'])) . "</option>";
                            }
                            ?>
                        </select>
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="ev_gal" class="form-label">Event Photo</label>
                    <div class="input-field">
                        <input type="file" name="ev_gal" id="ev_gal" accept="image/*" class="form-control">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <input type="submit" value="Add" class="activel rounded fs-6" id="add">
                </div>
            </form>
        </div>
        <div class="table-responsive mt-2">
            <table class="table table-striped table-bordered table-hover mt-5 align-middle shadow-lg" id="event_gallary"
                width="100%">
                <thead class="table-dark">
                    <tr>
                        <th>Gallary Id</th>
                        <th>Image</th>
                        <th>Event Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var datatable = $("#event_gallary").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "gallary_fetch.php",
                method: "POST"
            },
            columnDefs: [{
                "target": [0, 1, 3, 4],
                "orderable": false
            }],
            layout: {
                top1start: {
                    buttons: ['colvis']
                }
            }
        });
        $(document).on("click", ".update", function () {
            var egal_id = $(this).attr("id");
            $.ajax({
                type: "post",
                url: "admin_backend.php",
                data: { egal_id: egal_id },
                dataType: "json",
                success: function (data) {
                    $("#editmodal").modal("show");
                    $("#eevent").val(data.event);
                    $("#img").html(data.img);
                    $("#hidden_img").val(data.himg);
                    $("#gal_id").val(egal_id);
                }
            });
        });
        $(document).on("click", ".delete", function () {
            Swal.fire({
                title: "Are you sure to Delete Photo?",
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
                    var dgal_id = $(this).attr("id");
                    $.ajax({
                        type: "POST",
                        url: "admin_backend.php",
                        data: { dgal_id: dgal_id },
                        dataType: "json",
                        success: function (data) {
                            datatable.ajax.reload();
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
        var event = document.getElementById("event");
        var image = document.getElementById("ev_gal");
        $("#add").on("click", function (e) {
            e.preventDefault();
            var egform = document.getElementById("eventgallary");
            checkevent();
            checkimage();
            event.addEventListener("change", checkevent);
            image.addEventListener("change", checkimage);
            if (submitf(egform) == true) {
                e.preventDefault();
                $(".loader").show();
                formdata = new FormData(egform);
                $.ajax({
                    type: "post",
                    url: "admin_backend.php",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $(".loader").hide();
                        datatable.ajax.reload();
                        $("#eventgallary")[0].reset();
                        if (response == "add") {
                            Swal.fire({
                                title: "Success",
                                text: "Photo Added Successfully!",
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
                            Swal.fire({
                                title: "Error",
                                text: "Some Error Occurr In Adding Event!",
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
        function checkevent() {
            var ev = event.value;
            if (ev == "") {
                seterror(event, "It Should Not Be Empty");
            }
            else {
                setsuccess(event);
            }
        }

        function checkimage() {
            var ph = image.value;
            var phv = /[^\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/;
            if (!phv.test(ph)) {
                seterror(image, "It should be in jpg,jpeg,png or gif Form");
            }
            else {
                var file = image.files[0].size;
                var kbsize = (file / 1024);
                //alert(kbsize);
                if (kbsize > 300) {
                    seterror(image, "File size should be less than 300KB");
                }
                else {
                    setsuccess(image);
                }
            }
        }
    });
</script>
<div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Gallary</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="row p-1" id="edit_gal" enctype="multipart/form-data">
                    <div class="col-md-6">
                        <label for="eevent" class="form-label">Event Name</label>
                        <div class="input-field">
                            <select name="eevent" id="eevent" class="form-select">
                                <option value="" selected disabled>Select-Event</option>
                                <?php
                                $qu = "SELECT *FROM event_master";
                                $r = query($qu);
                                $res = $r->fetchAll();
                                foreach ($res as $row) {
                                    echo "<option value='" . $row['event_id'] . "'>" . $row['event_title'] . " " . date('F j, Y, g:i a', strtotime($row['start_date'])) . "</option>";
                                }
                                ?>
                            </select>
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="egal_img" class="form-label">Choose Image</label>
                        <div class="input-field">
                            <input type="file" name="egal_img" id="egal_img" accept="image/*" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <span id="img"></span>
                    </div>
                    <input type="hidden" name="hidden_img" id="hidden_img">
                    <input type="hidden" name="gal_id" id="gal_id">
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
    var eevent = document.getElementById("eevent");
    var eimage = document.getElementById("egal_img");
    $("#edit").on("click", function (e) {
        e.preventDefault();
        var edform = document.getElementById("edit_gal");
        checkeevent();
        checkeimage();
        eevent.addEventListener("change", checkeevent);
        eimage.addEventListener("change", checkeimage);
        if (submitf(edform) == true) {
            e.preventDefault();
            $(".loader").show();
            formdata = new FormData(edform);
            $.ajax({
                type: "post",
                url: "admin_backend.php",
                data: formdata,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(".loader").hide();
                    $("#event_gallary").DataTable().ajax.reload();
                    $("#editmodal").modal("hide");
                    $("#edit_gal")[0].reset();
                    if (response == "edit") {
                        Swal.fire({
                            title: "Edited",
                            text: "Photo Edited Successfully!",
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
                        Swal.fire({
                            title: "Error",
                            text: "Some Error Occurr In Editing Event!",
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
    function checkeevent() {
        var ev = eevent.value;
        if (ev == "") {
            seterror(eevent, "It Should Not Be Empty");
        }
        else {
            setsuccess(eevent);
        }
    }

    function checkeimage() {
        var ph = eimage.value;
        var phv = /[^\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/;
        if (ph != "" && !phv.test(ph)) {
            seterror(eimage, "It should be in jpg,jpeg,png or gif Form");
        }
        else {
            var file = eimage.files[0].size;
            var kbsize = (file / 1024);
            //alert(kbsize);
            if (kbsize > 300) {
                seterror(eimage, "File size should be less than 300KB");
            }
            else {
                setsuccess(eimage);
            }
        }
    }
</script>
<?php
require "admin_footer.php";
?>