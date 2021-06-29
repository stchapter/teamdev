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
    $sql = "DELETE FROM bookmark_table WHERE uid = :uid AND pid = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':uid',$_SESSION['id'], PDO::PARAM_INT);
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
