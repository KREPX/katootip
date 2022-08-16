<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['u_id']) || $_SESSION['type'] != '1') {
    header('location: ../index.php');
}

$sql = $connection->query("SELECT * FROM users");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
$num = 1;

if (isset($_GET['del_id'])) {

    $del_id = $_GET['del_id'];

    $uimg = $connection->prepare("SELECT u_img FROM users WHERE u_id=:u_id");
    $uimg->bindParam("u_id", $del_id, PDO::PARAM_STR);
    $uimg->execute();
    $u_result = $uimg->fetch(PDO::FETCH_ASSOC);
    unlink("../image/user/" . $u_result['u_img']);

    $sql = $connection->prepare("DELETE FROM users WHERE u_id = :id");
    $sql->bindParam("id", $del_id, PDO::PARAM_STR);
    $sql->execute();
    $connection = null;
    header('Location: all_member.php');
}


?>

<!-- header -->
<?php include '../admin/include/header.php' ?>
<!-- end header -->

<!-- content -->
<div class="container">
    <div class="container-fluid">
        <h3 class="text-dark mb-4">สมาชิกทั้งหมด</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">ข้อมูลสมาชิก</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="MemberTable" class="table my-0">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รูปโปรไฟล์</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>อีเมล</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <?php if ($user['u_id'] != $_SESSION['u_id']) : ?>
                                    <tr>
                                        <td><?php echo $num++; ?></td>
                                        <td><img width="64" height="64" src="../image/user/<?php echo $user['u_img']; ?>" /></td>
                                        <td><?php echo $user['fullname']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td>
                                            <?php if ($user['type'] == 1) : ?>
                                                <p>แอดมิน</p>
                                            <?php elseif ($user['type'] == 0) : ?>
                                                <p>ผู้ใช้งาน</p>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="edit_member.php?id=<?php echo $user['u_id'] ?>">
                                                <button class="btn btn-warning btn-sm">แก้ไข</button>
                                            </a>
                                            <a href="?del_id=<?php echo $user['u_id'] ?>">
                                                <button class="btn btn-danger btn-sm">ลบ</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รูปโปรไฟล์</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>อีเมล</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
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