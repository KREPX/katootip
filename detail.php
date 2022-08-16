<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['u_id'])) {
    $u_id = $_SESSION['u_id'];
}

if (isset($_GET['bm_id'])) {
    $bm_id = $_GET['bm_id'];
}


$query = $connection->prepare("SELECT * FROM b_main INNER JOIN users ON b_main.u_id = users.u_id INNER JOIN tags ON b_main.t_id = tags.t_id WHERE bm_id = :bm_id");
$query->bindParam("bm_id", $bm_id, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['answer'])) {

    $detail = $_POST['content'];
    $date = date("Y-m-d H:i:s");
    $query = $connection->prepare("INSERT INTO b_sub (bm_id, u_id, bs_detail, bs_date) VALUES (:bm_id, :u_id, :detail, :date)");
    $query->bindParam("bm_id", $bm_id, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->bindParam("detail", $detail, PDO::PARAM_STR);
    $query->bindParam("date", $date, PDO::PARAM_STR);
    $query->execute();
    $connection = null;
    header('Location: detail.php?bm_id=' . $bm_id);
}

if (isset($_REQUEST['del'])) {
    $del = $_REQUEST['del'];
    $query = $connection->prepare("DELETE FROM b_sub WHERE bs_id = :bs_id AND u_id = :u_id AND bm_id = :bm_id");
    $query->bindParam("bs_id", $del, PDO::PARAM_STR);
    $query->bindParam("u_id", $u_id, PDO::PARAM_STR);
    $query->bindParam("bm_id", $bm_id, PDO::PARAM_STR);
    $query->execute();
    $connection = null;
    header('Location: detail.php?bm_id=' . $bm_id);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $result['bm_title'] ?> - KaTooTip🤏</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'include/header.php' ?>
    <div class="container">

        <!-- body -->
        <!-- contnet -->
        <div class="card">
            <div class="card-header">
                <h3><?php echo $result['bm_title'] ?></h3>
            </div>
            <div class="card-body ck-content">
                <h4 class="organization"><a href="/tags.php?t_id=<?php echo $result['t_id'] ?>" style="text-decoration:none;"><?php echo $result['t_name'] ?></a></h4>
                <?php echo $result['bm_detail'] ?>
            </div>
            <div class="card-footer text">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <small class="text-muted nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <img src="image/user/<?php echo $result['u_img'] ?>" alt="mdo" width="32" height="32">&nbsp;
                        <div style="margin-top: auto; margin-bottom: auto;">
                            <?php echo $result['fullname'] ?>
                            <span class="mx-2">|</span>
                            <?php echo $result['bm_date'] ?>
                        </div>
                    </small>

                    <?php
                    if (isset($_SESSION['u_id'])) {
                        $u_id = $_SESSION['u_id'];
                    } else {
                        $u_id = '';
                    }

                    if ($u_id == $result['u_id']) {
                    ?>

                        <div class="text-end">
                            <a href="edit_board.php?bm_id=<?php echo $result['bm_id'] ?>&u_id=<?php echo $result['u_id'] ?>" class="btn btn-primary">แก้ไข</a>
                        </div>

                    <?php
                    }
                    ?>

                </div>
            </div>

        </div>
        <!-- conntent -->
        <!-- comment -->
        <br>
        <div class="container">
            <?php
            $query = $connection->prepare("SELECT * FROM b_sub INNER JOIN users ON b_sub.u_id = users.u_id WHERE bm_id = :bm_id");
            $query->bindParam("bm_id", $bm_id, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $num = 0;
            foreach ($result as $row) {
                $num++;

            ?>
                <div class="card">

                    <div class="card-header">
                        <h5><b>ความคิดเห็นที่ <?php echo $num ?></b></h5>
                    </div>
                    <div class="card-body ck-content">
                        <?php echo $row['bs_detail'] ?>
                    </div>

                    <div class="card-footer text">
                        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                            <small class="text-muted nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                                <img src="image/user/<?php
                                                        $img = $connection->prepare("SELECT * FROM users WHERE u_id = :u_id");
                                                        $img->bindParam("u_id", $row['u_id'], PDO::PARAM_STR);
                                                        $img->execute();
                                                        $img = $img->fetch(PDO::FETCH_ASSOC);
                                                        echo $img['u_img']
                                                        ?>" alt="mdo" width="32" height="32">&nbsp;
                                <div style="margin-top: auto; margin-bottom: auto;">
                                    <?php echo $row['fullname'] ?>
                                    <span class="mx-2">|</span>
                                    <?php echo $row['bs_date'] ?>
                                </div>

                            </small>

                            <?php
                            if (isset($_SESSION['u_id'])) {
                                $uid = $_SESSION['u_id'];
                            } else {
                                $uid = '';
                            }

                            if ($uid == $row['u_id']) {
                            ?>
                                <div class="text-end">
                                    <a href="edit_comment.php?bs_id=<?php echo $row['bs_id'] ?>" class="btn btn-primary">แก้ไข</a>
                                    <a href="?del=<?php echo $row['bs_id'] ?>&bm_id=<?php echo $row['bm_id'] ?>" class="btn btn-danger">ลบ</a>
                                </div>

                            <?php } ?>

                        </div>

                    </div>

                </div>
                <br>
            <?php } ?>
        </div>
        <!-- comment -->
        <br>
        <div class="card" style="width: 850px; display: block; margin: auto; ">
            <div class="container p-3">
                <div class="card-reply ck-content">
                    <h3>แสดงความคิดเห็น</h3>
                    <form action="" method="post">
                        <textarea class="p-2" name="content" id="editor"><?php if (!isset($_SESSION['u_id'])) {
                                                                                echo "ล็อคอินก่อนแสดงความคิดเห็น";
                                                                            } ?></textarea>
                        <br>
                        <div class="input-group mb-2">
                            <?php if (isset($_SESSION['u_id'])) { ?>
                                <button type="submit" name="answer" value="answer" class="btn btn-primary">ตอบกระทู้</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>


        </div>
        <!-- end body -->

    </div>
    <!-- footer -->
    <?php include 'include/footer.php' ?>
    <!-- footer -->