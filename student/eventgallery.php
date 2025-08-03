<?php
require "student_header.php";
if(isset($_GET["event"]) && isset($_GET["name"])){
    echo "<div class='container mt-5'>
    <h1 class='text-center mb-3'>".$_GET["name"]."</h1>
    <div class='row'>";
    $query = "SELECT image FROM event_gallary WHERE event_id = ?";
    $arr = [$_GET["event"]];
    $res = query($query,$arr);
    $row = $res->fetchAll();
    foreach($row as $r){ 
?>
    <div class="col-md-4 image">
        <a href="../admin/<?= $r["image"] ?>">
            <img src="../admin/<?=$r["image"]?>" class="rounded" alt="image" width="100%" height="250vw">
        </a>
    </div>
<?php
    }
    echo "
        </div>
    </div>";
?>
<?php
}
else{
    header("location:eventsforgallery.php");
}
require "student_footer.php";
?>