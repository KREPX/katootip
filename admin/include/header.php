<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KaTooTip🤏</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>



    <div class="p-3 text-bg-dark">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <h1>KaTooTip🤏</h1>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="../admin/admin.php" class="nav-link px-2 text-secondary">Dashboard</a></li>
                <li><a href="../admin/all_tag.php" class="nav-link px-2 text-white">หมวดหมู่ทั้งหมด</a></li>
                <li><a href="../admin/all_member.php" class="nav-link px-2 text-white">สมาชิกทั้งหมด</a></li>
            </ul>

            <div class="text-end">
                <a href="/admin/add_tag.php" class="btn btn-light">สร้างหมวดหมู่ใหม่</a>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


            <div class="dropdown text-end">

                <?php
                if (!isset($_SESSION['u_id'])) {

                ?>
                    <a href="login.php" class="btn btn-outline-light me-2">เข้าสู่ระบบ</a>
                    <a href="register.php" class="btn btn-warning">สมัครสมาชิก</a>
                <?php } else { ?>

                    <?php
                    $usr = $connection->prepare("SELECT * FROM users WHERE u_id = :u_id");
                    $usr->bindParam(':u_id', $_SESSION['u_id']);
                    $usr->execute();
                    $usr_result = $usr->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../image/user/<?php echo $usr_result['u_img'] ?>" width="64" height="64" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <?php
                        if ($usr_result['type'] == '1') {
                        ?>
                            <li><a class="dropdown-item" href="/admin/admin.php">หน้าแอดมิน</a></li>
                        <?php } ?>
                        <li><a class="dropdown-item" href="/edit_profile.php">แก้ไขโปรไฟล์</a></li>
                        <li><a class="dropdown-item" href="/change_pass.php">เปลี่ยนรหัสผ่าน</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="../logout.php">ออกจากระบบ</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>

        </div>
    </div>