<?php
  session_start();
  require_once('../src/php/funcs.php');
  header('Content-type: text/html; charset=utf-8');
  $mail = $_SESSION['mail'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $token = $_POST['token'];

  //CSRF エラー
  if ($token != $_SESSION['token']) {
     $_SESSION['error_status'] = 2;
     redirect_to_login();
     exit();
  }
  //パスワード不一致
  if ($password != $confirm_password) {
    $_SESSION['error_status'] = 1;
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: password_reset_url.php?' . $_SESSION['url_pass']);
    exit();
  }
  //パスワード更新
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM user_table WHERE mail = ? AND reset = 1;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $mail, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row)) {
      $_SESSION['error_status'] = 3;
      redirect_to_password_reset();
      exit();
    }
    $mail = h($row['mail']);
    //プレースホルダで SQL 作成
    $sql = "UPDATE user_table SET reset = 0, pw = ?, last_change_pass_time = ? WHERE mail = ?;";
    $stmt = $pdo->prepare($sql);
    // パスワードハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // トランザクションの開始
    $pdo->beginTransaction();
    try {
      $stmt->bindValue(1, $hashed_password, PDO::PARAM_STR);
      $stmt->bindValue(2, date('Y-m-d H:i:s'), PDO::PARAM_STR);
      $stmt->bindValue(3, $mail, PDO::PARAM_STR);
      $stmt->execute();
      // コミット
      $pdo->commit();
    } catch (PDOException $e) {
      // ロールバック
      $pdo->rollBack();
      throw $e;
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
  //メール送信
  $msg = 'パスワードがリセットされました。' ;
  mb_send_mail($mail, 'パスワードのリセット完了', $msg, ' From :  ' . SENDER_EMAIL);
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
  </head>
  <body>
    <div class="container_whole">
      <div class="text_comp">リセット完了</div>
      <div class="pw_info">パスワードのリセットが終了しました。<br>
        ログイン画面からログインしてください。
      </div>
      <a href="login.php" class="ui blue button">ログイン画面に戻る</a>
    </div>

<?php
include("./instance/footer.php");
?>
</body>
</html>
