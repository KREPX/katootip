<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['u_id'])) {
    header('location: index.php');
}

if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];
}

$query = $connection->prepare("SELECT * FROM users WHERE u_id=:u_id");
$query->bindParam("u_id", $u_id, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

if (isset($_REQUEST['save'])) {

    $fullname = $_REQUEST['fullname'];

    $img = $_FILES['img']['name'];
    $tmp_dir = $_FILES['img']['tmp_name'];
    $upload_dir = 'image/user/' . $img;
    $dicectory = 'image/user/';

    if ($img) {
        if (!file_exists($upload_dir)) {
            unlink($dicectory . $result['u_img']);
            move_uploaded_file($tmp_dir, 'image/user/' . $img);
        }
    } else {
        $img = $result['u_img'];
    }

    $query = $connection->prepare("UPDATE users SET fullname=:fullname, u_img=:img WHERE u_id=:u_id");
    $query->bindParam("fullname", $fullname, PDO::PARAM_STR);
    $query->bindParam("img", $img, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    if ($query->execute()) {
        $updateMsg = "อัพเดทข้อมูลสำเร็จ";
        header("Refresh:1;edit_profile.php");
    } else {
        $errorMsg = "อัพเดทข้อมูลไม่สำเร็จ";
    }
}

?>

<?php include 'include/header.php' ?>
<div class="container">
    <div class="card" style="width: 500px; display: block; margin: auto; text-align: center;">
        <div class="card-header">
            <h3>แก้ไขโปรไฟล์</h3>
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
                <div>
                    <img src="image/user/<?php echo $result['u_img'] ?>" width="256" height="256">
                </div>
                <hr>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="img">เปลี่ยนรูปโปรไฟล์</label>
                        <input type="file" accept="image/*" class="form-control" name="img">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $result['email'] ?>" placeholder="email" readonly>
                        <label for="fullname">อีเมล</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $result['fullname'] ?>" placeholder="fullname">
                        <label for="fullname">ชื่อ - นามสกุล</label>
                    </div>
                    <hr>

                    <button type="submit" name="save" value="save" class="btn btn-primary">บันทึก</button>
                    <a href="index.php" class="btn btn-danger">ยกเลิก</a>
                </form>
                <hr>
            </div>


        </div>

    </div>


</div>

<!-- footer -->
<?php include 'include/footer.php' ?>
<!-- footer -->