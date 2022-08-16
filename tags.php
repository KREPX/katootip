<?php
session_start();
require_once 'db.php';

$t_id = $_GET['t_id'];

$tags = $connection->prepare("SELECT * FROM tags WHERE t_id = :t_id");
$tags->bindParam(':t_id', $t_id);
$tags->execute();
$r_tags = $tags->fetch();

$query = $connection->prepare("SELECT * FROM b_main INNER JOIN tags ON b_main.t_id = tags.t_id WHERE b_main.t_id = :t_id");
$query->bindParam(':t_id', $t_id);
$query->execute();
$result = $query->fetchAll();

?>


<?php include 'include/header.php' ?>
<div class="container">

    <!-- body -->
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">หมวดหมู่: <?php echo $r_tags['t_name'] ?></h3>
        </div>
        <div class="row">
            <?php foreach ($result as $row) { ?>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-start-primary py-2">
                        <div class="card-body" style="background-color: white;">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <a href="/detail.php?bm_id=<?php echo $row['bm_id'] ?>" style="text-decoration: none;">
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>หมวดหมู่: <?php echo $row['t_name'] ?></span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span><?php echo $row['bm_title'] ?></span></div>
                                    </a>

                                </div>
                                <div class="col-auto"><i class="fa-solid fa-tag fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (empty($result)) { ?>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-start-primary py-2">
                        <div class="card-body" style="background-color: white;">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <a href="/tags.php?t_id=<?php echo $t_id ?>" style="text-decoration: none;">
                                        <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>หมวดหมู่: <?php echo $r_tags['t_name'] ?></span></div>
                                        <div class="text-dark fw-bold h5 mb-0"><span>ไม่มีข้อมูล</span></div>
                                    </a>

                                </div>
                                <div class="col-auto"><i class="fa-solid fa-tag fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

</div>
<!-- end body -->

</div>
<!-- footer -->
<?php include 'include/footer.php' ?>
<!-- footer -->