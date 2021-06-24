<?php

// session ID
// sschk();

// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

$user = [];
$user_id = $_GET['user_id'];
$sql = "SELECT * FROM user_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
};
// var_dump($user);exit;

// 更新ボタンをクリックした時
if ($_POST) {
    $kanri = $_POST['kanri'];
    $life = $_POST['life'];
    $update_sql = "UPDATE user_table SET kanri = :kanri, life = :life WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindValue(':kanri', $kanri, PDO::PARAM_INT);
    $stmt->bindValue(':life', $life, PDO::PARAM_INT);
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        redirect('superuser.php');
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
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        名前：<?= $user['name'] ?><br>
        校舎：<?= $user['camp'] ?><br>
        コース：<?= $user['course'] ?><br>
        クラス：<?= $user['cls'] ?><br>
        在籍番号：<?= $user['student'] ?><br>
        <label>
            管理：
            <select name="kanri" id="kanri">
                <option value="0" <?= $user['kanri'] === '0' ? 'selected' : '' ?>>一般</option>
                <option value="1" <?= $user['kanri'] === '1' ? 'selected' : '' ?>>管理者</option>
            </select>
        </label><br>
        <label>
            在籍：
            <select name="life" id="life">
                <option value="0" <?= $user['life'] === '0' ? 'selected' : '' ?>>在籍</option>
                <option value="1" <?= $user['life'] === '1' ? 'selected' : '' ?>>離籍</option>
            </select>
        </label><br>
        <input type="submit" value="更新">
    </form>
</body>
</html>