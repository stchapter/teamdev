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

// DBよりパラメーターを取得
$camp_list=camp_list();
$course_list=course_list();
$kw_c=kw_c();
?>

  <form method="POST" action="entry_chk.php">

    <div>
      <lable for="kw">認証コード</label>
      <small>学校発行の認証コード入力</small>
      <input type="password" name="kw" class="" id="kw">
    </div>

    <div>
      <lable for="name">お名前</label>
      <input type="text" name="name" class="" id="name">
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
      <input type="number" name="cls" class="" id="cls">
    </div>

    <div>
      <lable for="student">学籍番号</label>
      <input type="number" name="student" class="" id="student">
    </div>

    <div>
      <lable for="mail">メールアドレス</label>
      <input type="text" name="mail"class="" id="mail">
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

    <input type="submit" value="登録" class="">
  </form>

</body>
</html>
