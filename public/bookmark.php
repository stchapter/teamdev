<?php
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");

session_start();

// 認証下
sschk();


$id = $_SESSION["id"];
// DBから取得
$val = bookmark_naiyou($id);
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
  <script src="../src/js/jquery-2.1.3.min.js"></script>
  <script src="../src/js/PaginateMyTable.js"></script>
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
          <button class="ui button" onclick="location.href='useredit.php'">登録修正</button>
          <button class="ui button" onclick="location.href='newpage.php'">新規投稿</button>
          <button class="ui button" onclick="location.href='mypage.php'">自分の投稿</button>
          <button class="ui button" onclick="location.href='bookmark.php'">Bookmark</button>
          <?php if($_SESSION["kanri"]==1): ?>
          <button class="ui button" onclick="location.href='superuser.php'">Admin</button>
          <div class="header_button_Rev" style="margin-left:50%;">
            <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
          </div>
          <?php else: ?>
            <div class="header_button_Rev" style="margin-left:70%;">
              <button class="ui button" onclick="location.href='../src/php/logout.php'">Logout</button>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>
</body>





<div class="m_container">

  <p class="bm_title">Bookmarks</p>

<div class="table_height">
  <table class="mytable">
    <tr class="bk_tr">
      <th class="bk_th">言語</th>
      <th class="bk_th">タイトル</th>
      <th class="bk_th">評価</th>
      <th class="bk_th">URL</th>
      <th class="bk_th">参照ファイル</th>
      <th class="bk_th">投稿者</th>
      <th class="bk_th">登録日</th>
      <th class="bk_th">削除</th>
    </tr>
    <?php foreach($val as $doc): ?>
      <tr class="k_tr">
        <td  class="bk_td"><?php echo h($doc[lang]); ?></td>
        <td  class="bk_td"><a href="result.php?id=<?php echo h($doc[pid]); ?>"><?php echo h($doc[title]); ?></a></td>
        <td  class="bk_td"><?php echo h($doc[star]); ?></td>
        <td  class="bk_td"><a href="<?php echo h($doc[url]); ?>" target="new">参照URL</a></td>
        <td  class="bk_td"><a href="../upload/<?php echo h($doc[fpass]); ?>" download><?php echo h($doc[fname]); ?></a></td>
        <td  class="bk_td"><?php echo h($doc[name]); ?></td>
        <td  class="bk_td"><?php echo h($doc[adddate]); ?></td>
        <td  class="bk_td"><a href="../src/php/bookdel.php?id=<?php echo h($doc[id]); ?>">
          <i class="trash alternate icon"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  </div>

</div>


  <footer>
    <div class="footer">
      <p>copyright ©️ GEEKBOOK <br> For G's Academy</p>
    </div>
  </footer>

<script>
$(".mytable").paginate({
            rows: 10,          // Set number of rows per page. Default: 5
            position: "bottom",   // Set position of pager. Default: "bottom"
            jqueryui: true,    // Allows using jQueryUI theme for pager buttons. Default: false
            showIfLess: false  // Don't show pager if table has only one page. Default: true
        });
</script>
</・body>
</html>
