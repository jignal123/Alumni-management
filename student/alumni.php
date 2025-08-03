<?php
require "student_header.php";
if ($_SESSION['status'] == "un") {
    header("location:index.php?denied=1");
} else {
    ?>
    <div class="col-md-12 d-flex justify-content-between p-5" data-aos="fade-down" data-aos-duration="1000">
        <div class="">
            <select name="" id="batch" class="form-select">
                <option value="">All</option>
                <option value="my">My Batchmates</option>
            </select>
        </div>
        <div class="search-box">
            <input type="text" id="search" placeholder="Search...">
            <i class="fa fa-search"></i>
        </div>
    </div>
    <!-- Alumni Profile Card Container -->
    <div class="alumni-profiles-container">
    </div>
    <!-- Modal Structure -->
    <div class="modal fade" id="alumni-profile-modal" tabindex="-1" role="dialog"
        aria-labelledby="alumni-profile-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alumni-profile-modal-label">Alumni Profile</h5>
                    <button type='button' class="btn-close" data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class="modal-body" id="alumniprofile">
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            //$("#alumni-profile-modal").modal("show");
            getallalumni();
            search.addEventListener("keyup",getallalumni);
            batch.addEventListener("change",getallalumni);

            $(document).on("click",'[name="view"]',function(){
                var id=$(this).attr('id');
                $(".loader").show();
                $.ajax({
                    type: "post",
                    url: "user_backend.php",
                    data: {viewalumni : id},
                    dataType: "json",
                    success: function (response) {
                        $(".loader").hide();
                        $("#alumni-profile-modal").modal("show");
                        $("#alumniprofile").html(response.html);
                    }
                });
            });
        });
        var search =document.getElementById("search");
        var batch = document.getElementById("batch");
        function getallalumni() {
            $.ajax({
                type: "post",
                url: "alumnifetch.php",
                data: { batch: $("#batch").val(), search: $("#search").val() },
                dataType: "json",
                success: function (response) {
                    $(".alumni-profiles-container").html(response.html);
                }
            });
        }
    </script>
    <?php
}
require "student_footer.php";
?>