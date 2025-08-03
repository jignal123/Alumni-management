<?php
include("admin_header.php");
$qu = "UPDATE event_master SET reg_status = 'closed' WHERE DATE(end_date) <= CURDATE()";
$res = query($qu);
$res->closeCursor();
?>
<!-- <div class="container shadow-lg rounded mt-2">
    <h2 class="text-center shadow p-2 bg-primary text-white rounded"> Add Event</h2>
</div> -->
<div class="card">
    <div class="card-header text-center" style="background-color: purple;">
        <h1 class="text-white">Manage Events</h1>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <button type="button" class="activel fs-6 rounded" data-bs-toggle="modal" data-bs-target="#eventmodal">
                <i class="fa-solid fa-calendar-days pe-2"></i>Add Event
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover mt-5 align-middle shadow-lg" id="event_data"
                width="100%">
                <thead class="table-dark">
                    <tr>
                        <th>Event_id</th>
                        <th>Image</th>
                        <th>Event Title</th>
                        <th>Location</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Registration Status</th>
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
        var datatable = $("#event_data").DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: "eventFetch.php",
                method: "POST"
            },
            columnDefs: [{
                "target": [0, 1, 7, 8],
                "orderable": false
            }],
            layout: {
                top1start: {
                    buttons: ['colvis']
                }
            }
        });
    });
    $(document).on("click", ".delete", function () {
        Swal.fire({
            title: "Are you sure to Delete Event?",
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
                var ed_id = $(this).attr("id");
                $.ajax({
                    type: "POST",
                    url: "admin_backend.php",
                    data: { ed_id: ed_id },
                    dataType: "json",
                    success: function (data) {
                        //$('.loader').hide();
                        //alert(data);
                        $("#event_data").DataTable().ajax.reload();
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
<!-- Modal -->
<div class="modal fade" id="eventmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Event</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="row" method="post" id="myform" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <label for="title" class="form-label">Event-Title</label>
                        <div class="input-field">
                            <input type="text" name="title" id="title" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="start" class="form-label">Start Date</label>
                        <div class="input-field">
                            <input type="datetime-local" name="start" id="start" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="end" class="form-label">End Date</label>
                        <div class="input-field">
                            <input type="datetime-local" name="end" id="end" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="loc" class="form-label">Location</label>
                        <div class="input-field">
                            <input type="text" name="loc" id="loc" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Registration status</label>
                        <div class="input-field">
                            <select name="status" id="status" class="form-select">
                                <option value="closed" selected>closed</option>
                                <option value="open">open</option>
                            </select>
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="eimg" class="form-label">Event Image</label>
                        <div class="input-field">
                            <input type="file" name="eimg" id="eimg" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <span class="form-label">Event Description</span>
                        <textarea name="description" id="description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="add" class="activel rounded fs-6">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editmodal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Event</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" class="row" method="post" id="editform" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <label for="title" class="form-label">Event-Title</label>
                        <div class="input-field">
                            <input type="text" name="etitle" id="etitle" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="start" class="form-label">Start Date</label>
                        <div class="input-field">
                            <input type="datetime-local" name="estart" id="estart" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="end" class="form-label">End Date</label>
                        <div class="input-field">
                            <input type="datetime-local" name="eend" id="eend" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="loc" class="form-label">Location</label>
                        <div class="input-field">
                            <input type="text" name="eloc" id="eloc" class="form-control">
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Registration status</label>
                        <div class="input-field">
                            <select name="estatus" id="estatus" class="form-select">
                                <option value="closed" selected>closed</option>
                                <option value="open">open</option>
                            </select>
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="eimg" class="form-label">Event Image</label>
                        <div class="input-field">
                            <input type="file" name="eeimg" id="eeimg" class="form-control">
                            <input type='hidden' name='hidden_img' id='hidden_img'>
                            <i class="fa" aria-hidden="true"></i>
                            <span class="d-flex">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <span id="upload-image"></span>
                    </div>
                    <div class="col-12">
                        <span class="form-label">Event Description</span>
                        <textarea name="edescription" id="edescription"></textarea>
                    </div>
                    <input type="hidden" name="ev_id" id="ev_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="edit" class="activel rounded fs-6">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
            }
        }
    </script>
<script type="module" src="./main.js"></script>
<script>
    const form = document.getElementById("myform");
    var title = document.getElementById("title"),
        start = document.getElementById("start"),
        end = document.getElementById("end"),
        loc = document.getElementById("loc"),
        image = document.getElementById("eimg");
    function checktitle() {
        var tvl = title.value;
        if (tvl == "") {
            seterror(title, "It Should not Empty");
        } else {
            setsuccess(title);
        }
    }
    function checkstart() {
        var svl = start.value;
        if (svl == "") {
            seterror(start, "It Should not Empty");
        } else {
            setsuccess(start);
        }
    }
    function checkend() {
        var evl = end.value;
        if (evl < start.value) {
            seterror(end, "It Must be greater than start date");
        } else {
            setsuccess(end);
        }
    }
    function checklocation() {
        var lvl = loc.value;
        if (lvl == "") {
            seterror(loc, "It Should not Empty");
        } else {
            setsuccess(loc);
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
</script>
<script>

    const eform = document.getElementById("editform");
    var etitle = document.getElementById("etitle"),
        estart = document.getElementById("estart"),
        eend = document.getElementById("eend"),
        eloc = document.getElementById("eloc"),
        eimage = document.getElementById("eeimg");
    function checketitle() {
        var tvl = etitle.value;
        if (tvl == "") {
            seterror(etitle, "It Should not Empty");
        } else {
            setsuccess(etitle);
        }
    }
    function checkestart() {
        var svl = estart.value;
        if (svl == "") {
            seterror(estart, "It Should not Empty");
        } else {
            setsuccess(estart);
        }
    }
    function checkeend() {
        var evl = eend.value;
        if (evl < start.value) {
            seterror(eend, "It Must be greater than start date");
        } else {
            setsuccess(eend);
        }
    }
    function checkelocation() {
        var lvl = eloc.value;
        if (lvl == "") {
            seterror(eloc, "It Should not Empty");
        } else {
            setsuccess(eloc);
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
include("admin_footer.php");
?>