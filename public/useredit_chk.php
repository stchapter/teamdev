
<?php

include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");
include("../src/php/valid.php");

session_start();

// 認証下
sschk();


$id = $_SESSION["id"];


// DBより各種パラメーターを取得
$camp_list=camp_list();
$course_list=course_list();

// POSTデータ取得
$name = $_POST["name"];
$camp = $_POST["camp"];
$course = $_POST["course"];
$cls = $_POST["cls"];
$student = $_POST["student"];
$mail = $_POST["mail"];
$intro = $_POST["intro"];
$fb = $_POST["fb"];
$tw = $_POST["tw"];
$life = $_POST["life"];
$pw = $_POST['pw'];
$pw_c = $_POST['pw_c'];


// エラー変数の初期化
$err = [];
$cerr =[];

// バリーテーション関数へ、エラーがあったらエラー内容を配列に戻す。formのnmaeを入れる。
$err[1] = valc(name,1,24);
$err[4] = valc(cls,1,3);
$err[5] = valc(student,1,3);
$err[7] = passvc(pw);
$err[8] = inputconf(pw,pw_c);
$err[9] =  passvc2(fb);
$err[10] =  passvc2(tw);


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
  $doc2 ='<div class="select">'.$name.'</div><input type="hidden" class="" name="name" value="'.h($name).'">';
  $doc3 =$camp.'<input type="hidden" class="" name="camp" value="'.h($camp).'">';
  $doc4 =$course.'<input type="hidden" class="" name="course" value="'.h($course).'">';
  $doc5 ='<div class="select">'.$cls.'</div><input type="hidden" class="" name="cls" value="'.h($cls).'">';
  $doc6 ='<div class="select">'.$student.'</div><input type="hidden" class="" name="student" value="'.h($student).'">';
  $doc7 ='<div class="select">'.$mail.'</div><input type="hidden" class="" name="mail" value="'.h($mail).'">';
  $doc8 ='<div class="select">*******</div><input type="hidden"  class="" name="pw" value="'.h($pw).'">';
  $doc9 ='<div class="select">*******</div>';
  $doc10 ='<input type="submit" name="entry" value="登録" class="ui primary button" style="margin-top: 30px;">';

  $doc11 ='<div class="select">'.$intro.'</div><input type="hidden" class="m_text" name="intro" value="'.h($intro).'">';
  $doc12 ='<div class="select">'.$fb.'</div><input type="hidden" class="" name="fb" value="'.h($fb).'">';
  $doc13 ='<div class="select">'.$tw.'</div><input type="hidden" class="" name="tw" value="'.h($tw).'">';

  if ($life==1) {
    $lifevalue ='<div class="select">退会</div>';
  }else {
    $lifevalue ='<div class="select">利用中</div>';
  }
  $doc14 =$lifevalue.'<input type="hidden" class="" name="life" value="'.h($life).'">';

  $doc15 ='<img src="../prof/'.$ipass.'">';


}else{
  $doc0 ="登録修正";
  $doc1 ='<input type="password" class="" name="kw">';
  $doc2 ='<div class="ui input text_input"><input type="text" class="" name="name" value="'.h($name).'"></div>';
  $doc5 ='<div class="ui input text_input"><input type="number" class="" name="cls" value="'.h($cls).'"></div>';
  $doc6 ='<div class="ui input text_input"><input type="number" class="" name="student" value="'.h($student).'"></div>';
  $doc7 ='<div class="ui input text_input"><input type="text" class="" name="mail" value="'.h($mail).'"></div><br>';
  $doc8 ='<div class="ui input text_input"><input type="password"  class="" name="pw" value=""></div><br>';
  $doc9 ='<div class="ui input text_input"><input type="password"  class="" name="pw_c" value=""></div><br>';
  $doc10 ='';

  $doc11 ='<textarea name="intro" class="m_text" id="intro" >'.h($intro).'</textarea>';
  $doc12 ='<div class="ui input text_input"><input type="text" name="fb" class="" id="fb" value="'.h($fb).'"></div>';
  $doc13 ='<div class="ui input text_input"><input type="text" name="tw" class="" id="tw" value="'.h($tw).'"></div>';
  $doc14 ='<br><small>退会希望者はチェックしてください</small><input type="checkbox" name="life" value="1">';
}


//DBへの登録処理を分ける。formのnameの値がtrueか調べて押されたボタンを判別
if(isset($_POST['entry'])) {
  // echo "はっか";

  $hash_pass = password_hash($pw, PASSWORD_DEFAULT);

  $pdo = db_conn();

  $sql = "UPDATE user_table SET
        name = :name,
        camp = :camp,
        course = :course,
        cls = :cls,
        student = :student,
        intro = :intro,
        fb = :fb,
        tw = :tw,
        life =:life,
        pw = :pw
        WHERE id = $id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':name', $name, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':camp', $camp, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':course', $course, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':cls', $cls, PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':student', $student, PDO::PARAM_INT);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':intro', $intro, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':fb', $fb, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':tw', $tw, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':life', $life, PDO::PARAM_INT);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':pw', $hash_pass, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行

