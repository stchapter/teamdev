<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
$val = post_naiyou($id);



?>

<div class="">
  <table class="mytable">
    <tr>
      <th>言語</th>
      <th>タイトル</th>
      <th>URL</th>
      <th>参照ファイル</th>
      <th>コスト</th>
      <th>状態</th>
      <th>更新日</th>
      <th>修正</th>
      <!-- 削除は編集機能であるからいかな-->
    </tr>

    <?php foreach($val as $doc): ?>
    <tr>
      <td><?php echo h($doc[lang]); ?></td>
      <td><a href="result.php?id=<?php echo h($doc[id]); ?>"><?php echo h($doc[title]); ?></a></td>
      <td><a href="<?php echo h($doc[url]); ?>" target="">参照URL</a></td>
      <td><a href="../upload/<?php echo h($doc[fpass]); ?>" taeget="new"><?php echo h($doc[fname]); ?></a></td>
      <td><?php echo h($doc[cost]); ?></td>
        <?php if($doc[life]==0):?>
            <td>表示</td>
        <?php else :?>
            <td>非表示（下書き）</td>
        <?php endif; ?>
      <td><?php echo h($doc[pdate]); ?></td>
      <td><button class="" type="button" onclick=location.href='myedit.php?id=<?php echo h($doc[id]); ?>'>修正</button></td>
    </tr>
    <?php endforeach; ?>
  <table>
</div>


<?php
include("./instance/footer.php");
?>

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
