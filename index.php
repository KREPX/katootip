<?php
session_start();
require_once 'db.php';

$query = $connection->prepare("SELECT * FROM b_main INNER JOIN users ON b_main.u_id = users.u_id INNER JOIN tags ON b_main.t_id = tags.t_id ORDER BY b_main.bm_date DESC");
$query->execute();
$result = $query->fetchAll();

?>


<?php include 'include/header.php' ?>
<div class="container">

    <!-- body -->
    <div class="card" style="width: 800px; display: block; margin: auto;">
        <div class="card-header">
            <h3>กระทู้ทั้งหมด</h3>
        </div>
        <div class="card-body">
            <?php foreach ($result as $row) { ?>
                <div class="list-group m-2">
                    <a href="detail.php?bm_id=<?php echo $row['bm_id'] ?>" class="list-group-item list-group-item-action"><?php echo $row['bm_title'] ?>
                        <small class="text-muted nav">
                            หมวดหมู่<span class="mx-2">:</span> <strong><?php echo $row['t_name'] ?></strong> <span class="mx-2">|</span> <?php echo $row['bm_date'] ?> <span class="mx-2">|</span> <?php echo $row['fullname'] ?>
                        </small>
                    </a>
                </div>
            <?php } ?>
        </div>

    </div>
    <!-- end body -->

</div>
<!-- footer -->
<?php include 'include/footer.php' ?>
<!-- footer -->