
<?php
//session check//
session_start();
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");
include_once('../src/php/paging.php');
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
ページネーションの初期設定
-------------------------------------------------------------------------*/
//ページネーションの1ページ毎の件数を設定
$row_count = 10;

//現在のページを取得 存在しない場合は1とする
$page = 1;
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = (int)$_GET['page'];
}if(!$page){
    $page = 1;
}

// Limitの開始地点
$scount= ($page - 1)* $row_count;

//$pageの数から件数分を表示するSQLクエリを生成 配列で取得
// var_dump((($page - 1)* $row_count));
// $stmt = $pdo ->prepare("SELECT * FROM pref ORDER BY id LIMIT $scount, $row_count");
// $status = $stmt -> execute();
// $aryPref = $stmt -> fetchAll(PDO::FETCH_ASSOC);

/*-------------------------------------------------------------------------
DB接続（検索結果一覧作成用）
-------------------------------------------------------------------------*/
//事前準備：検索文言をSQL用に組み立てる
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

$kensu = kennsaku_kensu($where);
$naiyo = kennsaku_naiyo($where,$scount,$row_count);

//Pagingクラスを生成し、ページングのHTMLを生成
$pageing = new Paging();
$pageing -> count = $row_count;
$pageing -> setHtml(count($kensu));


/*-------------------------------------------------------------------------
DB接続（人気の言語一覧作成用）
-------------------------------------------------------------------------*/
//1.  DB接続(省略)
$pdo = db_conn();
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

  <?php include("./instance/header.php"); ?>




  <div id="wrap">
    <div class="main_container">

      <div class="main_left">
        <div class="ui vertical menu">
          <div class="item">
            <div class="header" style="font-size: 16px; margin-top: 8px;">人気の言語</div>
            <div class="menu"><?=$view2?></div>
          </div>
        </div>
      </div>

      <div class="main_right">

        <div class="out_container">
          <div class="r_out">
            <div>「<?=$kensaku?>」の検索結果:</div>
            <div><?php echo count($kensu);?>件</div>
          </div>
        </div>
        <!-- ↑ search_container -->


        <div class="block">
          <table class="mytable">
            <?php foreach($naiyo as $value): ?>
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
          <?php echo $pageing -> html ?>
        </div><!-- ↑ block -->
      </div><!-- ↑ main_right -->
    </div><!-- ↑ main_container -->
  </div><!-- ↑ wrap -->
  <?php include("./instance/footer.php");?>
</body>
</html>
