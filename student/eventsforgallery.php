<?php
require "student_header.php";
?>
<div class="col-md-12 d-flex justify-content-between p-5" data-aos="fade-down" data-aos-duration="1000">
    <div class="">
        <select name="" id="order" class="form-select">
            <option value="DESC">Newest</option>
            <option value="ASC">Oldest</option>
        </select>
    </div>
    <div class="search-box">
        <input type="text" id="search" placeholder="Search event gallery by title...">
        <i class="fa fa-search"></i>
    </div>
</div>
<div class="container">
    <div class="row text-center" id="events">

    </div>
</div>

<script>
    $(document).ready(function () {
        geteventsforgallery();
        search.addEventListener("keyup", geteventsforgallery);
        order.addEventListener("change", geteventsforgallery);
    });
    var search = document.getElementById("search");
    var order = document.getElementById("order");
    function geteventsforgallery() {
        $.ajax({
            type: "post",
            url: "galleryfetch.php",
            data: { search: search.value, order: order.value },
            dataType: "json",
            success: function (response) {
                $("#events").html(response.html);
            }
        });
    }
</script>
<?php
require "student_footer.php";
?>