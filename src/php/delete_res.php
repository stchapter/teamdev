<?php

//session check//
session_start();
// sschk();

// データベースに接続
include("funcs.php");
include("db.php");
$pdo = db_conn();

$res_id = $_GET['res_id'];
$sql = "SELECT * FROM res_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $res_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $responses = $stmt->fetch(PDO::FETCH_ASSOC);
};
// var_dump($responses);exit;

// 削除ボタンをクリックした時（論理削除）
// lifeフラグ:0が表示される/ lifeフラグ:1で非表示
$pid = $responses['pid'];
// var_dump($pid);exit;
$update_sql = "UPDATE res_table SET life = 1 WHERE id = :id";
$stmt = $pdo->prepare($update_sql);
$stmt->bindValue(':id', $res_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    redirect('../../public/result.php?id=' . $pid);
} else {
    sql_error($stmt);
    exit;
}

?>