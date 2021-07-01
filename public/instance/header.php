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
          <button class="ui button" onclick="location.href='main.php'"><i class="home icon"></i>ホーム</button>
          <button class="ui button" onclick="location.href='newpage.php'"><i class="envelope open icon"></i>新規投稿</button>
          <button class="ui button" onclick="location.href='mypage.php'"><i class="clipboard list icon"></i>投稿リスト</button>
          <button class="ui button" onclick="location.href='bookmark.php'"><i class="star icon"></i>ブックマーク</button>
          <button class="ui button" onclick="location.href='useredit.php'"><i class="pen square icon"></i>プロフィール編集</button>
          <?php if($_SESSION["kanri"]==1): ?>
          <button class="ui button" onclick="location.href='superuser.php'">Admin</button>
          <div class="header_button_Rev" style="margin-left:20%;">
            <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
          </div>
          <?php else: ?>
            <div class="header_button_Rev" style="margin-left:40%;">
              <button class="ui icon button" onclick="location.href='../src/php/logout.php'">Logout</button>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>
</body>
