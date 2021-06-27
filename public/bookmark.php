<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="witdd=device-witdd, initial-scale=1.0">
  <title>Document</title>

<script src="../src/js/jquery-2.1.3.min.js"></script>
<script src="../src/js/PaginateMyTable.js"></script>
</head>
<body>

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
$val = bookmark_naiyou($id);
?>




<div class="mytable">
  <table class="">
      <th>言語</th>
      <th>タイトル</th>
      <th>評価</th>
      <th>URL</th>
      <th>参照ファイル</th>
      <th>投稿者</th>
      <th>登録日</th>
      <th>削除</th>
    <?php foreach($val as $doc): ?>
      <tr>
        <td><?php echo h($doc[lang]); ?></td>
        <td><a href="result.php?id=<?php echo h($doc[id]); ?>"><?php echo h($doc[title]); ?></a></td>
        <td><?php echo h($doc[star]); ?></td>
        <td><a href="<?php echo h($doc[url]); ?>" target="new">参照URL</a></td>
        <td><a href="../upload/<?php echo h($doc[fpass]); ?>" downnload><?php echo h($doc[fname]); ?></a></td>
        <td><?php echo h($doc[name]); ?></td>
        <td><?php echo h($doc[atddate]); ?></td>
        <td><a href="../src/php/bookdel.php?id=<?php echo h($doc[id]); ?>">
          <button class="" type="button">削除</button></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php
include("./instance/footer.php");
?>

<script>
$(".mytable").paginate({
            rows: 3,          // Set number of rows per page. Default: 5
            position: "bottom",   // Set position of pager. Default: "bottom"
            jqueryui: true,    // Allows using jQueryUI theme for pager buttons. Default: false
            showIfLess: false  // Don't show pager if table has only one page. Default: true
        });
</script>



</body>
</html>
