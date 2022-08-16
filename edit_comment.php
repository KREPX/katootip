<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['u_id'])) {
    header('location: index.php');
}

if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];
}

if (isset($_GET['bs_id'])) {

    $bs_id = $_GET['bs_id'];
    $query = $connection->prepare("SELECT * FROM b_sub INNER JOIN b_main ON b_sub.bm_id = b_main.bm_id WHERE bs_id = :bs_id AND b_sub.u_id = :u_id");
    $query->bindParam("bs_id", $bs_id, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
}


if (isset($_POST['submit'])) {

    $detail = $_POST['content'];
    $date = date("Y-m-d H:i:s");
    $query = $connection->prepare("UPDATE b_sub SET bs_detail = :detail, bs_date = :date WHERE bs_id = :bs_id AND u_id = :u_id");
    $query->bindParam("detail", $detail, PDO::PARAM_STR);
    $query->bindParam("date", $date, PDO::PARAM_STR);
    $query->bindParam("bs_id", $bs_id, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->execute();
    $connection = null;
    header('Location: detail.php?bm_id=' . $result['bm_id']);
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>แก้ไขความคิดเห็น - <?php echo $result['bm_title'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'include/header.php' ?>
    <div class="container p-3">
        <div class="card" style="width: 850px; display: block; margin: auto; ">
            <div class="card-header">
                <h3>แก้ไขความคิดเห็น</h3>
            </div>
            <div class="card-body">

                <form action="" method="post">
                    <textarea class="p-2" name="content" id="editor"><?php echo $result['bs_detail'] ?></textarea>
                    <br>
                    <p><input class="btn btn-primary" type="submit" name="submit" value="แก้ไขความคิดเห็น">&nbsp;
                        <a href="detail.php?bm_id=<?php echo $result['bm_id'] ?>" class="btn btn-danger">ยกเลิก</a>
                    </p>
                </form>
                <hr>
            </div>
        </div>

    </div>

    <!-- footer -->
    <?php include 'include/footer.php' ?>
    <!-- footer -->