<?php
//session check//
//session_start();
//sschk();
include("funcs.php");
include("db.php");

//1. POSTデータ取得
// $id = $_GET["id"];
$id       = 20;
$lang     = $_POST["lang"];
$title    = $_POST["title"];
$cont     = $_POST["cont"];
$url      = $_POST["url"];
$cost     = $_POST["cost"];
$post     = $_POST["post"];
$star     = $_POST["star"];
$fpass    = fileUpload("upfile","../../upload/");
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

  //2. DB接続します
  $pdo = db_conn();

  //3. 添付ファイルの更新がない場合
  if($fname == ""){
    $stmt = $pdo->prepare("UPDATE post_table SET lang=:lang,title=:title,cont=:cont,url=:url,cost=:cost,post=:post,star=:star WHERE id=:id");
    $stmt->bindValue(':lang',   $lang,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':title',  $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':cont',   $cont,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':url',    $url,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':cost',   $cost,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':post',   $post,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':star',   $star,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':id',     $id,    PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute(); //実行
    echo '登録が完了しました<br><br><br><br>';
    echo '<a href="../../public/newpage.php">登録画面に戻る</a>';
  }else{
  //３．添付ファイルの更新がある場合
    $stmt = $pdo->prepare("UPDATE post_table SET lang=:lang,title=:title,cont=:cont,url=:url,cost=:cost,post=:post,fpass=:fpass,fname=:fname,star=:star WHERE id=:id");
    $stmt->bindValue(':lang',   $lang,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':title',  $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':cont',   $cont,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':url',    $url,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':cost',   $cost,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':post',   $post,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':fpass',  $fpass, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':fname',  $fname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':star',   $star,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':id',     $id,    PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute(); //実行
    echo '登録が完了しました<br><br><br><br>';
    echo '<a href="../../public/newpage.php">登録画面に戻る</a>';
  }
}else{
  foreach ($err_msgs as $msg){
    echo $msg;
    echo '<br>';
  }
  echo '<br>';
  echo '<a href="../../public/newpage.php">登録画面に戻る</a><br><br>';
}

