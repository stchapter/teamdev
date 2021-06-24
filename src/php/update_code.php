<?php

// session ID
// sschk();

// データベース接続
include("funcs.php");
include("db.php");
$pdo = db_conn();

//1. POSTデータ取得
$kw   = $_POST["kw"];

// コードの更新
$sql = "UPDATE key_table SET kw=:kw WHERE id='1'";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':kw', $kw, PDO::PARAM_STR);
$status = $stmt->execute(); 

// var_dump($status);exit;
// データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("../../public/superuser.php");
}

?>