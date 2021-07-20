<?php
include_once("../src/php/funcs.php");
include_once("../src/php/db.php");
include_once("../src/php/user_db_list.php");

session_start();

// 認証下
// sschk();

// ポストでユーザーIDが飛んできたら検索して、ユーザ情報をjsonで返却予定
// $id = $_POST['id'];
// 本番環境ではコメントアウト
$id=intval(1);

// DB接続
$pdo = db_conn();

// ユーザ情報を取得のためのクエリを作成
$sql = "
  SELECT
    *
  FROM
    user_table
  WHERE
    id=:id
";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
// クエリ実行
$status = $stmt->execute();

//SQLエラー
if($status==false){
    sql_error($stmt);
}

//user_tableからidで絞り込んだ1レコードを連想配列形式で取得
$userProf = $stmt->fetch(PDO::FETCH_ASSOC);


// DBより各種パラメーターを取得
// $camp_list=camp_list();
// $course_list=course_list();


// 連想配列からJSON形式に変換
$userProf = json_encode($userProf, JSON_UNESCAPED_UNICODE);
// フロント側へ渡す
echo $userProf;
