<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['u_id']) || $_SESSION['type'] != '1') {
    header('location: ../index.php');
}

$u_id = $_GET['id'];

$ed_user = $connection->prepare("SELECT * FROM users WHERE u_id = :u_id");
$ed_user->bindParam(':u_id', $u_id);
$ed_user->execute();
$ed_users = $ed_user->fetch(PDO::FETCH_ASSOC);

if (isset($_REQUEST['save'])) {

    $fullname = $_REQUEST['fullname'];
    $type = $_REQUEST['type'];

    $img = $_FILES['img']['name'];
    $tmp_dir = $_FILES['img']['tmp_name'];
    $upload_dir = '../image/user/' . $img;
    $dicectory = '../image/user/';

    if ($img) {
        if (!file_exists($upload_dir)) {
            unlink($dicectory . $ed_users['u_img']);
            move_uploaded_file($tmp_dir, '../image/user/' . $img);
        }
    } else {
        $img = $ed_users['u_img'];
    }

    $query = $connection->prepare("UPDATE users SET fullname=:fullname, u_img=:img, type=:type WHERE u_id=:u_id");
    $query->bindParam("fullname", $fullname, PDO::PARAM_STR);
    $query->bindParam("img", $img, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->bindParam("type", $type, PDO::PARAM_STR);
    if ($query->execute()) {
        $updateMsg = "อัพเดทข้อมูลสำเร็จ";
        header("Refresh:1; url=edit_member.php?id=$u_id");
    } else {
        $errorMsg = "อัพเดทข้อมูลไม่สำเร็จ";
    }
}

?>
<!-- header -->
<?php include '../admin/include/header.php' ?>
<!-- end header -->

<!-- content -->
<div class="container">
    <div class="container-fluid">
        <h3 class="text-dark mb-4">ข้อมูลสมาชิก</h3>
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body text-center shadow">
                        <img class="rounded-circle mb-3 mt-4" src="../image/user/<?php echo $ed_users['u_img'] ?>" width="236" height="236" />
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col">
                        <div class="card shadow mb-3">
                            <div class="card-header py-3">
                                <p class="text-primary m-0 fw-bold">ตั้งค่าผู้ใช้</p>
                            </div>
                            <div class="card-body">
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
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="fullname"><strong>ชื่อ - นามสกุล</strong></label>
                                                <input class="form-control" type="text" value="<?php echo $ed_users['fullname'] ?>" name="fullname" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="email"><strong>Email Address</strong></label>
                                                <input class="form-control" type="email" value="<?php echo $ed_users['email'] ?>" name="email" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="img"><strong>เปลี่ยนรูปโปรไฟล์</strong></label>
                                                <input type="file" accept="image/*" class="form-control" name="img">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3"><label class="form-label" for="type"><strong>Type</strong></label>
                                                <select id="type" class="form-control" name="type">
                                                    <option value="0" <?php if ($ed_users['type'] == 0) {
                                                                            echo 'selected';
                                                                        } ?>>ผู้ใช้งาน</option>
                                                    <option value="1" <?php if ($ed_users['type'] == 1) {
                                                                            echo 'selected';
                                                                        } ?>>แอดมิน</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="submit" name="save">บันทึก</button></div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
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