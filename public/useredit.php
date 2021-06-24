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

session_start();

// 認証下
sschk();

$id = $_SESSION["id"];

// DB接続
$pdo = db_conn();

$sql = "SELECT * FROM user_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

//SQLエラー
if($status==false){
    sql_error($stmt);
}

//抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得

// DBより各種パラメーターを取得
$camp_list=camp_list();
$course_list=course_list();

?>

<div>
  <form method="POST" action="../src/php/profup.php" enctype="multipart/form-data" >
  <lable for="ipass">プロフィール画像</label>
  <input type="file" name="ipass" id="ipass">
  <input type="submit" name="edit" value="画像を更新" class="">
  </form>
</div>

<div>
<img src="../prof/<?php echo h($val[ipass]); ?>">
</div>



  <form method="POST" action="useredit_chk.php" enctype="multipart/form-data" >

    <div>
      <lable for="name">お名前</label>
      <input type="text" name="name" class="" id="name" value="<?php echo h($val[name]); ?>">
    </div>

    <div>
      <lable for="camp">校舎</label>
        <select type="text" name="camp" class="" id="camp">
          <?php foreach($camp_list as $value): ?>
            <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
          <?php endforeach; ?>
        </select>
    </div>

    <div>
        <lable for="course">受講コース</label>
          <select type="text" name="course" class="" id="course">
            <?php foreach($course_list as $value): ?>
              <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
            <?php endforeach; ?>
          </select>
    </div>

    <div>
      <lable for="class">学期</label>
      <input type="number" name="cls" class="" id="cls" value="<?php echo h($val[cls]); ?>" >
    </div>

    <div>
      <lable for="student">学籍番号</label>
      <input type="number" name="student" class="" id="student" value="<?php echo h($val[student]); ?>">
    </div>


    <div>
      <lable for="intro">自己紹介</label>
      <textarea name="intro" class="" id="intro" ><?php echo h($val[intro]); ?></textarea>
    </div>



    <div>
      <lable for="fb">facebook</label>
      <small>FacebookのIDのみ入力</samll>
      <input type="text" name="fb" class="" id="fb" value="<?php echo h($val[fb]); ?>">
    </div>

    <div>
      <lable for="tw">twitter</label>
      <small>例「@acountrei」</samll>
      <input type="text" name="tw" class="" id="tw" value="<?php echo h($val[tw]); ?>">
    </div>


    <div>
      <lable for="life">退会希望の場合はチェックをしてください</label>
      <input type="checkbox" name="life" value="1">
    </div>

    <div>
      <lable for="pw">パスワード</label>
      <small>4桁以上8桁以下の英数字</small>
      <input type="password" name="pw"class="" id="pw">
    </div>

    <div>
      <lable for="cpw">パスワード確認入力</label>
      <input type="password" name="pw_c" class="" id="pw_c">
    </div>


    <input type="submit" value="更新" class="">

  </form>





</body>
</html>
