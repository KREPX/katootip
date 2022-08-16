<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['u_id']) || $_SESSION['type'] != '1') {
    header('location: ../index.php');
}

if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];
}

if (isset($_REQUEST['add_tag'])) {
    $t_name = $_REQUEST['t_name'];

    $query = $connection->prepare("INSERT INTO tags (t_name) VALUES (:t_name)");
    $query->bindParam(':t_name', $t_name);
    $query->execute();
    $connection = null;
    header("location: all_tag.php");

    
}
?>

<?php include '../admin/include/header.php' ?>
<div class="container">
    <div class="card" style="width: 500px; display: block; margin: auto; text-align: center;">
        <div class="card-header">
            <h3>เพิ่มหมวดหมู่</h3>
        </div>
        <div class="card-body">
            <div class="container">

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="t_name" placeholder="ชื่อหมวดหมู่" required>
                        <label for="title">ชื่อหมวดหมู่</label>
                    </div>
                    <hr>
                    <button type="submit" name="add_tag" class="btn btn-primary">เพิ่มหมวดหมู่</button>
                    <a href="admin.php" class="btn btn-danger">ยกเลิก</a>
                </form>
                <hr>
            </div>


        </div>

    </div>


</div>

<!-- footer -->
<?php include 'include/footer.php' ?>
<!-- footer -->