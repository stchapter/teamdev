<?php
  session_start();
  require_once('../src/php/funcs.php');
  header('Content-type: text/html; charset=utf-8');
  //URLからパラメータ取得
  $url_pass = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
  //CSRF
  $_SESSION['token'] = get_csrf_token();
  //ユーザー正式登録
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //10分前の時刻を取得
    $datetime = new DateTime('- 10 min');
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM user_table WHERE temp_pass = ? AND temp_limit_time >= ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
    $stmt->bindValue(2, $datetime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //URLが不正か期限切れ
    if (empty($row)) {
      $_SESSION['error_status'] = 4;
      redirect_to_password_reset();
      exit();
    }
    $_SESSION['mail'] = $row['mail'];
    $_SESSION['url_pass'] = $url_pass; // エラー制御のため格納
  } catch (PDOException $e) {
    die($e->getMessage());
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
  <link rel="stylesheet" href="../src/css/entrycomp.css">
  <link rel="icon" href="../img/favicon.ico">
  <script src="passwordchecker.js" type="text/javascript"></script>
  <title>GEEKBOOK</title>
  <script type="text/javascript">
    /*
    * 登録前チェック
    */
    function confirmMessage() {
      var pass = document.getElementById("password").value;
      var conf = document.getElementById("confirm_password").value;
      //必須チェック
      if((pass == "") || (conf == "")) {
        alert("必須項目が入力されていません。");
        return false;
      }
      //パスワードチェック
      if (pass != conf) {
          alert("パスワードが一致していません。");
          return false;
      }
      if (passwordLevel < 3) {
        return confirm("パスワード強度が弱いですがよいですか？");
      }
      return true;
    }
  </script>
</head>
<>
  <div class="container_whole">
    <div div class="text_comp" style="width:300px;">パスワード変更</div>
    <div class="pw_info2">新しいパスワードを入力してください</div>
    <?php
      if ($_SESSION['error_status'] == 1) {
        echo '<h2 style="color:red;">パスワードが一致しません。</h2>';
      }
    ?>
    <form action="password_reset_submit.php" method="post" onsubmit="return confirmMessage();">
      <div class="submit_container">
        <div class="ui left icon input">
          <input  type="password" name="password" id="password" placeholder="パスワード" onkeyup="setMessage(this.value);">
          <i class="envelope icon"></i>
          <div id="pass_message"></div>
        </div>
        <div class="ui left icon input">
          <input type="password" name="confirm_password" id="confirm_password" placeholder="パスワード（確認）" onkeyup="setConfirmMessage(this.value);">
          <i class="envelope icon"></i>
          <div id="pass_message"></div>
        </div>
      </div>
      <div>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token']  , ENT_QUOTES, "UTF-8") ?>">
        <input type="submit" class="ui big blue button" value="更新">
        <input type="button" class="ui big button" value="戻る" onclick="document.location.href='login.php';">
      </div>
    </form>
  </div>

<?php
include("./instance/footer.php");
?>
</body>
</html>
