<?php
session_start();
include("funcs.php");
include("db.php");
// sschk();

$id = intval($_SESSION["id"]);
// v($id);
// v($_POST);
// v($_FILES["profile_image"]);

//POSTデータからプロフィール情報を取得
$camp               = isset($_POST['admission_area'])         ? $_POST['admission_area']  : NULL;
$course             = isset($_POST['course_name'])            ? $_POST['course_name']     : NULL;
$cls   = isset($_POST['admission_period'])       ? $_POST['admission_period'] : NULL;
// 卒業年月日作成
$graduation_date_year   = isset($_POST['graduation_date_year'])   ? $_POST['graduation_date_year'] : NULL;
$graduation_date_month  = isset($_POST['graduation_date_month'])  ? $_POST['graduation_date_month'] : NULL;
// graduation_dateは文字列結合で作成。形式'2020-10-1'
$graduation_date = $graduation_date_year . '-' . $graduation_date_month . '-' . 01;

// 誕生日の作成
$birthday_year   = isset($_POST['birthday_year'])   ? $_POST['birthday_year']  : NULL;
$birthday_month  = isset($_POST['birthday_month'])  ? $_POST['birthday_month'] : NULL;
$birthday_day    = isset($_POST['birthday_day'])    ? $_POST['birthday_day']   : NULL;
// birthdayは文字列結合で作成。形式'1989-11-25'
$birthday = $birthday_year . '-' . $birthday_month . '-' . $birthday_day;

$comment        = isset($_POST['comment'])        ? $_POST['comment']       : NULL;
$blood_type     = isset($_POST['blood_type'])     ? $_POST['blood_type']    : NULL;
$residence      = isset($_POST['residence'])      ? $_POST['residence']     : NULL;
$birthplace     = isset($_POST['birthplace'])     ? $_POST['birthplace']    : NULL;
$annual_income  = isset($_POST['annual_income'])  ? $_POST['annual_income'] : NULL;
$personality    = isset($_POST['personality'])    ? $_POST['personality']   : NULL;
$why_gs                          = isset($_POST['why_gs'])              ? $_POST['why_gs']             : NULL;
$portfolio_title1                = isset($_POST['portfolio_title1'])    ? $_POST['portfolio_title1']   : NULL;
$portfolio_url1                  = isset($_POST['portfolio_url1'])      ? $_POST['portfolio_url1']     : NULL;
$portfolio_comment1              = isset($_POST['portfolio_comment1'])  ? $_POST['portfolio_comment1'] : NULL;
$portfolio_title2                = isset($_POST['portfolio_title2'])    ? $_POST['portfolio_title2']   : NULL;
$portfolio_url2                  = isset($_POST['portfolio_url2'])      ? $_POST['portfolio_url2']     : NULL;
$portfolio_comment2              = isset($_POST['portfolio_comment2'])  ? $_POST['portfolio_comment2'] : NULL;
$portfolio_title3                = isset($_POST['portfolio_title3'])    ? $_POST['portfolio_title3']   : NULL;
$portfolio_url3                  = isset($_POST['portfolio_url3'])      ? $_POST['portfolio_url3']     : NULL;
$portfolio_comment3              = isset($_POST['portfolio_comment3'])  ? $_POST['portfolio_comment3'] : NULL;
$free_space                      = isset($_POST['free_space'])          ? $_POST['free_space']         : NULL;

// // アイコン画像のアップロード処理
// // 1.file名の取得
if ($_FILES["profile_image"]["name"] != "" || null) {
  $profile_image = $_FILES["profile_image"]["name"];
  // 2.画像データをprofフォルダーにアップロード
  $upload = "../../prof/";
  if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $upload . $profile_image)) {
    // アップロードが正常に完了したらセッションのimgを変更する
    $_SESSION["icon"]      = $profile_image;
  } else {
    // アップロードが失敗したらエラーを吐き出す
    echo $_FILES["profile_image"]["error"];
  }
} else {
  $profile_image = $_POST["default_icon"];
}
// var_dump($profile_image);
//DB接続します
$pdo = db_conn();

//usersテーブルへのマイプロフィールを更新のためのクエリを作成
$sql = "
  UPDATE
    user_table
  SET
    camp = :camp,
    course = :course,
    cls = :cls,
    ipass = :profile_image,
    graduation_date = :graduation_date,
    birthday = :birthday,
    comment = :comment,
    blood_type = :blood_type,
    residence = :residence,
    birthplace = :birthplace,
    annual_income = :annual_income,
    personality = :personality,
    why_gs = :why_gs,
    portfolio_title1 = :portfolio_title1,
    portfolio_url1 = :portfolio_url1,
    portfolio_comment1 = :portfolio_comment1,
    portfolio_title2 = :portfolio_title2,
    portfolio_url2 = :portfolio_url2,
    portfolio_comment2 = :portfolio_comment2,
    portfolio_title3 = :portfolio_title3,
    portfolio_url3 = :portfolio_url3,
    portfolio_comment3 = :portfolio_comment3,
    free_space = :free_space

  WHERE
    id = :id
  ;"
;

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':camp', $camp, PDO::PARAM_STR);
$stmt->bindValue(':course', $course, PDO::PARAM_STR);
$stmt->bindValue(':cls', $cls, PDO::PARAM_INT);
$stmt->bindValue(':profile_image', $profile_image, PDO::PARAM_STR);
$stmt->bindValue(':graduation_date', $graduation_date, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':blood_type', $blood_type, PDO::PARAM_INT);
$stmt->bindValue(':residence', $residence, PDO::PARAM_INT);
$stmt->bindValue(':birthplace', $birthplace, PDO::PARAM_INT);
$stmt->bindValue(':annual_income', $annual_income, PDO::PARAM_INT);
$stmt->bindValue(':personality', $personality, PDO::PARAM_INT);
$stmt->bindValue(':why_gs', $why_gs, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_title1', $portfolio_title1, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_url1', $portfolio_url1, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_comment1', $portfolio_comment1, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_title2', $portfolio_title2, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_url2', $portfolio_url2, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_comment2', $portfolio_comment2, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_title3', $portfolio_title3, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_url3', $portfolio_url3, PDO::PARAM_STR);
$stmt->bindValue(':portfolio_comment3', $portfolio_comment3, PDO::PARAM_STR);
$stmt->bindValue(':free_space', $free_space, PDO::PARAM_STR);
// $stmt->bindValue(':profile_image', $profile_image, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
// プロフィールアップデートのためのクエリを実行
// echo $sql;
$status = $stmt->execute();


//クエリ実行時にエラーがある場合は停止
if ($status == false) {
  sql_error($stmt);
}

//マイプロフィールページにリダイレクト
redirect("../../public/my_profile.php");
