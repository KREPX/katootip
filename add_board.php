<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['u_id'])) {
    header('location: index.php');
}

if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];
}

if (isset($_POST['submit'])) {

    $detail = $_POST['content'];
    $title = $_POST['title'];
    $u_id = $_SESSION['u_id'];
    $t_id = $_POST['t_id'];
    $date = date("Y-m-d H:i:s");
    $query = $connection->prepare("INSERT INTO b_main (u_id, bm_title, bm_detail,t_id,bm_date) VALUES (:u_id, :title, :detail,:t_id,:date)");
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->bindParam("title", $title, PDO::PARAM_STR);
    $query->bindParam("detail", $detail, PDO::PARAM_STR);
    $query->bindParam("t_id", $t_id, PDO::PARAM_STR);
    $query->bindParam("date", $date, PDO::PARAM_STR);
    $query->execute();
    $connection = null;
    header('Location: index.php');
}

$query = $connection->prepare("SELECT * FROM b_main");
$query->execute();
$result = $query->fetchAll();

$tags = $connection->prepare("SELECT * FROM tags");
$tags->execute();
$tags_result = $tags->fetchAll();

?>

<?php include 'include/header.php' ?>
<div class="container">
    <div class="card" style="width: 850px; display: block; margin: auto; ">
        <div class="card-header">
            <h3>ตั้งกระทู้ - ตั้งหัวข้อใหม่</h3>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="title" required>
                    <label for="floatingInput">หัวข้อกระทู้</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-control" name="t_id" required>
                        <option value="">-- เลือกหมวดหมู่ --</option>
                        <?php foreach ($tags_result as $row) { ?>
                            <option value="<?php echo $row['t_id'] ?>"><?php echo $row['t_name'] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingInput">เลือกหมวดหมู่</label>
                </div>
                <textarea class="p-2" name="content" id="editor"></textarea>
                <br>
                <p><input class="btn btn-primary" type="submit" name="submit" value="ตั้งกระทู้"></p>
            </form>
            <hr>
        </div>

    </div>


</div>

<!-- footer -->
<?php include 'include/footer.php' ?>
<!-- footer -->