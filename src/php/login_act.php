<?php

include("funcs.php");
include("db.php");
include("user_db_list.php");

//SESSION
session_start();

//POST値
$mail = $_POST["mail"];
$pw = $_POST["pw"];

echo $pw;



// DB接続
$pdo = db_conn();

$sql = "SELECT * FROM user_table WHERE mail=:mail";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$status = $stmt->execute();

//SQLエラー
if($status==false){
    sql_error($stmt);
}

//抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得

v($val);


if(password_verify($pw, $val['pw'])){

    // //該当レコードがあれば、DBから取得した$valの値をSESSIONに値を代入
    if( $val["id"] != "" ){
      //Login成功時
      $_SESSION["chk_ssid"]  = session_id();
      $_SESSION["id"] = $val['id'];
      $_SESSION["name"] = $val['name'];
      $_SESSION["camp"] = $val['camp'];
      $_SESSION["course"] = $val['course'];
      $_SESSION["cls"] = $val['cls'];
      $_SESSION["student"] = $val['student'];
      $_SESSION["mail"] = $val['mail'];
      $_SESSION["kanri"] = $val['kanri'];
      $_SESSION["life"] = $val['life'];
      $_SESSION["udate"] = $val['udate'];

      // echo "成功";
      // v($_SESSION["name"]);

      // redirect("main.php");
      redirect("../../public/main.php");

    }else{
      //Login失敗時
      redirect("../../public/login.php");
    }

}else{
      $_SESSION["emess"]='<div class="alert alert-danger" role="alert">IDとパスワードが異なります<br></div>';
      redirect("../../public/login.php");
}

?>
