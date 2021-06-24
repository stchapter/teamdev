<?php

// session ID
// sschk();

// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

$camp = [];
$camp_id = $_GET['id'];
$sql = "SELECT * FROM camp_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $camp_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $campC = $stmt->fetch(PDO::FETCH_ASSOC);
};

// 更新ボタンをクリックした時
if ($_POST) {
    $camp = $_POST['camp'];
    $life = $_POST['life'];
    $update_sql = "UPDATE camp_table SET camp = :camp, life = :life WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindValue(':camp', $camp, PDO::PARAM_STR);
    $stmt->bindValue(':life', $life, PDO::PARAM_INT);
    $stmt->bindValue(':id', $camp_id, PDO::PARAM_INT);
    $status = $stmt->execute();
    
    if ($status) {
        redirect('superuser.php');
        // var_dump($status);exit;
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
    <title>update_camp</title>
</head>
<body>
    <form action="" method="POST">
        <label>校舎：<input type="text" name="camp" value="<?=$campC["camp"]?>"></label><br>
        <label>
            表示：
            <select name="life" id="life">
                <option value="0" <?= $campC['life'] === '0' ? 'selected' : '' ?>>表示</option>
                <option value="1" <?= $campC['life'] === '1' ? 'selected' : '' ?>>非表示</option>
            </select>
        </label><br>
        <input type="submit" value="更新">
    </form>
</body>
</html>