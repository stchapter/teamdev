<!-- <!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

<script src="../src/js/jquery-2.1.3.min.js"></script>
<script src="../src/js/PaginateMyTable.js"></script>

</head>
<body> -->

<?php
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");

session_start();

// 認証下
sschk();

include("./instance/header.php");

$id = $_SESSION["id"];

// DBから取得
$val = post_naiyou($id);



?>

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
        <td class="bk_td"><a href="<?php echo h($doc[url]); ?>" target="">参照URL</a></td>
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
</body>
</html>
