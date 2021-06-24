<?php
//session check//
// session_start();
// sschk();
include("../src/php/funcs.php");
include("../src/php/db.php");


// $id = $_GET["id"];
$id = 20;          //test用にidを20に固定
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
        <title>投稿の修正</title>
    </head>
    <body>
        <form method="POST" action="../src/php/myedit_update.php" enctype="multipart/form-data">
            <p>言語:
                <select name="lang">
                    <option value ="<?=$row["lang"]?>" selected><?=$row["lang"]?>(変更なし)</option>
                    <?=$view?>
                </select>
            </p>
            <p>タイトル(機能):
                <input type="text" name="title" placeholder="64文字以内で入力してください" value=<?=$row["title"]?>>
            </p>
            <p>おすすめ内容:
                <textarea name="cont" rows="4" clos="50"><?=$row["cont"]?></textarea>
            </p>
            <p>URL
                <input type="url" name="url" value=<?=$row["url"]?>>
            </p>
            <p>有料・無料
                <select name="cost">
                    <option value ="<?=$row["cost"]?>" selected><?=$row["cost"]?>(変更なし)</option>
                    <option value ="有料">有料</option>
                    <option value ="無料">無料</option>
                </select>
            </p>
            <p>投稿
                <select name="post">
                    <option value ="<?=$row["post"]?>" selected><?=$row["post"]?>(変更なし)</option>
                    <option value ="投稿">投稿</option>
                    <option value ="下書き保存">下書き保存</option>
                </select>
            </p>
            <p>おすすめ度
                <select name="star">
                    <option value ="<?=$row["star"]?>" selected><?=$row["star"]?>(変更なし)</option>
                    <option value ="★★★★★">★★★★★</option>
                    <option value ="★★★★☆">★★★★☆</option>
                    <option value ="★★★☆☆">★★★☆☆</option>
                    <option value ="★★☆☆☆">★★☆☆☆</option>
                    <option value ="★☆☆☆☆">★☆☆☆☆</option>
                </select>
            </p>
            <p>添付ファイル
                <input type="file" accept="image/*, .pdf, .jpg, .jpeg, .png" name="upfile" value=<?=$row["fname"]?>>
            </p>
            <p>現在の添付ファイルを変更する場合は、改めて選択願います。</p>
            <p>未選択の場合は、現在の添付ファイルがそのまま維持されます。</p>
            <input class="cost_submit" type="submit" value="投稿">
        </form>


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

    </body>
</html>


