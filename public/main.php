<?php
//session check//
session_start();
include("../src/php/funcs.php");
include("../src/php/db.php");
include_once("../src/php/paging.php");
require_once("../src/php/OpenGraph.php");
sschk();

/*-------------------------------------------------------------------------
ページネーションの設定
-------------------------------------------------------------------------*/
//ページネーションの１ページあたりの件数を指定
$row_count = 10;

//現在のページを取得 存在しない場合は1とする
$page = 1;
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = (int)$_GET['page'];
}
if(!$page){
    $page = 1;
}

/*-------------------------------------------------------------------------
DB接続（全件数確認用）
-------------------------------------------------------------------------*/
//1.  DB接続します
$pdo = db_conn();
$stmt = $pdo->prepare("SELECT COUNT(*) FROM post_table");
$status = $stmt->execute();
$count = $stmt -> fetch(PDO::FETCH_COLUMN);


/*-------------------------------------------------------------------------
DB接続（一覧作成用）
-------------------------------------------------------------------------*/
//1．DB接続します(省略)

//2．データ登録SQL作成
// Limitの開始地点
$scount= ($page - 1)* $row_count;

$stmt = $pdo->prepare("SELECT
  post_table.id,
  post_table.title,
  user_table.name,
  post_table.cont,
  post_table.url,
  post_table.star,
  post_table.lang,
  post_table.pdate
  FROM post_table
  JOIN user_table
  ON post_table.uid = user_table.id
  WHERE post_table.life = 0
  AND post_table.post = '投稿'
  ORDER BY pdate DESC
  LIMIT $scount, $row_count");
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
  $view .='<div class="result_container">';
  $view .='<a href="result.php?id='.h($res["id"]).'" class="new_title">'.h($res["title"]).'</a>';
  $view .='<p class="new_p">'.h($res["cont"]).'</p>';
  $view .='<div class="new_userview">';
  $view .='<p class="new_person">投稿者：'.h($res["name"]).'さん</p>';
  $view .='<p class="new_review">評価：'.($res["star"]).'</p>';
  $view .='</div>';
  $view .='<div class="new_postdate">';
  $view .='<p class="new_date">投稿日：'.$res["pdate"].'</p>';
  $view .='</div>';
  $view .='<div class="ui label"><font style="vertical-align: inherit;">'.h($res["lang"]).'</font></div>';
  $view .='</div>';
  $view .='<div class="result_container">';
  $graph = OpenGraph::fetch(''.h($res["url"]).'');
  if(isset($graph->image) == true){
    $view .='<img class="ogp_img" src="'.$graph->image.'"/>';
  }else{
    //OGP画像がない場合にimageを差し込む場所
  };
  $view .='</div>';
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
    $view2 .='<input class="item" type="submit" style="border:none; outline: none; cursor: pointer; margin-bottom: 8px; font-size: 16px;" name="kensaku" value='.h($res["lang"]).'>';
    $view2 .='</form>';
}

//Pagingクラスを生成し、ページングのHTMLを生成
$pageing = new Paging();
$pageing -> count = $row_count;
$pageing -> setHtml($count);

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

<?php include("./instance/header.php"); ?>

  <div class="main_container">

  <div class="main_left">
    <div class="ui vertical menu">
      <div class="item">
        <div class="header" style="font-size: 16px; margin-top: 8px;">人気の言語</div>
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

      <div class="m_out">
        <div>最新の投稿</div>
      </div>


    <div class="new_container">

      <?=$view?>
      <?php echo $pageing -> html ?>

    </div>

  <!-- ↑　new_container -->

    

  </div>
  <!-- ↑　main_right -->

  </div>




<?php
include("./instance/footer.php");
?>
<script src="../src/js/jquery-2.1.3.min.js"></script>
</body>
</html>
