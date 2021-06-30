<?php

// session ID
// sschk();
session_start();
// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

$user = [];
$user_id = $_GET['user_id'];
$sql = "SELECT * FROM user_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
};
// var_dump($user);exit;

// 更新ボタンをクリックした時
if ($_POST) {
    $kanri = $_POST['kanri'];
    $life = $_POST['life'];
    $update_sql = "UPDATE user_table SET kanri = :kanri, life = :life WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindValue(':kanri', $kanri, PDO::PARAM_INT);
    $stmt->bindValue(':life', $life, PDO::PARAM_INT);
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        redirect('superuser.php');
    } else {
        sql_error($stmt);
        exit;
    }

}

// include("./instance/header.php");

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

            <p class="kp_u"><?= $user['name'] ?></p>

            <p class="kp_u_r"><?= $user['camp'] ?> 校</p>
        </div>
        <div class="ke_contents_fix1">
            <p class="kp_u"><?= $user['course'] ?></p>
            <p style="font-size: 30px;
                      font-weight: bold;
                      margin-left: 60px;"><?= $user['cls'] ?> th</p>
            <p style="font-size: 30px;
                      font-weight: bold;
                      margin-left: 60px;">No. <?= $user['student'] ?></p>
        </div>

         <div class="ke_contents_fix">

            <div class="ke_div">
                <p class="ke_p">管理権限</p>
                <div class="ke_select">
                    <select style="background-color: #dee7f0;" name="kanri" id="kanri">
                        <option value="0" <?= $user['kanri'] === '0' ? 'selected' : '' ?>>一般</option>
                        <option value="1" <?= $user['kanri'] === '1' ? 'selected' : '' ?>>管理者</option>
                    </select>
                </div>
            </div>
            <div class="ke_div">
                <p class="ke_p"> 在籍</p>
                <div class="ke_select">
                <select style="background-color: #dee7f0;" name="life" id="life">
                    <option value="0" <?= $user['life'] === '0' ? 'selected' : '' ?>>在籍</option>
                    <option value="1" <?= $user['life'] === '1' ? 'selected' : '' ?>>離籍</option>
                </select>
                </div>
            </div>

        </div>

        <button
        class="big ui blue button"
        type="submit"
         value="更新"
        style="margin-top: 30px; !important">更新</button>
    </form>
        <!-- <div class="ke_logo">
            <img src="../img/stanp.png">
        </div> -->
    </div>

</div>

<?php
include("./instance/footer.php");
?>
