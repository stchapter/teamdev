
<?php

// バリテーション（文字数で制御）
function valc($postname,$min,$max){
  $val = filter_input(INPUT_POST, $postname);
  $n = strlen($val);

  if ($n == 0){
    $result = '<div class="alert alert-danger" role="alert">未入力です。';
    return $result;

  }elseif ($n > $max){
    $n = $n - $max;
    $result = $n."文字多いです。<br>";
    return $result;

  }elseif ($n < $min) {
    $n = $min - $n;
    $result = $n."文字少ないです。<br>";
    return $result;
  }
}


// メアド確認用
function mailvc($postname){
  $val = filter_input(INPUT_POST, $postname);

  if (!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD', $val)){
    return '<div class="alert alert-danger" role="alert">【メールアドレスが正しくありません】';
  }
}

// パスワード用(半角英数 4以上8以下)
function passvc($postname){
  $val = filter_input(INPUT_POST, $postname);

  if (!preg_match("/^[a-zA-Z0-9]{4,8}+$/", $val)){
    return '<div class="alert alert-danger" role="alert" style="margin-bottom: 30px;">【パスワードは4文字以上8文字以下の英数字でお願いします】';
  }
}

// パリーデーション(半角英数記号)
function passvc2($postname){
  $val = filter_input(INPUT_POST, $postname);

  if (!preg_match("/^[[:graph:]|[:space:]]+$/i", $val)){
    return '<div class="alert alert-danger" role="alert">【半角英数字記号の入力でお願いします】';
  }
}

// 入力確認用
function inputconf($postname,$postname2){
  $val1 = filter_input(INPUT_POST, $postname);
  $val2 = filter_input(INPUT_POST, $postname2);

  if ($val1 !== $val2){
    return '<div class="alert alert-danger" role="alert">【入力に差異があります】';
  }
}


// メアド二重チェック
function mail_double_check($postname) {

    $mail = filter_input(INPUT_POST, $postname);

  $pdo = db_conn();
  $stmt = $pdo->prepare("SELECT * FROM user_table WHERE  mail=:mail limit 1");
  $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if(empty($result)){
    }else{
      return "【そのメールアドレスは登録ずみです】";
    }

  }
}
