<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['u_id'])) {
    header('location: index.php');
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $connection->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $errorMsg = "เข้าสู่ระบบล้มเหลว";
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['u_id'] = $result['u_id'];
            $_SESSION['type'] = $result['type'];
            header('Location: index.php');
        } else {
            $errorMsg = "รหัสผ่านผิด";
        }
    }
}


?>

<?php include 'include/header.php' ?>
<div class="container">
    <div class="card" style="width: 500px; display: block; margin: auto; text-align: center;">
        <div class="card-header">
            <h3>เข้าสู่ระบบ</h3>
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
                <form action="" method="post" class="mb-3">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
                        <label for="email">อีเมล</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <label for="password">รหัสผ่าน</label>
                    </div>
                    <hr>
                    <button type="submit" name="login" value="login" class="btn btn-primary">เข้าสู่ระบบ</button>
                    <a href="register.php" class="btn btn-dark">สมัครสมาชิก</a>
                </form>
                <hr>
            </div>


        </div>

    </div>


</div>

<!-- footer -->
<?php include 'include/footer.php' ?>
<!-- footer -->