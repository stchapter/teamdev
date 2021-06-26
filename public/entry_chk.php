<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/login.css">
  <title>GEEKBOOK</title>
</head>
<body>


<?php
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");
include("../src/php/valid.php");

// DBより各種パラメーターを取得
$camp_list=camp_list();
$course_list=course_list();
$kw_c=kw_c();


// POSTデータ取得
$kw = $_POST["kw"];
$name = $_POST["name"];
$camp = $_POST["camp"];
$course = $_POST["course"];
$cls = $_POST["cls"];
$student = $_POST["student"];
$mail = $_POST["mail"];
$pw = $_POST['pw'];
$pw_c = $_POST['pw_c'];

// エラー変数の初期化
$err = [];
$cerr =[];

// v("test:".$kw_c[0]);

// バリーテーション関数へ、エラーがあったらエラー内容を配列に戻す。formのnmaeを入れる。
if ($kw !== $kw_c[0]) {
  $err[0] = "認証コード違います";
}

$err[1] = valc(name,1,24);
$err[4] = valc(cls,1,3);
$err[5] = valc(student,1,3);
$err[6] = mailvc(mail);
$err[7] = passvc(pw);
$err[8] = inputconf(pw,pw_c);
$err[9] = mail_double_check(mail);

// nullがはいり下記の処理でカウントされてしまうため
// array_fuilterでnullを排除
$cerr = array_filter($err);

// v(count($err));
// 配列の中味の個数を数えて、エラーが0ならば確認画面を写し違うならば編集画面
if (count($cerr) === 0 ) {
    // echo "はっか1";
    //表示させつつPOSTデータはhiddenで送信できるように
    $doc0 ="ご確認";
    $doc1 ='*******<input type="hidden" class="" name="kw" value="'.h($kw).'">';
    $doc2 =$name.'<input type="hidden" class="" name="name" value="'.h($name).'">';
    $doc3 =$camp.'<input type="hidden" class="" name="camp" value="'.h($camp).'">';
    $doc4 =$course.'<input type="hidden" class="" name="course" value="'.h($course).'">';
    $doc5 =$cls.'<input type="hidden" class="" name="cls" value="'.h($cls).'">';
    $doc6 =$student.'<input type="hidden" class="" name="student" value="'.h($student).'">';
    $doc7 =$mail.'<input type="hidden" class="" name="mail" value="'.h($mail).'">';
    $doc8 ='*******<input type="hidden"  class="" name="pw" value="'.h($pw).'">';
    $doc9 ='*******';
    $doc10 ='<input type="submit" name="entry" value="登録" class="ui primary button">';

}else{
    $doc0 ="登録修正";
    $doc1 ='<input type="password" class="" name="kw">';
    $doc2 ='<input type="text" class="" name="name" value="'.h($name).'">';
    $doc5 ='<input type="number" class="" name="cls" value="'.h($cls).'">';
    $doc6 ='<input type="number" class="" name="student" value="'.h($student).'">';
    $doc7 ='<input type="text" class="" name="mail" value="'.h($mail).'"><br>';
    $doc8 ='<input type="password"  class="" name="pw" value=""><br>';
    $doc9 ='<input type="password"  class="" name="pw_c" value=""><br>';
    $doc10 ='';
}


//DBへの登録処理を分ける。formのnameの値がtrueか調べて押されたボタンを判別
if(isset($_POST['entry'])) {
    echo "はっか";
    $hash_pass = password_hash($pw, PASSWORD_DEFAULT);

    $pdo = db_conn();
    $stmt = $pdo->prepare("INSERT INTO user_table(name,camp,course,cls,student,mail,pw,udate)VALUES(:name,:camp,:course,:cls,:student,:mail,:pw,sysdate())");

    $stmt->bindValue(':name', $name, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':camp', $camp, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':course', $course, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':cls', $cls, PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':student', $student, PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
    $stmt->bindValue(':pw', $hash_pass, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)

    $status = $stmt->execute(); //実行

    //データ登録処理後
    if($status==false){
      sql_error($stmt);
    }else{
      redirect("entry_comp.php");
    }
}

?>

<div class="e_container">

  <div class="">

  <legend><?php echo $doc0; ?></legend>

  <form method="POST" action="entry_chk.php">

    <div class="e_contents">
      <lable class="label" for="kw">認証コード　</label>
          <?php echo $doc1; ?>
          <?php echo $err[0]; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="name">お名前　</label>
          <?php echo $doc2; ?>
          <?php echo $err[1]; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="camp">校舎　</label>
        <?php if (count($cerr) === 0 ):?>
              <?php echo $doc3; ?>
        <?php else : ?>
                      <select type="text" name="camp" class="" id="camp" value="<?php h($camp);?>">
              <?php foreach($camp_list as $value): ?>
                <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
              <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="course">受講コース　</label>
        <?php if (count($cerr) === 0 ):?>
              <?php echo $doc4; ?>
        <?php else : ?>
            <select type="text" name="course" class="" id="course" value="'.h($course).'">
              <?php foreach($course_list as $value): ?>
                <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
              <?php endforeach; ?>
            </select>
        <?php endif; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="class">学期　</label>
          <?php echo $doc5; ?>
          <?php echo $err[4]; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="student">学籍番号　</label>
          <?php echo $doc6; ?>
          <?php echo $err[5]; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="mail">メールアドレス　</label>
          <?php echo $doc7; ?>
          <?php echo $err[9]; ?>
          <?php echo $err[6]; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="pw">パスワード　</label>
          <?php echo $doc8; ?>
          <?php echo $err[7]; ?>
    </div>

    <div class="e_contents">
      <lable class="label" for="cpw">パスワード確認　</label>
          <?php echo $doc9; ?>
          <?php echo $err[8]; ?>
    </div>

            <input type="hidden" name="camp_list" class="" value="$camp_list">
            <input type="hidden" name="course_list" class="" value="$course_list">
            <input type="hidden" name="kw_c" class="" value="$kw_c">

    <input type="submit" name="edit" value="修正" class="ui button">
    <?php echo $doc10; ?>
  </form>


  </div>
</div>

<?php
include("./instance/footer.php");
?>
