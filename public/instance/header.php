<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/main.css">
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
    </div>
    <div class="header_button">
      <div class="header_button_container">
        <div class="blue ui buttons">
          <button class="ui button" onclick="location.href='main.php'">TOPへ</button>
          <button class="ui button" onclick="location.href='useredit.php'">マイプロフィール</button>
          <button class="ui button" onclick="location.href='newpage.php'">新規投稿</button>
          <button class="ui button" onclick="location.href='mypage.php'">自分の投稿</button>
          <button class="ui button" onclick="location.href='bookmark.php'">Bookmark</button>
          <div class="header_button_R">
            <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
          </div>
        </div>
      </div>
    </div>
  </header>
</body>
