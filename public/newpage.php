<?php
//session check//
session_start();
include("../src/php/funcs.php");
include("../src/php/db.php");
sschk();

/*-------------------------------------------------------------------------
DB接続（langのプルダウン作成）
-------------------------------------------------------------------------*/
//1.  DB接続します
$pdo = db_conn();
$uid = $_SESSION["id"];

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM lang_table ORDER BY lang ASC");
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
    $view .='<option value = "'.$res["lang"].'">'.$res["lang"].'</option>';
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
  <link rel="stylesheet" href="../src/css/responsive.css">
  <title>GEEKBOOK</title>
  <style>
    p.error{
      margin:0;
      color:red;
     font-weight:bold;
      margin-bottom:1em;
    }
  </style>
</head>
<body>
  <header>
    <div class="header_container">
      <div class="header_logo_container">
        <div class="header_logo">
          <img src="../img/topImg.png">
        </div>
      </div>
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
  </header>

    <div class="editor_container">

        <h2 class="editor_title">新規投稿</h2>
        <form method="POST" action="../src/php/newpage_insert.php" enctype="multipart/form-data">

            <div class="contents">
            <p>言語</p>
            <div class="select">
                <select name="lang" class="validate not0">
                    <option placeholder="選択してください"></option>
                    <?=$view?>
                </select>
            </div>

            </div>

            <div class="contents">
            <p>タイトル:</p>
                <div class="ui input text_input">
                <input type="text" name="title" class="validate required max64" placeholder="64文字以内で入力してください">
                </div>
            </div>

            <div class="contents">
            <p>おすすめ内容:</p>
                <div>
                <textarea name="cont" rows="4" clos="50" class="validate required"></textarea>
                </div>
            </div>

            <div class="contents_fix">
            <div class="contents">
            <p>URL
                <div class="ui input text_input">
                <input type="url" name="url" placeholder="https://">
                </div>
            </p>
            </div>

            <div class="contents">
            <p>有料・無料
            <div class="select">
                <select name="cost">
                    <option value ="有料">有料</option>
                    <option value ="無料">無料</option>
                </select>
            </div>
            </p>
            </div>
            </div>

            <div class="contents_fix">
            <div class="contents">
            <p>投稿
            <div class="select">
                <select name="post">
                    <option value ="投稿">投稿</option>
                    <option value ="下書き保存">下書き保存</option>
                </select>
            </div>
            </p>
            </div>

            <div class="contents">
            <p>おすすめ度
            <div class="select">
                <select name="star">
                    <option value ="★★★★★">★★★★★</option>
                    <option value ="★★★★☆">★★★★☆</option>
                    <option value ="★★★☆☆">★★★☆☆</option>
                    <option value ="★★☆☆☆">★★☆☆☆</option>
                    <option value ="★☆☆☆☆">★☆☆☆☆</option>
                </select>
            </div>
            </p>
            </div>
            </div>

            <div class="contents">
            <p>添付ファイル</p>
                <input class="text_input" type="file" accept="image/*, .pdf, .jpg, .jpeg, .png" name="upfile">
            </div>
            <input class="cost_submit ui primary button" type="submit" value="投稿" style="margin-top: 20px;">
        </form>

    </div>

<?php
include("./instance/footer.php");
?>

<script src="../src/JS/jquery-2.1.3.min.js"></script>
<script src="../src/JS/jquery-main.js"></script>
