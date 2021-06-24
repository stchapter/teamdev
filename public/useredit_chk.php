<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

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
$err[1] = valc(name,1,12);
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
    $doc2 =$name.'<input type="hidden" class="" name="name" value="'.h($name).'">';
    $doc3 =$camp.'<input type="hidden" class="" name="camp" value="'.h($camp).'">';
    $doc4 =$course.'<input type="hidden" class="" name="course" value="'.h($course).'">';
    $doc5 =$cls.'<input type="hidden" class="" name="cls" value="'.h($cls).'">';
    $doc6 =$student.'<input type="hidden" class="" name="student" value="'.h($student).'">';
    $doc7 =$mail.'<input type="hidden" class="" name="mail" value="'.h($mail).'">';
    $doc8 ='*******<input type="hidden"  class="" name="pw" value="'.h($pw).'">';
    $doc9 ='*******';
    $doc10 ='<input type="submit" name="entry" value="登録" class="">';

    $doc11 =$intro.'<input type="hidden" class="" name="intro" value="'.h($intro).'">';
    $doc12 =$fb.'<input type="hidden" class="" name="fb" value="'.h($fb).'">';
    $doc13 =$tw.'<input type="hidden" class="" name="tw" value="'.h($tw).'">';

    if ($life==1) {
      $lifevalue ="退会";
    }else {
      $lifevalue ="利用中";
    }
    $doc14 =$lifevalue.'<input type="hidden" class="" name="life" value="'.h($life).'">';

    $doc15 ='<img src="../prof/'.$ipass.'">';


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

    $doc11 ='<textarea name="intro" class="" id="intro" >'.h($intro).'</textarea>';
    $doc12 ='<input type="text" name="fb" class="" id="fb" value="'.h($fb).'">';
    $doc13 ='<input type="text" name="tw" class="" id="tw" value="'.h($tw).'">';
    $doc14 ='<small>退会希望者はチェックしてください</small><input type="checkbox" name="life" value="1">';
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



  <legend><?php echo $doc0; ?></legend>

  <form method="POST" action="useredit_chk.php" enctype="multipart/form-data">


    <div>
      <lable for="name">お名前</label>
          <?php echo $doc2; ?>
          <?php echo $err[1]; ?>
    </div>

    <div>
      <lable for="camp">校舎</label>
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

    <div>
      <lable for="course">受講コース</label>
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

    <div>
      <lable for="class">学期</label>
          <?php echo $doc5; ?>
          <?php echo $err[4]; ?>
    </div>

    <div>
      <lable for="student">学籍番号</label>
          <?php echo $doc6; ?>
          <?php echo $err[5]; ?>
    </div>




    <div>
      <lable for="intro">自己紹介</label>
          <?php echo $doc11; ?>
    </div>


    <div>
      <lable for="fb">facebook</label>
          <small>FacebookのIDのみ入力</samll>
          <?php echo $doc12; ?>
          <?php echo $err[9]; ?>
    </div>

    <div>
      <lable for="tw">twitter</label>
          <small>例「@acountrei」</samll>
          <?php echo $doc13; ?>
          <?php echo $err[10]; ?>
    </div>

    <div>
      <lable for="life">コンディション</label>
          <?php echo $doc14; ?>
    </div>

    <div>
      <lable for="pw">パスワード</label>
          <?php echo $doc8; ?>
          <?php echo $err[7]; ?>
    </div>

    <div>
      <lable for="cpw">パスワード確認</label>
          <?php echo $doc9; ?>
          <?php echo $err[8]; ?>
    </div>



    <input type="submit" name="edit" value="修正" class="">
    <?php echo $doc10; ?>
  </form>



</body>
</html>
