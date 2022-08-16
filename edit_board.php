<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['u_id'])) {
    header('location: index.php');
}

if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];
}

if (isset($_GET['bm_id'])) {

    $bm_id = $_GET['bm_id'];
    $query = $connection->prepare("SELECT * FROM b_main WHERE bm_id = :bm_id AND u_id = :u_id");
    $query->bindParam("bm_id", $bm_id, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
}


if (isset($_POST['submit'])) {

    $detail = $_POST['content'];
    $date = date("Y-m-d H:i:s");
    $query = $connection->prepare("UPDATE b_main SET bm_detail = :detail, bm_date = :date WHERE bm_id = :bm_id AND u_id = :u_id");
    $query->bindParam("detail", $detail, PDO::PARAM_STR);
    $query->bindParam("date", $date, PDO::PARAM_STR);
    $query->bindParam("bm_id", $bm_id, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->execute();
    $connection = null;
    header('Location: detail.php?bm_id=' . $bm_id);
}

if (isset($_REQUEST['del'])) {

    $del = $_REQUEST['del'];

    $query = $connection->prepare("DELETE FROM b_main WHERE bm_id = :bm_id AND u_id = :u_id");
    $query->bindParam("bm_id", $del, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    if ($query->execute()) {

        $query = $connection->prepare("DELETE FROM b_sub WHERE bm_id = :bm_id AND u_id = :u_id");
        $query->bindParam("bm_id", $del, PDO::PARAM_STR);
        $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
        $query->execute();
        $connection = null;
        header('Location: index.php');
    }

    $connection = null;
    header('Location: index.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>แก้ไขกระทู้ - <?php echo $result['bm_title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'include/header.php' ?>
    <div class="container p-3">
        <div class="card" style="width: 850px; display: block; margin: auto; ">
            <div class="card-header">
                <h3>แก้ไขกระทู้</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <textarea class="p-2" name="content" id="editor"><?php echo $result['bm_detail'] ?></textarea>
                    <br>
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                        <div class="text-muted nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                            <input class="btn btn-primary" type="submit" name="submit" value="แก้ไขกระทู้">&nbsp;
                            <a href="detail.php?bm_id=<?php echo $result['bm_id'] ?>" class="btn btn-danger">ยกเลิก</a>
                        </div>

                        <a href="?del=<?php echo $result['bm_id'] ?>" name class="btn btn-danger">ลบ</a>
                    </div>

                </form>
                <hr>
            </div>
        </div>

    </div>

    <!-- footer -->
    <?php include 'include/footer.php' ?>
    <!-- footer -->