 <?php

include("funcs.php");
include("db.php");
include("user_db_list.php");

session_start();

// 認証下
sschk();

$id = $_SESSION["id"];
v($id);

$ipass = $_POST['ipass'];

$u = "ipass";
v($u);

$status = fileUpload($u,"../../prof/"); //戻り値：0=ファイル名,1=NG,2=NG

v("kore/".$status);

if($status==1 || $status==2){
      $ipass = "noimg.png";
    }else{
      $ipass = $status; //ファイル名
  }

v($ipass);


//DBへの登録処理

    $pdo = db_conn();

    $sql = "UPDATE user_table SET
        ipass = :ipass
        WHERE id = $id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':ipass', $ipass, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
    $status = $stmt->execute(); //実行

    //データ登録処理後
    if($status==false){
      sql_error($stmt);
    }else{
      echo"更新したなり";
      redirect("../../public/useredit.php");
    }


?>
