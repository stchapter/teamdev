<!-- <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>


</head>
<body> -->

<?php
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");

session_start();

// 認証下
sschk();


$id = $_SESSION["id"];

// DBから取得
$val = post_naiyou($id);



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
  <link rel="stylesheet" href="../src/css/responsive.css">
  <title>GEEKBOOK</title>
  <style>
    p.error{
      margin:0;
      color:red;
      font-weight:bold;
      margin-bottom:1em;
    }
    </style>
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


<div class="editor_container">

  <p class="bm_title">自分の投稿一覧</p>

  <div class="table_height">
    <table class="mytable">
      <tr class="bk_tr">
        <th class="bk_th">言語</th>
        <th class="bk_th_r">タイトル</th>
        <th class="bk_th">URL</th>
        <th class="bk_th">参照ファイル</th>
        <th class="bk_th">コスト</th>
        <th class="bk_th">状態</th>
        <th class="bk_th">更新日</th>
        <th class="bk_th">修正</th>
      <!-- 削除は編集機能であるからいかな-->
      </tr>

      <?php foreach($val as $doc): ?>
      <tr class="k_tr">
        <td class="bk_td"><?php echo h($doc[lang]); ?></td>
        <td class="bk_td_r"><a href="result.php?id=<?php echo h($doc[id]); ?>"><?php echo h($doc[title]); ?></a></td>
        <td class="bk_td"><a href="<?php echo h($doc[url]); ?>" target="new">参照URL</a></td>
        <td class="bk_td"><a href="../upload/<?php echo h($doc[fpass]); ?>" download><?php echo h($doc[fname]); ?></a></td>
        <td class="bk_td"><?php echo h($doc[cost]); ?></td>
        <td class="bk_td"><?php echo h($doc[post]); ?></td>
        <td class="bk_td"><?php echo h($doc[pdate]); ?></td>
        <td class="bk_td"><button class="ui primary tertiary button" type="button" onclick=location.href='myedit.php?id=<?php echo h($doc[id]); ?>'><i class="large edit icon"></i></button></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
</div>
</div>
<!--

  <footer>
    <div class="footer">
      <p>copyright ©️ GEEKBOOK <br> For G's Academy</p>
    </div>
  </footer> -->

  <script src="../src/js/jquery-2.1.3.min.js"></script>
  <script src="../src/js/PaginateMyTable.js"></script>
<script>
$(".mytable").paginate({
  rows: 10,          // Set number of rows per page. Default: 5
  position: "bottom",   // Set position of pager. Default: "bottom"
  jqueryui: true,    // Allows using jQueryUI theme for pager buttons. Default: false
  showIfLess: false  // Don't show pager if table has only one page. Default: true
});
</script>
</body>
</html>
