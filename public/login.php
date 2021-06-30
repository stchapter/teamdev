<!-- <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body> -->


<?php

include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");

// SESSION
session_start();

$err = $_SESSION;
// 認証エラーメッセージ取得
// if (count($emess) > 0) {
//   $emess=$_SESSION["emess"];
//   return;
// }
session_destroy();

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
  <link rel="stylesheet" href="../src/css/login.css">
  <title>GEEKBOOK</title>
</head>
<body>

<div class="container">


  <div class="header_logo">
    <img src="../img/GEEKBOOK_Logo.png">
  </div>

<p class="login_p">GEEKBOOKアカウントにログイン</p>
<form name="login" action="../src/php/login_act.php" method="post">

  <div>
    <!-- <lable for="mail">メールアドレス</label> -->
    <div class="ui left icon input">
      <input type="text" name="mail" placeholder="メールアドレス">
      <i class="envelope icon"></i>
    </div>
  </div>

  <div>
    <!-- <lable for="pw">パスワード</label> -->
    <div class="ui left icon input log">
      <input type="password" name="pw" class="" placeholder="パスワード">
      <i class="key icon"></i>
    </div>
  </div>


  <div>
     <?php if(isset($err['emess'])): ?>
          <p><?php echo $err['emess']; ?></p>
        <?php endif; ?>
  </div>

  <button
  type="submit"
  class="cost_submit ui primary button"
  style="margin: 20px;"
  >ログイン</button>

</form>

<div>未登録の方は<a href="entry.php"> こちら</a></div>
<div>パスワードを忘れた方は<a href="password_reset.php">こちら</a></div>
</div>


</body>
</html>

<?php
include("./instance/footer.php");
?>
