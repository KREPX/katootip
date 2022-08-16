<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['u_id'])) {
    header('location: index.php');
}

if (isset($_REQUEST['register'])) {

    $email = $_REQUEST['email'];
    $fullname = $_REQUEST['fullname'];
    $password = $_REQUEST['password'];

    //check validate
    if (empty($email) || empty($fullname) || empty($password)) {
        $errorMsg = "ต้องกรอกข้อมูล";
    } else {

        //check password confirm
        if ($_REQUEST['password'] != $_REQUEST['con-password']) {
            $errorMsg = "รหัสผ่านไม่ตรงกัน";
        } else {
            $query = $connection->prepare("SELECT * FROM users WHERE email = :email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $errorMsg = "มีอีเมลอยู่แล้ว";
            } else {
                $img = $_FILES['img']['name'];
                $tmp_dir = $_FILES['img']['tmp_name'];
                $upload_dir = 'image/user/' . $img;
                move_uploaded_file($tmp_dir, $upload_dir);

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $query = $connection->prepare("INSERT INTO users (email, fullname, password, u_img) VALUES (:email, :fullname, :password, :u_img)");
                $query->bindParam("email", $email, PDO::PARAM_STR);
                $query->bindParam("fullname", $fullname, PDO::PARAM_STR);
                $query->bindParam("password", $passwordHash, PDO::PARAM_STR);
                $query->bindParam("u_img", $img, PDO::PARAM_STR);
                if ($query->execute()) {
                    $updateMsg = "สมัครสมาชิกสำเร็จ";
                    header("Refresh:1;index.php");
                } else {
                    $errorMsg = "สมัครสมาชิกไม่สำเร็จ";
                }
            }
        }
    }
}

?>

<?php include 'include/header.php' ?>
<div class="container">
    <div class="card" style="width: 500px; display: block; margin: auto; text-align: center;">
        <div class="card-header">
            <h3>สมัครสมาชิก</h3>
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
                        <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                        <label for="floatingInput">อีเมล</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="fullname" class="form-control" name="fullname" placeholder="fullname" required>
                        <label for="floatingInput">ชื่อ - นามสกุล</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <label for="floatingPassword">รหัสผ่าน</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" placeholder="Con-Password" name="con-password" required>
                        <label for="floatingPassword">ยืนยันรหัสผ่าน</label>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="img">รูปโปรไฟล์</label>
                        <input type="file" accept="image/*" class="form-control" name="img">
                    </div>
                    <hr>
                    <button type="submit" name="register" value="register" class="btn btn-dark">สมัครสมาชิก</button>
                </form>
                <hr>
            </div>


        </div>

    </div>


</div>

<!-- footer -->
<?php include 'include/footer.php' ?>
<!-- footer -->