
<?php

//campデータのリストだし
function camp_l(){
  $stmt = $pdo->prepare("SELECT * FROM camp_table");
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $camp = array_column($result,'camp');
    return $camp;
  }
}

//campリストの取得
function camp_list(){
  $pdo = db_conn();

  $stmt = $pdo->prepare("SELECT * FROM camp_table WHERE life=0");
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    return array_column($result,'camp');
  }
}


//couseリストの取得
function course_list(){
  $pdo = db_conn();
  $stmt = $pdo->prepare("SELECT * FROM course_table WHERE life=0");
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    return array_column($result,'course');
  }
}


//key(kw)データ（事務局コード)
function kw_c(){
  $pdo = db_conn();
  $stmt = $pdo->prepare("SELECT * FROM key_table WHERE id = '1'");
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    return array_column($result,'kw');
  }
}


// potstable投稿の抽出
function post_naiyou($id){

  $pdo = db_conn();
  $stmt = $pdo->prepare("SELECT * FROM post_table WHERE uid = $id ORDER BY pdate DESC");
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}


?>
