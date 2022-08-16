<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['u_id']) || $_SESSION['type'] != '1') {
    header('location: ../index.php');
}

$tag = $connection->query("SELECT * FROM tags");
$tags = $tag->fetchAll(PDO::FETCH_ASSOC);
$num = 1;

if (isset($_GET['del_id'])) {

    $del_id = $_GET['del_id'];

    $sql = $connection->prepare("DELETE FROM tags WHERE t_id = :t_id");
    $sql->bindParam("t_id", $del_id, PDO::PARAM_STR);
    $sql->execute();
    $connection = null;
    header('Location: all_tag.php');
}

?>


<!-- header -->
<?php include '../admin/include/header.php' ?>
<!-- end header -->

<!-- content -->
<div class="container">
    <div class="container-fluid">
        <h3 class="text-dark mb-4">หมวดหมู่ทั้งหมด</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">ข้อมูลหมวดหมู่</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table id="TagTable" class="table my-0">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tags as $tag) : ?>
                                <tr>

                                    <td><?php echo $num++ ?></td>
                                    <td><?php echo $tag['t_name'] ?></td>
                                    <td>
                                        <a href="edit_tag.php?t_id=<?php echo $tag['t_id'] ?>">
                                            <button class="btn btn-warning btn-sm">แก้ไข</button>
                                        </a>
                                        <a href="?del_id=<?php echo $tag['t_id'] ?>">
                                            <button class="btn btn-danger btn-sm">ลบ</button>
                                        </a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อ</th>
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