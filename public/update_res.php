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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update_course</title>
</head>
<body>
    <form action="" method="POST">
        <label>コメント：<?=$responses["res"]?>
        <input type="text" name="res"></label><br>
        <button type="submit" value="更新">更新</button>
    </form>
</body>
</html>