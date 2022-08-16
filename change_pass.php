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

    $old_pass = $_REQUEST['old_password'];
    $new_pass = $_REQUEST['new_password'];
    $confirm_pass = $_REQUEST['con_password'];
    $hash_pass = $result['password'];
    $hash = password_verify($old_pass, $hash_pass);
    $hash_new = password_hash($new_pass, PASSWORD_DEFAULT);
    
    if ($hash == true) {
        if ($new_pass == $confirm_pass) {
            $query = $connection->prepare("UPDATE users SET password=:password WHERE u_id=:u_id");
            $query->bindParam("password", $hash_new, PDO::PARAM_STR);
            $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
            if ($query->execute()) {
                $updateMsg = "เปลี่ยนรหัสผ่านสำเร็จ";
                header('Refresh:1;change_pass.php');
            } else {
                $errorMsg = "เปลี่ยนรหัสผ่านไม่สำเร็จ";
            }
        } else {
            $errorMsg = "รหัสผ่านไม่ตรงกัน";
        }
    } else {
        $errorMsg = "รหัสเก่าไม่ถูกต้อง";
    }

}

?>

<?php include 'include/header.php' ?>
<div class="container">
    <div class="card" style="width: 500px; display: block; margin: auto; text-align: center;">
        <div class="card-header">
            <h3>เปลี่ยนรหัสผ่าน</h3>
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
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="old_password" placeholder="Password" required>
                        <label for="floatingPassword">รหัสผ่านเก่า</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="new_password" placeholder="Password" required>
                        <label for="floatingPassword">รหัสผ่าน</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="Con-Password" name="con_password" required>
                        <label for="floatingPassword">ยืนยันรหัสผ่าน</label>
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