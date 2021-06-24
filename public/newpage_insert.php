<?php
//session check//
//session_start();
//sschk();
include("../src/php/funcs.php");
include("../src/php/db.php");


//1. POSTデータ取得
$lang     = $_POST["lang"];
$title    = $_POST["title"];
$cont     = $_POST["cont"];
$url      = $_POST["url"];
$cost     = $_POST["cost"];
$post     = $_POST["post"];
$star     = $_POST["star"];
$fpass    = fileUpload("upfile","../upload/");
$fname    = $_FILES["upfile"]["name"];
$err_msgs = array();


if($lang == "選択してください"){
  array_push($err_msgs,'言語を選択してください<br><br>');
}
if(strlen($title) == 0){
  array_push($err_msgs,'タイトルを入力してください<br><br>');
}
if(strlen($cont) == 0){
  array_push($err_msgs,'おすすめ内容を入力してください<br><br>');
}
if(count($err_msgs) === 0) {


/* ------------------------------------------------
    DBにデータを保存 start
------------------------------------------------ */

    // 2. DB接続します
    $pdo = db_conn();
    // $uid = $_SESSION["uid"];
    $uid = 1;


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
    echo '<p>登録が完了しました</p>';
    echo '<a href="newpage.php">登録画面に戻る</a>';
    /* ------------------------------------------------
    //////DBにデータを保存 end
    ------------------------------------------------ */

} else{
  foreach ($err_msgs as $msg){
    echo $msg;
    echo '<br>';
  }
  echo '<a href="newpage.php">登録画面に戻る</a><br><br>';
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>新規投稿</title>
    </head>
<body">

</body>
</html>