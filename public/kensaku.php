
<?php
//session check//
session_start();
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");
require_once("../src/php/OpenGraph.php");
sschk();


$name=$_SESSION["name"];

// $kensaku = $_POST['kensaku'];
// 直接kensakuページを叩いた時用に「HTML」をデフォルト設定
if(isset($_POST["kensaku"])){
  $kensaku = $_POST["kensaku"];
}else{
  $kensaku = "HTML";
}


/*-------------------------------------------------------------------------
DB接続（検索結果一覧作成用）
-------------------------------------------------------------------------*/
//0. 事前準備：検索文言をSQL用に組み立てる
if(strlen($kensaku)>0){
  $kensaku2 = str_replace("　", " ", $kensaku);  //全角スペースを半角スペースに置換
  $array = explode(" ",$kensaku2);               //検索文言を半角スペースで分割
  $where = "WHERE";
  for($i=0; $i<count($array); $i++){
    $where .="(concat(title,cont,name,lang) LIKE '%$array[$i]%')";
    if($i <count($array) -1){
      $where .= "AND";
    }
  }
}

$post_c="投稿";
$res2 = kennsaku_naiyou($where,$post_c);


/*-------------------------------------------------------------------------
DB接続（人気の言語一覧作成用）
-------------------------------------------------------------------------*/
//1.  DB接続(省略)
//２．データ登録SQL作成
$pdo = db_conn();

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
  <script src="../src/js/jquery-2.1.3.min.js"></script>
  <script src="../src/js/main.js"></script>
   <!-- ↓　ここを変更する -->
  <link rel="stylesheet" href="../src/css/main.css">
  <title>GEEKBOOK</title>
</head>

<body>
  <div id="loader-bg">
    <div id="loader">
      <img src="../img/neko.gif">
      <p style="color: #fff; font-size: 18px;">ちょっと待ってね ...</p>
    </div>
  </div>
  <header>
    <div class="header_container">
      <div class="header_logo_container">
        <div class="header_logo">
          <img src="../img/topImg.png">
        </div>
        <p class="login_name">こんにちは！　<?=$_SESSION["name"]?>　さん</p>
      </div>
    </div>
    <div class="header_button">
      <div class="header_button_container">
        <div class="blue ui buttons">
          <button class="ui button" onclick="location.href='main.php'"><i class="home icon"></i>ホーム</button>
          <button class="ui button" onclick="location.href='newpage.php'"><i class="envelope open icon"></i>新規投稿</button>
          <button class="ui button" onclick="location.href='mypage.php'"><i class="clipboard list icon"></i>投稿リスト</button>
          <button class="ui button" onclick="location.href='bookmark.php'"><i class="star icon"></i>ブックマーク</button>
          <button class="ui button" onclick="location.href='useredit.php'"><i class="pen square icon"></i>プロフィール編集</button>
          <?php if($_SESSION["kanri"]==1): ?>
          <button class="ui button" onclick="location.href='superuser.php'">Admin</button>
          <div class="header_button_Rev" style="margin-left:20%;">
            <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
          </div>
          <?php else: ?>
            <div class="header_button_Rev" style="margin-left:40%;">
              <button class="ui icon button" onclick="location.href='../src/php/logout.php'">Logout</button>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>



<div id="wrap">
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

    <div class="out_container">
      <div class="r_out">
        <div>「<?=$kensaku?>」の検索結果:</div>

        <div><?php echo count($res2);?>件</div>
      </div>
    </div>
  <!-- ↑ search_container -->



<div class="block">
      <table class="mytable">

  <?php foreach($res2 as $value): ?>
    <tr>
      <td>
        <div class="new_result">
          <div class="result_container">
            <a href="result.php?id=<?php echo h($value[id]); ?>" class="new_title"><?php echo h($value[title]); ?></a>
            <p class="new_p">コメント：<?php echo h($value[cont]); ?></p>
            <div class="new_userview">
              <p class="new_person">投稿者：<?php echo h($value[name]); ?>さん</p>
              <p class="new_review">評価：<?php echo h($value[star]); ?></p>
            </div>
            <div class="new_postdate">
              <p class="new_date">投稿日：<?php echo $value[pdate]; ?></p>
            </div>
            <div class="ui_label"><font style="vertical-align: inherit;"><php echo h($value[lang]); ?></font></div>
          </div>
            <div class="result_container">
            <?php $graph = OpenGraph::fetch(h($value[url])); ?>
            <?php if(isset($graph->image) == true): ?>
            <img class="ogp_img" src="<?php  echo $graph->image; ?>">
            <?php else: ?>
            <img src="" >
            <?php endif; ?>
          </div>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>

        </table>

</div>
  <!-- ↑　new_container -->

  </div>
  <!-- ↑　main_right -->

  </div>
</div>






  <!-- <script src="../src/js/jquery-2.1.3.min.js"></script>
  <script src="../src/JS/main.js"></script> -->
  <script src="../src/js/PaginateMyTable.js"></script>
  <!-- <script src="paginathing.min.js"></script> -->

<script>
$(".mytable").paginate({
  rows: 5,          // Set number of rows per page. Default: 5
  position: "bottom",   // Set position of pager. Default: "bottom"
  jqueryui: true,    // Allows using jQueryUI theme for pager buttons. Default: false
  showIfLess: false  // Don't show pager if table has only one page. Default: true
});
</script>


    <footer>
    <div class="footer">
      <p>copyright ©️ GEEKBOOK <br> For G’s Academy</p>
    </div>
  </footer>

</body>
</html>
