<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['u_id']) || $_SESSION['type'] != '1') {
    header('location: ../index.php');
}

$query = $connection->prepare("SELECT * FROM users");
$query->execute();
$users = $query->fetchAll();

$count_u = $query->rowCount();
// ------------------------------------------------------------------------
$bm = $connection->prepare("SELECT * FROM b_main");
$bm->execute();
$b_main = $bm->fetchAll();

$count_bm = $bm->rowCount();
// ------------------------------------------------------------------------
$b_sub = $connection->prepare("SELECT * FROM b_sub");
$b_sub->execute();
$b_subs = $b_sub->fetchAll();

$count_bs = $b_sub->rowCount();
// ------------------------------------------------------------------------
$tag = $connection->prepare("SELECT * FROM tags");
$tag->execute();
$tags = $tag->fetchAll();

$count_tag = $tag->rowCount();
?>


<!-- header -->
<?php include '../admin/include/header.php' ?>
<!-- end header -->

<!-- content -->
<div class="container">
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Dashboard</h3>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-primary py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>กระทู้ทั้งหมด</span></div>
                                <div class="text-dark fw-bold h5 mb-0"><span><?php echo $count_bm ?></span></div>
                            </div>
                            <div class="col-auto"><i class="fa-solid fa-rectangle-list fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-success py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1"><span>ความคิดเห็นทั้งหมด</span></div>
                                <div class="text-dark fw-bold h5 mb-0"><span><?php echo $count_bs ?></span></div>
                            </div>
                            <div class="col-auto"><i class="fa-solid fa-comments fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-info py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-danger fw-bold text-xs mb-1"><span>จำนวนผู้ใช้</span></div>
                                <div class="row g-0 align-items-center">
                                    <div class="col-auto">
                                        <div class="text-dark fw-bold h5 mb-0 me-3"><span><?php echo $count_u ?></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto"></i><i class="fa-solid fa-users fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card shadow border-start-warning py-2">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>หมวดหมู่ทั้งหมด</span></div>
                                    <div class="text-dark fw-bold h5 mb-0"><span><?php echo $count_tag ?></span></div>
                                </div>
                                <div class="col-auto"><i class="fa-solid fa-tags fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div align=center>
        <div class="col-lg-5 col-xl-4">
            <div class="card shadow mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-uppercase text-primary fw-bold m-0">ข้อมูล Katootip</h6>
                    <div class="dropdown no-arrow"><i class="fas fa-ellipsis-v text-gray-400"></i>
                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area"><canvas id="myChart" height="320" style="display: block; width: 257px; height: 320px;" width="257"></canvas></div>
                    <div class="text-center small mt-4"><span class="me-2"><i class="fas fa-circle text-danger"></i> ผู้ใช้</span><span class="me-2"><i class="fas fa-circle text-primary"></i> กระทู้ทั้งหมด</span><span class="me-2"><i class="fas fa-circle text-warning"></i> หมวดหมู่</span><span class="me-2"><i class="fas fa-circle text-success"></i> ความคิดเห็น</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end content -->

<!-- footer -->
<?php include '../admin/include/footer.php'; ?>
<!-- end footer -->

</body>

</html>