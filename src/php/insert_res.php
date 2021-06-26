<?php
//session check//
session_start();
// sschk();

include("funcs.php");
include("db.php");

//DBに接続
$pdo = db_conn();

// ダミーのログインユーザーIDセット
// $_SESSION['uid'] = 2;

// コメント（登録URL）
// ボタンを押下した時
if ($_POST) {
    $res = $_POST['res'];
    $pid = $_POST['pid'];
    $sql = "INSERT INTO res_table(uid,pid,res,life,rdate)VALUES(:uid, :pid, :res, 0, sysdate()) ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uid', $_SESSION['uid'], PDO::PARAM_INT);
    $stmt->bindValue(':pid', $pid, PDO::PARAM_INT);
    $stmt->bindValue(':res', $res, PDO::PARAM_STR);
    $status = $stmt->execute();
    // var_dump($status);exit;

    if ($status) {
        redirect('../../public/result.php?id=' . $pid);
    } else {
        sql_error($stmt);
        exit;
    }
}

?>