<?php
require "student_header.php";
?>
<div class="container-md" data-aos="fade-down" data-aos-duration="900">
    <ul class="nav nav-underline mb-3 d-flex justify-content-center pt-5 fs-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane"
                type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past-tab-pane" type="button"
                role="tab" aria-controls="past-tab-pane" aria-selected="false">Past</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming-tab-pane"
                type="button" role="tab" aria-controls="upcoming-tab-pane" aria-selected="false">Upcoming</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="me-tab" data-bs-toggle="tab" data-bs-target="#me-tab-pane" type="button"
                role="tab" aria-controls="me-tab-pane" aria-selected="false">Registered By Me</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="home-tab"
            tabindex="0">
            <div class="col-md-12 d-flex justify-content-between" data-aos="fade-down" data-aos-duration="1000">
                <div class="">
                    <select name="" id="allorder" class="form-select">
                        <option value="DESC">Newest</option>
                        <option value="ASC">Oldest</option>
                    </select>
                </div>
                <div class="search-box">
                    <input type="text" id="allsearch" placeholder="Search event by title or location...">
                    <i class="fa fa-search"></i>
                </div>
            </div>
            <div class="event">

            </div>
        </div>
        <div class="tab-pane fade" id="past-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <div class="col-md-12 d-flex justify-content-between" data-aos="fade-down" data-aos-duration="1000">
                <div class="">
                    <select name="" id="pastorder" class="form-select">
                        <option value="DESC">Newest</option>
                        <option value="ASC">Oldest</option>
                    </select>
                </div>
                <div class="search-box">
                    <input type="text" id="pastsearch" placeholder="Search event by title or location...">
                    <i class="fa fa-search"></i>
                </div>
            </div>
            <div class="event">

            </div>
        </div>
        <div class="tab-pane fade" id="upcoming-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
            <div class="col-md-12 d-flex justify-content-between" data-aos="fade-down" data-aos-duration="1000">
                <div class="">
                    <select name="" id="upcomingorder" class="form-select">
                        <option value="DESC">Newest</option>
                        <option value="ASC">Oldest</option>
                    </select>
                </div>
                <div class="search-box">
                    <input type="text" id="upcomingsearch" placeholder="Search event by title or location...">
                    <i class="fa fa-search"></i>
                </div>
            </div>
            <div class="event">

            </div>
        </div>
        <div class="tab-pane fade" id="me-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
            <div class="col-md-12 d-flex justify-content-between" data-aos="fade-down" data-aos-duration="1000">
                <div class="">
                    <select name="" id="meorder" class="form-select">
                        <option value="DESC">Newest</option>
                        <option value="ASC">Oldest</option>
                    </select>
                </div>
                <div class="search-box">
                    <input type="text" id="mesearch" placeholder="Search event by title or location...">
                    <i class="fa fa-search"></i>
                </div>
            </div>
            <div class="event">

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        getallevents();
        getpastevents();
        getupcomingevents();
        getmeevents();
        allsearch.addEventListener("keyup", getallevents);
        allorder.addEventListener("change", getallevents);
        pastsearch.addEventListener("keyup", getpastevents);
        pastorder.addEventListener("change", getpastevents);
        upcomingsearch.addEventListener("keyup", getupcomingevents);
        upcomingorder.addEventListener("change", getupcomingevents);
        mesearch.addEventListener("keyup",getmeevents);
        meorder.addEventListener("change",getmeevents);
    });
    var allsearch = document.getElementById("allsearch");
    var pastsearch = document.getElementById("pastsearch");
    var upcomingsearch = document.getElementById("upcomingsearch");
    var mesearch = document.getElementById("mesearch");
    var allorder = document.getElementById("allorder");
    var pastorder = document.getElementById("pastorder");
    var upcomingorder = document.getElementById("upcomingorder");
    var meorder = document.getElementById("meorder");
    function getallevents() {
        var search = allsearch.value;
        var order = allorder.value;
        $.ajax({
            type: "post",
            url: "getallevents.php",
            data: { search: search, order: order },
            dataType: "json",
            success: function (response) {
                $("#all-tab-pane .event").html(response.html);
            }
        });
    }

    function getpastevents() {
        var search = pastsearch.value;
        var order = pastorder.value;
        $.ajax({
            type: "post",
            url: "getpastevents.php",
            data: { search: search, order: order },
            dataType: "json",
            success: function (response) {
                $("#past-tab-pane .event").html(response.html);
            }
        });
    }

    function getupcomingevents() {
        var search = upcomingsearch.value;
        var order = upcomingorder.value;
        $.ajax({
            type: "post",
            url: "getupcomingevents.php",
            data: { search: search, order: order },
            dataType: "json",
            success: function (response) {
                $("#upcoming-tab-pane .event").html(response.html);
            }
        });
    }

    function getmeevents() {
        var search = mesearch.value;
        var order = meorder.value;
        $.ajax({
            type: "post",
            url: "getmeevents.php",
            data: { search: search, order: order },
            dataType: "json",
            success: function (response) {
                $("#me-tab-pane .event").html(response.html);
            }
        });
    }
</script>
<?php
require "student_footer.php";
?>