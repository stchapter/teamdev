<?php
//session check//
// session_start();
// sschk();
include("../src/php/funcs.php");
include("../src/php/db.php");


// $id = $_GET["id"];
$id = 1;          //test用にidを20に固定
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM post_table WHERE id=:id");
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
    sql_error();
}else{
    $row = $stmt->fetch();
}

/*-------------------------------------------------------------------------
DB接続（langのプルダウン作成）
-------------------------------------------------------------------------*/
//1.  DB接続します(省略)
//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM lang_table");
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
      <p class="login_name">ログインしている人の名前　さん</p>
    </div>


    <div class="header_button">
      <div class="header_button_container">
        <div class="blue ui buttons">
          <a class="ui button">TOPへ</a>
          <a class="ui button">登録修正</a>
          <a class="ui button">新規投稿</a>
          <a class="ui button">自分の投稿</a>
          <a class="ui button">Bookmark</a>
  	  <div class="header_button_R">
            <a class="ui button">Logout</a>
	  </div>
        </div>
      </div>
    </div>

  </div>
  </header>

    <div class="editor_container">
        <h2 class="editor_title">投稿の修正</h2>
        <form method="POST" action="../src/php/myedit_update.php" enctype="multipart/form-data">

            <div class="contents">
            <p>タイトル
                <div class="ui input text_input">
                <input type="text" name="title" placeholder="64文字以内で入力してください" value=<?=$row["title"]?>>
                </div>
            </p>
            </div>


            <div class="contents">
            <p>言語
            <div class="select">
                <select name="lang">
                    <option value ="<?=$row["lang"]?>" selected><?=$row["lang"]?>(変更なし)</option>
                    <?=$view?>
                </select>
            </div>
            </p>
            </div>

            <div class="contents">
            <p>おすすめ内容
                <textarea name="cont" rows="4" clos="50"><?=$row["cont"]?></textarea>
            </p>
            </div>

            <div class="contents_fix">
            <div class="contents">
            <p>URL
                <div class="ui input text_input">
                <input type="url" name="url" value=<?=$row["url"]?>>
                </div>
            </p>
                </div>

            <div class="contents">
            <p>有料・無料
            <div class="select">
                <select name="cost">
                    <option value ="<?=$row["cost"]?>" selected><?=$row["cost"]?>(変更なし)</option>
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
                    <option value ="<?=$row["post"]?>" selected><?=$row["post"]?>(変更なし)</option>
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
                    <option value ="<?=$row["star"]?>" selected><?=$row["star"]?>(変更なし)</option>
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
            <p>添付ファイル
                <input type="file" accept="image/*, .pdf, .jpg, .jpeg, .png" name="upfile" value=<?=$row["fname"]?>>
            </p>
            <p class="input_text">現在の添付ファイルを変更する場合は、改めて選択願います。</p>
            <p class="input_text">未選択の場合は、現在の添付ファイルがそのまま維持されます。</p>
            </div>

            <input class="cost_submit ui primary button" type="submit" value="更新" style="margin-top: 16px;">
        </form>
    </div>


        <!-- <form enctype="multipart/form-data" method="POST" action="update.php">
            <div class="jumbotron">
                <fieldset>
                    <legend></legend>
                    <div id="polaroid">
                        <img id="preview" src="<?=$row["file_path"]?>">
                        <label><textArea class="textarea" placeholder="コメント(50字以内)" name="comment" rows="3" cols="35"><?=$row["comment"]?></textArea></label><br>
                    </div>
                    <div class="container">
                        <input class="submit" type="submit" value="送信">
                    </div>
                </fieldset>
            </div>
        </form> -->

        <!-- Main[End] -->
  <footer>
    <div class="footer">
      <p>copyright ©️ GEEKBOOK <br> For G's Academy</p>
    </div>
  </footer>
    </body>
</html>
