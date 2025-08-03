<?php require "admin_header.php" ?>
<div class="container">
    <div class="card">
        <div class="card-header text-white p-1" style="background-color: purple;">
            <h1 class="text-center">Event Report</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form action="" id="ev_rp" class="row">
                        <div class="col-md-4">
                            <label for="start" class="form-label">From</label>
                            <div class="input-field">
                                <input type="date" name="start" id="start" class="form-control">
                                <i class="fa" aria-hidden="true"></i>
                                <span class="d-flex">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="end" class="form-label">To</label>
                            <div class="input-field">
                                <input type="date" name="end" id="end" class="form-control">
                                <i class="fa" aria-hidden="true"></i>
                                <span class="d-flex">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Events</label>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Select-Events
                                </button>
                                <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton">
                                    <?php
                                    $q = "SELECT event_id,event_title,start_date FROM event_master WHERE deleted = 0 ";
                                    $res = query($q);
                                    $r = $res->fetchAll();
                                    foreach ($r as $row) {
                                        ?>
                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="title[]"
                                                    value="<?php echo $row['event_id'] ?>">
                                                <label class="form-check-label">
                                                    <?php
                                                    echo $row['event_title'] . " " . date("dS-M-Y", strtotime($row['start_date']));
                                                    ?>
                                                </label>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <input type="submit" id="filter" class="activel fs-6 rounded" value="Display">
                        </div>
                        <div class="col-md-6 text-start">
                            <input type="reset" value="Reset" class="btn btn-secondary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-left p-2"><button class="btn btn-danger" id="print"><i
                    class="fa-solid fa-download"></i>
                Download PDF<i class="fa-solid fa-file-pdf ps-1"></i> Report</button>
        </div>
    </div>
</div>
<div class="col-md-12 pt-3" id="ev-data">

</div>
<script>
    $(document).ready(function () {
        $(document).on("click", "#filter", function (e) {
            var form = document.getElementById("ev_rp");
            e.preventDefault();
            checkend();
            end.addEventListener("keyup", checkend);
            if (submitf(form) == true) {
                e.preventDefault();
                var formdata = new FormData(form);
                $.ajax({
                    type: "post",
                    url: "event_report_data.php",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        //alert("Data");
                        $("#ev-data").html(response);
                    }
                });
            }
        });
        var end = document.getElementById("end");
        function checkend() {
            var ev = end.value;
            if (ev != "") {
                var start = $("#start").val();
                if (ev < start) {
                    seterror(end, "End Date Should not Greater Than Start Date!")
                } else {
                    setsuccess(end);
                }
            }
            else {
                setsuccess(end);
            }
        }
    });
    $('#print').click(function (e) {
        //e.preventDefault();
        $(".loader").show();
        var tableHTML = $("#ev-data").prop('innerHTML');
        $.ajax({
            type: "post",
            url: "event_pdf.php",
            data: { 
                evhtml: tableHTML,
                start: $("#start").val(),
                end: $("#end").val()
            },
            dataType: "json",
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
    $("#ev-data").on("change", function () {
        if ($(this).html() != "") {
            $("#print").css("dispaly", "block");
        } else {
            $("#print").css("dispaly", "none");
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<?php require "admin_footer.php" ?>