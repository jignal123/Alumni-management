<?php
require "student_header.php";
if (isset($_GET["event"])) {
    $qu = "UPDATE 
            event_master 
          SET 
            reg_status = 'closed' 
          WHERE 
            DATE(end_date) <= CURDATE()";
    $res = query($qu);
    $res->closeCursor();
    //echo $_GET["event"];
    $q = "SELECT *FROM event_master WHERE event_id= ?";
    $arr = array($_GET["event"]);
    $res = query($q, $arr);
    $event = $res->fetch();
    ?>
    <style>
        .alumni-event-view {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

        td {
            padding-right: 10px;
        }

        .register-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .register-btn:hover {
            background-color: #3e8e41;
            transform: translateY(-5px);
        }

        .register-btn:focus {
            outline: unset;
        }
    </style>
    <div class="alumni-event-view">
        <div class="event-image">
            <img src="../admin/<?= $event["event_image"] ?>" alt="Event Image">
        </div>
        <div class="event-details">
            <h2><?= $event["event_title"] ?></h2>
            <p class="event-date"><i class="fas fa-clock pe-2 text-secondary"></i>
                <?php if (date("d-m-Y", strtotime($event["start_date"])) == date("d-m-Y", strtotime($event["end_date"]))) {
                    echo date("l, F j , Y | h:i A ", strtotime($event["start_date"])) . date("- h:i A", strtotime($event["end_date"]));
                } else {
                    echo "Starts: " . date("l, F j ,Y | h:i A", strtotime($event["start_date"])) . "<br><span style='padding-left:27px;'>Ends: " . date("l, F j ,Y | h:i A", strtotime($event["end_date"]));
                } ?>
            </p>
            <p class="event-location"><i class="fas fa-map-marker-alt"></i><?= $event["location"] ?></p>
            <hr>
            <p class="event-description">
                <?= $event["description"] ?>
            </p>
            <?php
            if ($event["reg_status"] == "open") {
                $q = "SELECT 
                        COUNT(*) AS total
                     FROM 
                        event_registration er
                     JOIN event_day ed ON 
                        ed.day_id = er.day_id
                     WHERE 
                        ed.event_id = ? AND er.user_id = ?";
                $arr = [$_GET["event"], $_SESSION["student_id"]];
                $res = query($q, $arr);
                $count = $res->fetch();
                if ($count["total"] > 0) {
                    echo "<button class='me-3' id='viewreg' event-id=" . $_GET["event"] . "><i class='bi bi-calendar2-check pe-2'></i> Registered</button>
                          <input type='button' class='btn btn-danger delete-reg' id=" . $_GET["event"] . " value='Cancel Registration' > ";
                } else {
                    echo "<button class='register-btn'" . ($_SESSION["status"] == "un" ? 'data-swal-toast-template="#xyz"' : " id='" . $_GET["event"] . "' ") . ">Register Now</button>";
                }
            } else {
                echo "<button class='btn btn-dark' disabled>Registration Closed</button>";
            } ?>
        </div>
    </div>
    <div class="html">

    </div>
    <script>
        $(document).ready(function () {
            Swal.bindClickHandler();
            const Toast = Swal.mixin({
                toast: true,
                icon: "error",
                title: "You Are Not Verified to Register",
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            }).bindClickHandler("data-swal-toast-template");

            $(".register-btn").on("click", function () {
                if ($(this).attr("id")) {
                    $.ajax({
                        type: "post",
                        url: "user_backend.php",
                        data: { event: $(this).attr("id") },
                        dataType: "json",
                        success: function (data) {
                            $(".html").html(data.html);
                        }
                    });
                }
            });

            $(document).on("click", "#reg", function () {
                var days = document.getElementsByName("days[]");
                flag =false;
                for (var check of days){
                    if(check.checked){
                        flag=true;
                        //alert("inner"+flag);
                        break;
                    }
                }
                //alert("outer"+flag);
                if (flag!=true) {
                    Swal.fire({
                        title: "Please Select Days",
                        icon: "error"
                    });
                } else {
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
                            $("#eventreg").modal("hide");
                            $(".loader").show();
                            var form = document.getElementById("eventdays");
                            var formdata = new FormData(form);
                            $.ajax({
                                type: "post",
                                url: "user_backend.php",
                                data: formdata,
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    $(".loader").hide();
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
                                        }).then((result) => {
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
                    })
                }
            });

            $(document).on("click", ".delete-reg", function () {
                Swal.fire({
                    title: 'Are you sure to Cancel Registration?',
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
                        $(".loader").show();
                        var del_reg = $(this).attr("id");
                        $.ajax({
                            type: "post",
                            url: "user_backend.php",
                            data: { del_reg: del_reg },
                            success: function (data) {
                                $(".loader").hide();
                                if (data == 'del') {
                                    Swal.fire({
                                        title: 'Canceled!',
                                        text: 'Registration Canceled Successfully',
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
                                    }).then((result) => {
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
            });

            $(document).on("click", "#viewreg", function () {
                var e_id = $(this).attr("event-id");
                $(".loader").show();
                $.ajax({
                    type: "post",
                    url: "user_backend.php",
                    data: { e_id: e_id },
                    dataType: "json",
                    success: function (data) {
                        $(".loader").hide();
                        $(".html").html(data.html);
                    }
                });
            });
        }); 
    </script>
    <?php
}
?>

<?php
require "student_footer.php";
?>