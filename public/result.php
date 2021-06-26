<?php
//session check//
session_start();
// sschk();

include("../src/php/funcs.php");
include("../src/php/db.php");

//DBに接続
$pdo = db_conn();
$suid = $_SESSION["uid"];

// ダミーのログインユーザーIDセット
// $_SESSION['uid'] = 2;

// 投稿内容一覧(表示SQL)
$pos = [];
$id = $_GET['id'];
$sql = "SELECT * FROM post_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status) {
    $pos = $stmt->fetch(PDO::FETCH_ASSOC);
};

// 投稿者情報取得(表示SQL)
$sql = "SELECT * FROM user_table WHERE id = :uid ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':uid',$pos['uid'], PDO::PARAM_INT);
$status = $stmt->execute();
if ($status) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
};

// コメント情報取得(表示SQL)
$responses = [];
$sql = "SELECT * FROM res_table WHERE pid = :pid AND life = 0";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':pid',$pos['id'], PDO::PARAM_INT);
$status = $stmt->execute();
if ($status) {
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
};

// 全ユーザー情報取得(表示SQL)
$sql = "SELECT * FROM user_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();
if ($status) {
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $users = array_column($users, 'name', 'id');
};
// var_dump( $user['ipass']);
?>

<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>新規投稿</title>
    </head>

    <body>

        <!-- 投稿内容 start -->
        <p>投稿内容</p>
        <div>
            <p>言語:
                <p><?= $pos['lang'] ?></p>
            </p>
            <p>タイトル(機能):
                <p><?= $pos['title'] ?></p>
            </p>
            <p>おすすめ内容:
                <p><?= $post['cont'] ?></p>
            </p>
            <p>URL:
                <a href="<?= $pos['url'] ?>"><?= $pos['url'] ?></a>
            </p>
            <p>有料・無料:
                <div><?= $pos['cost'] ?></div>
            </p>
            <p>おすすめ度:
                <div><?= $pos['star'] ?></div>
            </p>
            <p>添付ファイル:
                <button><a href="../upload/<?= $pos['fname'] ?>" download> ダウンロード</a></button>
            </p>
        </div>
        <!-- 投稿内容 end -->

        <!-- bookmark start -->
        <form action="../src/php/insert_bm.php" method="POST">
            <button type="submit" value="send_bm">記事のBookMark"</button>
            <input type="hidden" name="id" value="<?=$pos["id"]?>">
            <input type="hidden" name="uid" value="<?= $suid ?>"> 
        </form>
        <!-- bookmark end -->

        <!-- comment start -->
        <p>コメント</p>
        <form action="../src/php/insert_res.php" method="POST">
            <p>
                <label name="res">コメント:</label>
                <input type="text" id="res" name="res">
                <input type="hidden" name="pid" value="<?= $pos["id"] ?>">
                <button type="submit" value="送信">送信</button>
            </p>
        </form>
        <table>
            <thead>
                <tr>
                    <th>投稿者</th>
                    <th>コメント</th>
                    <th>日付</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($responses as $res): ?>
                <tr>
                    <td><?= $users[$res['uid']] ?></td>
                    <td><?= $res['res'] ?></td>
                    <td><?= $res['rdate'] ?></td>
                    <!-- session idのユーザーのみ「edit」ボタン -->
                    <?php if ($res["uid"] == $_SESSION["uid"]): ?>
                        <td><a href="update_res.php?res_id=<?= $res['id'] ?>">edit</a></td>
                    <?php endif;?>
                    <!-- session idのユーザーのみ「delete」ボタン -->
                    <?php if ($res["uid"] == $_SESSION["uid"]): ?>
                        <td><a href="../src/php/delete_res.php?res_id=<?= $res['id'] ?>">delete</a></td>
                    <?php endif;?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <!-- comment end -->

        <!-- 投稿者情報 start -->
        <p>投稿者情報</p>
            <div>
                <img src="../prof/<?=$user['ipass']?>" 'alt=""'>

                <p>名前:
                    <p><?= $user['name'] ?></p>
                </p>
                <p>校舎:
                    <p><?= $user['camp'] ?></p>
                </p>
                <p>コース:
                    <p><?= $user['course'] ?></p>
                </p>
                <p>:学期
                    <div><?= $user['cls'] ?></div>
                </p>
                <p>学籍番号:
                    <div><?= $user['student'] ?></div>
                </p>
                <p>facebook:
                    <a href="<?= $user['fb'] ?>"><?= $user['fb'] ?></a>
                </p>
                <p>twitter:
                    <a href="<?= $user['tw'] ?>"><?= $user['tw'] ?></a>
                </p>
                <p>自己紹介:
                    <div><?= $user['intro'] ?></div>
                </p>
            </div>
        <!-- 投稿者情報 end -->
    </body>
</html>
