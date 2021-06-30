<?php

// session ID
// sschk();
session_start();
// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

$course = [];
$course_id = $_GET['id'];
$sql = "SELECT * FROM course_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $course_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $courseS = $stmt->fetch(PDO::FETCH_ASSOC);
};

// 更新ボタンをクリックした時
if ($_POST) {
    $course = $_POST['course'];
    $life = $_POST['life'];
    $update_sql = "UPDATE course_table SET course = :course, life = :life WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindValue(':course', $course, PDO::PARAM_STR);
    $stmt->bindValue(':life', $life, PDO::PARAM_INT);
    $stmt->bindValue(':id', $course_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        redirect('superuser.php');
    } else {
        sql_error($stmt);
        exit;
    }

}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/update.css">
  <title>GEEKBOOK</title>
</head>
<body>


  <header>
  <div class="header_container">

    <div class="header_logo_container">
      <div class="header_logo">
        <img src="../img/topImg.png">
      </div>
         <p class="login_name">こんにちは！　<?=$_SESSION["name"]?>　さん</p>
    </div>


    <div class="header_button">
      <div class="header_button_container">
        <div class="blue ui buttons">
          <button class="ui button" onclick="location.href='main.php'">TOPへ</button>
          <button class="ui button" onclick="location.href='useredit.php'">登録修正</button>
          <button class="ui button" onclick="location.href='newpage.php'">新規投稿</button>
          <button class="ui button" onclick="location.href='mypage.php'">自分の投稿</button>
          <button class="ui button" onclick="location.href='bookmark.php'">Bookmark</button>
          <div class="header_button_R">
            <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
	        </div>
        </div>
      </div>
    </div>

  </div>
  </header>

<div class="container">

    <div class="ke_card">


    <form action="" method="POST">

    <div class="ke_contents_fix">

    <p style="font-size: 40px;
              font-weight: bold;">コース</p>
        <div class="ui huge icon input">
            <input type="text" name="course" value="<?=h($courseS["course"])?>">
            <i class="primary school icon"></i>
        </div>
        </div>

         <p class="ke_p">表示</p>
        <div class="ke_select">
            <select name="life" id="life">
                <option value="0" <?= h($courseS['life']) === '0' ? 'selected' : '' ?>>表示</option>
                <option value="1" <?= h($courseS['life']) === '1' ? 'selected' : '' ?>>非表示</option>
            </select>
        </div>

        <input class="large ui primary button" style="margin: 60px 0 0 30px;" type="submit" value="更新">
    </form>


    </div>
</div>


<?php
include("./instance/footer.php");
?>
