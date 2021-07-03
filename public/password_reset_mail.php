<?php
  session_start();
  require_once('../src/php/funcs.php');
  header('Content-type: text/html; charset=utf-8');
  $mail = $_POST['mail'];
  $token = $_POST['token'];
  // CSRFチェック
  if ($_SESSION['token'] != $token) {
    $_SESSION['error_status'] = 3;
    redirect_to_password_reset();
    exit();
  }
  try {
    // DB接続
    $pdo = new PDO(DNS, USER_NAME, PASSWORD, get_pdo_options());
    //プレースホルダで SQL 作成
    $sql = "SELECT * FROM user_table WHERE mail = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $mail, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // IDが存在しない
    if (empty($row)) {
      $_SESSION['error_status'] = 2;
      redirect_to_password_reset();
      exit();
    }
    //リセット処理
    $mail = h($row['mail']);
    //URLパスワードを作成
    $url_pass = get_url_password();
    //プレースホルダで SQL 作成
    $sql = "UPDATE user_table SET reset = 1, temp_pass = ?, temp_limit_time = ? WHERE mail = ?;";
    $stmt = $pdo->prepare($sql);
    // トランザクションの開始
    $pdo->beginTransaction();
    try {
      $stmt->bindValue(1, $url_pass, PDO::PARAM_STR);
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
  //メールヘッダーインジェクション対策
  $msg = '以下のURLからパスワードのリセットを行ってください。' . PHP_EOL;
  $msg .=  'アドレスの有効時間は１０分間です。' . PHP_EOL . PHP_EOL;
  $msg .= 'https://' . SERVER . '/password_reset_url.php?' . $url_pass;
  mb_send_mail($mail, 'パスワードのリセット', $msg, ' From :  ' . SENDER_EMAIL);
?>
<!DOCTYPE html>
<head>
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
<html lang="ja">
  <body>
    <div class="container_whole">
      <div class="text_comp">メールを送信しました</div>
      <div class="pw_info">メール記載のURLより、お手続き願います</div>
      <br><br>
      <a href="login.php" class="ui blue button">ログイン画面に戻る</a>
    </div>

<?php
include("./instance/footer.php");
?>
</body>
</html>
