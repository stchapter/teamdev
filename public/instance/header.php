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
          <button class="ui button" onclick="location.href='my_profile.php'"><i class="pen square icon"></i>プロフィール編集</button>
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
