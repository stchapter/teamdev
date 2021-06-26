<?php
//session check//
session_start();
include("funcs.php");
include("db.php");
sschk();

//1. POSTデータ取得
$lang     = $_POST["lang"];
$title    = $_POST["title"];
$cont     = $_POST["cont"];
$url      = $_POST["url"];
$cost     = $_POST["cost"];
$post     = $_POST["post"];
$star     = $_POST["star"];
$fpass    = fileUpload("upfile","../../upload/");
$fname    = $_FILES["upfile"]["name"];


/* ------------------------------------------------
    DBにデータを保存 start
------------------------------------------------ */

    // 2. DB接続します
    $pdo = db_conn();
    $uid = $_SESSION["id"];
    // $uid = 1;


    //３．データ登録SQL作成
    $stmt = $pdo->prepare("INSERT INTO post_table(uid,lang,title,cont,url,cost,post,fpass,fname,star,pdate)VALUES($uid,:lang,:title,:cont,:url,:cost,:post,:fpass,:fname,:star,sysdate())");
    $stmt->bindValue(':lang', $lang, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':cont', $cont, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':url', $url, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':cost', $cost, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':post', $post, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':fpass', $fpass, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':fname', $fname, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':star', $star, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute(); //実行

    /* ------------------------------------------------
    //////DBにデータを保存 end
    ------------------------------------------------ */

    redirect('../../public/newpage.php');

?>