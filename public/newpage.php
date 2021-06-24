<?php
//session check//
// session_start();
// sschk();
include("../src/php/funcs.php");
include("../src/php/db.php");


/*-------------------------------------------------------------------------
DB接続（langのプルダウン作成）
-------------------------------------------------------------------------*/
//1.  DB接続します
$pdo = db_conn();
// $uid = $_SESSION["uid"];

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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <head><link rel="icon" type="image/x-icon" href="img/favicon.svg"></head>
        <title>newpage</title>
    </head>
    <body>
        <p>新規投稿</p>
        <form method="POST" action="../src/php/newpage_insert.php" enctype="multipart/form-data">
            <p>言語:
                <select name="lang">
                    <option value = "選択してください" placeholder="選択してください"></option>
                    <?=$view?>
                </select>
            </p>
            <p>タイトル(機能):
                <input type="text" name="title" placeholder="64文字以内で入力してください">
            </p>
            <p>おすすめ内容:
                <textarea name="cont" rows="4" clos="50"></textarea>
            </p>
            <p>URL
                <input type="url" name="url">
            </p>
            <p>有料・無料
                <select name="cost">
                    <option value ="有料">有料</option>
                    <option value ="無料">無料</option>
                </select>
            </p>
            <p>投稿
                <select name="post">
                    <option value ="投稿">投稿</option>
                    <option value ="下書き保存">下書き保存</option>
                </select>
            </p>
            <p>おすすめ度
                <select name="star">
                    <option value ="★★★★★">★★★★★</option>
                    <option value ="★★★★☆">★★★★☆</option>
                    <option value ="★★★☆☆">★★★☆☆</option>
                    <option value ="★★☆☆☆">★★☆☆☆</option>
                    <option value ="★☆☆☆☆">★☆☆☆☆</option>
                </select>
            </p>
            <p>添付ファイル
                <input type="file" accept="image/*, .pdf, .jpg, .jpeg, .png" name="upfile">
            </p>
            <input class="cost_submit" type="submit" value="投稿">    
        </form>
    </body>
</html>
