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


// fileupload用の関数
function fileUpload($fname,$path){
    if (isset($_FILES[$fname] ) && $_FILES[$fname]["error"] ==0 ) {
        //ファイル名取得
        $file_name = $_FILES[$fname]["name"];
        //一時保存場所取得
        $tmp_path  = $_FILES[$fname]["tmp_name"];
        //拡張子取得
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        //ユニークファイル名作成
        $file_name = date("YmdHis").md5(session_id()) . "." . $extension;
        // FileUpload [--Start--]
        $file_dir_path = $path.$file_name;
        if ( is_uploaded_file( $tmp_path ) ) {
            if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
                chmod( $file_dir_path, 0644 );
                return $file_name; //成功時：ファイル名を返す
            } else {
                return 1; //失敗時：ファイル移動に失敗
            }
        }
    }else{
         return 2; //失敗時：ファイル取得エラー
    }
}

