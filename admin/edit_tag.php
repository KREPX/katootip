<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['u_id']) || $_SESSION['type'] != '1') {
    header('location: ../index.php');
}

if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];
}

$t_id = $_GET['t_id'];

$ed_tag = $connection->prepare("SELECT * FROM tags WHERE t_id = :t_id");
$ed_tag->bindParam("t_id", $t_id, PDO::PARAM_STR);
$ed_tag->execute();
$tag = $ed_tag->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['edit_tag'])) {

    $t_name = $_POST['t_name'];
    $sql = $connection->prepare("UPDATE tags SET t_name = :t_name WHERE t_id = :t_id");
    $sql->bindParam("t_name", $t_name, PDO::PARAM_STR);
    $sql->bindParam("t_id", $t_id, PDO::PARAM_STR);
    $sql->execute();
    $connection = null;
    header('Location: all_tag.php');

}


?>

<?php include '../admin/include/header.php' ?>
<div class="container">
    <div class="card" style="width: 500px; display: block; margin: auto; text-align: center;">
        <div class="card-header">
            <h3>แก้ไขหมวดหมู่</h3>
        </div>
        <div class="card-body">
            <div class="container">
                <?php
                if (isset($errorMsg)) {
                ?>
                    <div class="alert alert-danger">
                        <strong><?php echo $errorMsg; ?></strong>
                    </div>
                <?php } ?>
                <?php
                if (isset($updateMsg)) {
                ?>
                    <div class="alert alert-success">
                        <strong><?php echo $updateMsg; ?></strong>
                    </div>
                <?php } ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="t_name" value="<?php echo $tag['t_name'] ?>">
                        <label for="title">ชื่อหมวดหมู่</label>
                    </div>
                    <hr>
                    <button type="submit" name="edit_tag" class="btn btn-primary">แก้ไขหมวดหมู่</button>
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