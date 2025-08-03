<?php
include("student_header.php");
?>

<div class="header">
    <div class="blur">
        <div data-aos="zoom-in" data-aos-duration="1500" class="text text-center text-white fs-1">
            Welcome To Department Of computer Science Alumni
        </div>
    </div>
</div>
<?php
if ($_SESSION["status"] == "un") {
    ?>
    <div class="alert alert-warning container mt-5 border-5 border-end-0 border-top-0 border-bottom-0">
        <strong><i class="bi bi-info-circle-fill pe-2"></i>Verification in Progress</strong><br><br>

        Thank you <b><?= ucwords($_SESSION["sname"]) ?></b> for your submission! Please note that your alumni status
        verification is currently in progress. This
        process typically takes up to two working days. We appreciate your patience and understanding.
    </div>
    <?php
} ?>

<div class="container" id="about">
    <div data-aos="fade-up" data-aos-duration="1000" class="text-center">
        <div class="head">
            <h1 class="pt-3">About Us</h1>
        </div>
    </div>
    <br><br>
    <div data-aos="fade-up" data-aos-duration="1000">
        Welcome to the Department Of computer Science Alumni Association! The Department Of computer Science Alumni Association
        is dedicated to fostering a lifelong relationship between the university and its graduates. As proud
        representatives of Rollwala, our alumni are vital to the continued success and growth of our
        institution.
        The mission of the Department Of computer Science Alumni Association is to engage, connect, and support alumni
        while promoting the values and goals of Rollwala. We strive to create a dynamic and
        inclusive community where alumni can thrive personally and professionally.</p>
        <p>We organize events, reunions, and activities to keep alumni connected with each other and the university. We
            provide platforms for professional networking, mentorship, and career development. We offer various programs
            and services to assist alumni in their personal and professional growth. We encourage alumni to give back
            through volunteer opportunities, mentorship, and philanthropic efforts. We celebrate the achievements and
            contributions of our alumni through awards and recognition programs.</p>
        <p>Become an active member of the Department Of computer Science Alumni Association and contribute to a thriving
            alumni community. Stay connected, share your experiences, and support the next generation of
            Rollwala graduates. Together, we can make a difference. Thank you for your continued support
            and commitment to Rollwala. Welcome to the Department Of computer Science Alumni Association
            family!</p>
    </div>
</div>
<br>
<br>
<div class="events">
    <div class="container">
        <div data-aos="fade-up" data-aos-duration="900" class="text-center">
            <div class="head">
                <h1 class="pt-3">Events</h1>
            </div>
        </div>
        <br>
        <br>
        <div data-aos="fade-up" data-aos-duration="1000">
            <div class="row pb-5">
                <?php $qu = "SELECT *FROM event_master WHERE deleted = 0 ORDER BY event_id DESC LIMIT 3";
                $r = query($qu);
                if ($r->rowCount() > 0) {
                    $ev = $r->fetchAll();
                    foreach ($ev as $e) {
                        ?>
                        <div class="col-lg-4 mb-4">
                            <div class="event-card">
                                <div class="event-image">
                                    <img src="../admin/<?= $e["event_image"] ?>" alt="Event Image">
                                </div>
                                <div class="event-details">
                                    <h2 class="event-title"><?= $e["event_title"] ?></h2>
                                    <p class="event-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= $e["location"] ?>
                                    </p>
                                    <p class="event-time">
                                        <i class="fas fa-clock"></i>
                                        <?php if (date("d-m-Y", strtotime($e["start_date"])) == date("d-m-Y", strtotime($e["end_date"]))) {
                                            echo date("F j, Y | h:i A", strtotime($e["start_date"]));
                                        } else {
                                            echo date("F j, Y | h:i A", strtotime($e["start_date"])) . "<br> <span style='padding-left:33px;'>" . date("F j, Y | h:i A", strtotime($e["end_date"])) . "</span>";
                                        } ?>
                                    </p>
                                </div>
                                <div class="event-footer">
                                    <button class="read-more-btn"><a href="view_event.php?event=<?= $e["event_id"] ?>">Read More
                                        </a></button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-md-12 text-center p-3">
                        <a href="event.php" class="activel p-2 ps-3 pe-3">VIEW ALL <?php $q = "SELECT COUNT(*) as total FROM event_master";
                        $r = query($q);
                        $c = $r->fetch();
                        echo $c['total'] . " EVENTS";
                        ?></a>
                    </div>
                    <?php
                } else {
                    echo "<h1>No Events Found</h1>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
include("student_footer.php");
if (isset($_GET["denied"]) == 1) {
    echo "<script>
        swal.fire({
            title : 'Denied',
            text : 'You Are Not Verified Once You Get Verified You Can View Alumni',
            icon : 'error'
        }).then(function(result){
            window.location.assign('index.php');
        });
    </script>";
}
?>