<?php
//session check//
//session_start();
//sschk();
include("funcs.php");
include("db.php");


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
    echo '登録が完了しました<br><br><br><br>';
    echo '<a href="../../public/newpage.php">登録画面に戻る</a>';
    /* ------------------------------------------------
    //////DBにデータを保存 end
    ------------------------------------------------ */

} else{
  foreach ($err_msgs as $msg){
    echo $msg;
    echo '<br>';
  }
  echo '<br>';
  echo '<a href="../../public/newpage.php">登録画面に戻る</a><br><br>';
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <head><link rel="icon" type="image/x-icon" href="img/favicon.svg"></head>
        <link href="css/reset.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js"></script>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.1.0/css/line-awesome.min.css">
        <title>エラー画面</title>
    </head>
<body class="err_body">

</body>
</html>