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

// bookmark(登録URL)
// ボタンを押下した時
if ($_POST) {

    $pid = $_POST['id'];
    $sql = "INSERT INTO bookmark_table(uid,pid,adddate)VALUES(:uid, :pid, sysdate()) ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uid',$_SESSION['uid'], PDO::PARAM_INT);
    $stmt->bindValue(':pid', $pid, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        redirect('../../public/result.php?id=' . $pid);
    } else {
        sql_error($stmt);
        exit;
    }
}

?>