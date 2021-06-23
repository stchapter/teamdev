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

// SESSION
session_start();

// 認証エラーメッセージ取得
$emess=$_SESSION["emess"];
?>



<form name="login" action="../src/php/login_act.php" method="post">

  <div>
    <lable for="mail">メールアドレス</label>
    <input type="text" name="mail" class="" >
  </div>

  <div>
    <lable for="pw">パスワード</label>
    <input type="password" name="pw" class="">
  </div>


  <div>
    <?php echo $emess ?>
  </div>

  <button type="submit" class="">LOGIN</button>

</form>

<div>未登録の方は<a href="entry.php">こちら</a></div>



</body>
</html>