//データ登録処理後
if($status==false){
  sql_error($stmt);
}else{

  redirect("main.php");
}
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
   <!-- ↓　ここを変更する -->
  <link rel="stylesheet" href="../src/css/main.css">
  <link rel="stylesheet" href="../src/css/alart.css">
  <title>GEEKBOOK</title>
</head>
<body>
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
          <button class="ui button" onclick="location.href='main.php'">TOPへ</button>
          <button class="ui button" onclick="location.href='useredit.php'">マイプロフィール</button>
          <button class="ui button" onclick="location.href='newpage.php'">新規投稿</button>
          <button class="ui button" onclick="location.href='mypage.php'">自分の投稿</button>
          <button class="ui button" onclick="location.href='bookmark.php'">Bookmark</button>
          <?php if($_SESSION["kanri"]==1): ?>
          <button class="ui button" onclick="location.href='superuser.php'">Admin</button>
          <div class="header_button_Rev" style="margin-left:50%;">
            <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
          </div>
          <?php else: ?>
            <div class="header_button_Rev" style="margin-left:70%;">
              <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>

  <div class="m_container">

    <h2 class="editor_title"><?php echo $doc0; ?></h2>

    <form method="POST" action="useredit_chk.php" enctype="multipart/form-data">

    <div class="contents">
      <label for="name">お名前</label><br/>
          <?php echo $doc2; ?>
          <?php echo $err[1]; ?>
    </div>


  <div class="contents_fix">
  <div class="contents">
      <label for="camp">校舎</label>
          <?php if (count($cerr) === 0 ):?>
            <div class="ui input text_input">
                  <?php echo $doc3; ?>
            </div>
          <?php else : ?>
            <div class="select">
              <select type="text" name="camp" class="" id="camp" value="<?php h($camp);?>">
                <?php foreach($camp_list as $value): ?>
                  <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php endif; ?>
  </div>

  <div class="contents">
      <label for="course">受講コース</label></br>
          <?php if (count($cerr) === 0 ):?>
            <div class="ui input text_input">
                <?php echo $doc4; ?>
            </div>
          <?php else : ?>
            <div class="select">
              <select type="text" name="course" class="" id="course" value="'.h($course).'">
                <?php foreach($course_list as $value): ?>
                  <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php endif; ?>
  </div>
  </div>

  <div class="contents_fix">

    <div class="contents">
      <label for="class">学期</label><br/>

          <?php echo $doc5; ?>

          <?php echo $err[4]; ?>
    </div>

    <div class="contents">
      <label for="student">学籍番号</label><br/>

          <?php echo $doc6; ?>

          <?php echo $err[5]; ?>
    </div>
  </div>




    <div class="contents">
      <label for="intro">自己紹介</label><br/>
          <?php echo $doc11; ?>
    </div>




  <div class="contents_fix">
    <div class="contents">
      <label style="font-size: 16px;" for="fb">facebook</label>
     　FacebookのIDのみ入力<br/>

              <?php echo $doc12; ?>

          <?php echo $err[9]; ?>
    </div>

    <div class="contents">
    <label style="font-size: 16px;" for="tw">twitter</label>
      　例「@gsacademy」<br/>

              <?php echo $doc13; ?>

          <?php echo $err[10]; ?>
    </div>

  </div>

    <div class="contents_fix">
      <div class="contents">
        <label style="font-size: 14px;" for="pw">パスワード</label>
            <small>4桁以上8桁以下の英数字</small><br/>
            <?php echo $doc8; ?>
            <?php echo $err[7]; ?>
      </div>

      <div class="contents">
        <label style="font-size: 14px;" for="cpw">パスワード確認入力</label><br/>
            <?php echo $doc9; ?>
            <?php echo $err[8]; ?>
      </div>
    </div>



    <div class="contents_fix">
      <div class="contents" style="font-size: 18px;">
          <?php echo $doc14; ?>
      </div>
    </div>

    <div class="contents_fix">
      <br><input type="submit" name="edit" value="修正" class="ui large primary button" style="margin-top: 70px; margin-bottom: 150px;">
      <?php echo $doc10; ?>
    </div>


  </form>


</div>



    </div>
    </div>
    </div>
    </div>
  </div>

  <footer>
    <div class="footer">
      <p>copyright ©️ GEEKBOOK <br> For G's Academy</p>
    </div>
  </footer>

</body>
</html>
