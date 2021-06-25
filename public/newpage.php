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


include("./instance/header.php");
?>

<style>
p.error{
    margin:0;
    color:red;
    font-weight:bold;
    margin-bottom:1em;
}
</style>

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
