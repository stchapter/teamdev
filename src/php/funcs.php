<?php
// HTMLでのエスケープ処理をする関数
// 引数には変数も配列も両方受け取って
// サニタイジングできる関数として定義
function h($var)
{
  if (is_array($var)) {
    // 配列を受け取った時の処理
    return array_map('h', $var);
    // array_map:配列内の各部屋に
    // 第1引数で指定した関数を実行する
  } else {
    // 配列じゃない時の処理
    return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  }
}

// デバッグ用関数
function v($val)
{
  echo '<pre>';
  var_dump($val);
  echo '</pre>';
}



//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo(); //$stmtの中にエラーLOGが残ってるので引数で貰う
    exit("SQLError:".$error[2]);
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}



// SessionChecklセッションをとおってないと表示しない。
function sschk(){
  //LOGINチェック → funcs.phpへ関数化しましょう！or以降、ログインしたときのidと現在のid比べる
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    exit("Login Error ログインしてないよ！");
  }else{
    session_regenerate_id(true);//ページごとにセッションidを入れ替えます。同じidだとハッキングリスクがあるため。
    $_SESSION["chk_ssid"] = session_id();//新しいセッションに入れ替える
  }
}


