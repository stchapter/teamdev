<?php

//session check//
session_start();
// sschk();

// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

$res_id = $_GET['res_id'];
$sql = "SELECT * FROM res_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $res_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $responses = $stmt->fetch(PDO::FETCH_ASSOC);
};

// 更新ボタンをクリックした時
if ($_POST) {
    $res = $_POST['res'];
    $pid = $responses['pid'];
    $update_sql = "UPDATE res_table SET res = :res, rdate = sysdate() WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindValue(':res', $res, PDO::PARAM_STR);
    $stmt->bindValue(':id', $res_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        redirect('result.php?id=' . $pid);
    } else {
        sql_error($stmt);
        exit;
    }
}

?>

<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/updateres.css">
  <title>GEEKBOOK</title>
</head>
<body>

<?php include("./instance/header.php"); ?>

    <div class="container_whole">
        <div class="container_co">
            <form action="" method="POST">
                <div class="title">コメントの編集</div>
                <div class="ui fluid action input">
                    <textarea name="res" placeholder="新しいコメントを入力してください" rows="4" cols="80"><?=$responses["res"]?></textarea>
                </div>
                <div class="btn"><button class="big ui blue button" type="submit" value="更新">更新</button></div>
            </form>
        </div>
    </div>

<?php
include("./instance/footer.php");
?>

</body>
</html>
