<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<?php
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");

session_start();

// 認証下
sschk();


$id = $_SESSION["id"];

// v($id);


// DBから取得
$val = bookmark_naiyou($id);


include("./instance/header.php");

?>

<table>
  <tr>
    <th>言語</th>
    <th>タイトル</th>
    <th>評価</th>
    <th>URL</th>
    <th>参照ファイル</th>
    <th>投稿者</th>
    <th>登録日</th>
    <th>削除</th>
  </tr>

  <?php foreach($val as $doc): ?>
  <tr>
    <td><?php echo h($doc[lang]); ?></td>
    <td><a href="result.php?id=<?php echo h($doc[id]); ?>"><?php echo h($doc[title]); ?></a></td>
    <td><?php echo h($doc[star]); ?></td>
    <td><a href="<?php echo h($doc[url]); ?>" target="new">参照URL</a></td>
    <td><a href="../upload/<?php echo h($doc[fpass]); ?>"><?php echo h($doc[fname]); ?></a></td>
    <td><?php echo h($doc[name]); ?></td>
    <td><?php echo h($doc[adddate]); ?></td>
    <td><a href="../src/php/bookdel.php?id=<?php echo h($doc[id]); ?>">
    <button class="" type="button">削除</button></a>
    </td>
  </tr>
  <?php endforeach; ?>

<table>









<?php
include("./instance/footer.php");
?>





</body>
</html>
