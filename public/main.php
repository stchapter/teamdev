<?php
//session check//
session_start();
include("../src/php/funcs.php");
include("../src/php/db.php");
require_once("../src/php/OpenGraph.php");
sschk();

/*-------------------------------------------------------------------------
DB接続（一覧作成用）
-------------------------------------------------------------------------*/
//1.  DB接続します
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT post_table.title, user_table.name, post_table.cont, post_table.url, post_table.star, post_table.lang, post_table.pdate FROM post_table JOIN user_table ON post_table.uid = user_table.id ORDER BY pdate DESC LIMIT 5");
$status = $stmt->execute();

//３．データ表示
$view="";  //HTML文字作成を入れる変数
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
}
while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .='<div class="new_result">';
    $view .='<a href="'.h($res["url"]).'" class="new_title">'.h($res["title"]).'</a>';
    $view .='<p class="new_p">'.h($res["cont"]).'</p>';
    $view .='<div class="new_userview">';
    $view .='<p class="new_person">投稿者：'.h($res["name"]).'さん</p>';
    $view .='<p class="new_review">評価：'.($res["star"]).'</p>';
    $view .='</div>';
    $view .='<div class="new_postdate">';
    $view .='<p class="new_date">投稿日：'.$res["pdate"].'</p>';
    $view .='</div>';
    $view .='<div class="ui label"><font style="vertical-align: inherit;">'.h($res["lang"]).'</font></div>';
    $graph = OpenGraph::fetch(''.h($res["url"]).'');
    if(isset($graph->image) == true){
      $view .='<img src="'.$graph->image.'" />';
    }else{
      //OGP画像がない場合にimageを差し込む場所
    };
    $view .='</div>';
}

/*-------------------------------------------------------------------------
DB接続（人気の言語一覧作成用）
-------------------------------------------------------------------------*/
//1.  DB接続(省略)
//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT lang, count(*) AS COUNT FROM post_table GROUP BY lang ORDER BY COUNT DESC LIMIT 3");
$status = $stmt->execute();

//３．データ表示
$view2="";  //HTML文字作成を入れる変数
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
}
while( $res = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view2 .='<form method="POST" action="kensaku.php">';
    $view2 .='<input class="item" type="submit" style="border:none; outline: none;" name="kensaku" value='.h($res["lang"]).'>';
    $view2 .='</form>';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/main.css">
  <title>GEEKBOOK</title>
</head>
<body>

  <header>
  <div class="header_container">

    <div class="header_logo_container">
      <div class="header_logo">
        <img src="../img/topImg.png">
      </div>
      <p class="login_name"><?=$_SESSION["name"]?>　さん</p>
    </div>


    <div class="header_button">
      <div class="header_button_container">
        <div class="blue ui buttons">
          <button class="ui button" onclick="location.href='main.php'">TOPへ</button>
          <button class="ui button" onclick="location.href='useredit.php'">登録修正</button>
          <button class="ui button" onclick="location.href='newpage.php'">新規投稿</button>
          <button class="ui button" onclick="location.href='mypage.php'">自分の投稿</button>
          <button class="ui button" onclick="location.href='bookmark.php'">Bookmark</button>
          <div class="header_button_R">
            <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
	        </div>
        </div>
      </div>
    </div>

  </div>
  </header>

  <div class="main_container">

  <div class="main_left">
    <div class="ui vertical menu">
      <div class="item">
        <div class="header"><font style="vertical-align: inherit;">人気の言語</font></div>
        <div class="menu">
          <?=$view2?>
        </div>
      </div>
  </div>

  </div>

  <div class="main_right">

  <form method="POST" action="../public/kensaku.php">
    <div class="search_container">
      <div class="ui fluid action input">
        <input type="text" name="kensaku" placeholder="検索する">
        <button class="ui button" type="submit">Search</buttom>
      </div>
    </div>
  </form>
  <!-- ↑ search_container -->


    <div class="new_container">

      <?=$view?>

    </div>

  <!-- ↑　new_container -->


  </div>
  <!-- ↑　main_right -->

  </div>

    <footer>
    <div class="footer">
      <p>copyright ©️ GEEKBOOK <br> For G's Academy</p>
    </div>
  </footer>

</body>
</html>
