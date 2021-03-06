
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


// テーブル結合でpostデータを呼び出す
function bookmark_naiyou($id){
  $pdo = db_conn();
  $stmt = $pdo->prepare("
    SELECT
    bookmark_table.id,
    post_table.id as pid,
    post_table.lang,
    post_table.title,
    post_table.url,
    post_table.fpass,
    post_table.fname,
    post_table.star,
    post_table.post,
    user_table.name,
    bookmark_table.adddate
    FROM bookmark_table
    JOIN post_table
    ON (bookmark_table.pid = post_table.id)
    JOIN user_table
    ON (post_table.uid = user_table.id)
    AND bookmark_table.uid=$id
    AND post_table.post = '投稿'
    AND user_table.life = 0
    ORDER BY adddate DESC
  ");
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    if($error="Unknown column 'bookmark_table.adddate' in 'field list'"){
      exit("現在、Bookmarkの登録はありません");
    }else{
      exit("SQLエラー:".$error[2]);
    }
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}


// デリート処理
function bookmark_del($id){
  $pdo = db_conn();

  $sql = 'DELETE FROM bookmark_table WHERE id = :id';
  $stmt = $pdo->prepare($sql);

  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    redirect("../../public/bookmark.php");
  }
}


// テーブル結合でpostデータを呼び出す
function kennsaku_kensu($where){
  $pdo = db_conn();
  $stmt = $pdo->prepare("
    SELECT
    post_table.id,
    post_table.lang,
    post_table.title,
    post_table.cont,
    post_table.uid,
    user_table.name
    FROM post_table
    JOIN user_table
    ON (post_table.uid = user_table.id)
    AND user_table.life = 0
    AND post_table.post = '投稿'
    $where
  ");
  $status = $stmt->execute();

  if($status==false) {
    $error = $stmt->errorInfo();
    exit("SQLエラー:".$error[2]);
  }else{
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}


// テーブル結合でpostデータを呼び出す
function kennsaku_naiyo($where,$scount,$row_count){
  $pdo = db_conn();
  $stmt = $pdo->prepare("
    SELECT
    post_table.id,
    post_table.lang,
    post_table.title,
    post_table.cont,
    post_table.url,
    post_table.fpass,
    post_table.fname,
    post_table.star,
    post_table.uid,
    post_table.pdate,
    post_table.post,
    user_table.name
    FROM post_table
    JOIN user_table
    ON (post_table.uid = user_table.id)
    AND user_table.life = 0
    AND post_table.post = '投稿'
    $where
    ORDER BY pdate DESC
    LIMIT $scount, $row_count
  ");
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
