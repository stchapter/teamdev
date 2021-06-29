<?php
  require_once('../src/php/funcs.php');
  session_start();
  header('Content-type: text/html; charset=utf-8');
  //CSRF トークン
  $_SESSION['token']  = get_csrf_token();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
    <link rel="stylesheet" href="../src/css/entrycomp.css">
    <link rel="icon" href="../img/favicon.ico">
    <title>GEEKBOOK</title>
    <script type="text/javascript">
        /*
        * 登録前チェック
        */
        function conrimMessage() {
          var mail = document.getElementById("mail").value;
        //必須チェック
          if(mail == "") {
            alert("必須項目が入力されていません。");
            return false;
          }
          return true;
        }
    </script>
  </head>
  <body>
    <div class="container_whole">
          <div class="text_comp" style="width:350px;">パスワードリセット</div>
          <div class="pw_info">登録メールアドレスを入力願います</div>
      <?php
        if ($_SESSION['error_status'] == 1) {
          echo "<h2 style='color:red;'>パスワードをリセットしてください。</h2>";
        }
        if ($_SESSION['error_status'] == 2) {
          echo "<h2 style='color:red;'>入力内容に誤りがあります。</h2>";
        }
        if ($_SESSION['error_status'] == 3) {
          echo "<h2 style='color:red;'>不正なリクエストです。</h2>";
        }
        if ($_SESSION['error_status'] == 4) {
          echo '<h2 style="color:red;">タイムアウトか不正なURLです。</h2>';
        }
        //エラー情報のリセット
        $_SESSION['error_status'] = 0;
      ?>
      <form action="password_reset_mail.php" method="post" onsubmit="return conrimMessage();">
        <div class="ui left icon input">
          <input class="mail_box" type="text" name="mail" placeholder="メールアドレス">
          <i class="envelope icon"></i>
        </div>    
        <div class="pw_reset_container">
          <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']  , ENT_QUOTES, "UTF-8") ?>">
          <input type="submit" class="ui big blue button" value="登録">
          <input type="button" class="ui big button" value="戻る" onclick="document.location.href='login.php';">
        </div>
        </form>
      </div>
  </body>
</html>

<?php
  include("./instance/footer.php");
?>

