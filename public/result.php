<?php
//session check//
session_start();
// sschk();

include("../src/php/funcs.php");
include("../src/php/db.php");

//DBに接続
$pdo = db_conn();
$suid = $_SESSION["id"];

// ダミーのログインユーザーIDセット
// $_SESSION['id'] = 2;


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

function mb_strimlen($str, $start, $length, $trimmarker = '', $encoding = false) {
   $encoding = $encoding ? $encoding : mb_internal_encoding();
   $str = mb_substr($str, $start, mb_strlen($str), $encoding);
   if (mb_strlen($str, $encoding) > $length) {
       $markerlen = mb_strlen($trimmarker, $encoding);
       $str = mb_substr($str, 0, $length - $markerlen, $encoding) . $trimmarker;
   }
   return $str;
}

$surl = mb_strimlen($pos['url'], 0, 40, "...", 'UTF-8');

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
// var_dump($users[$res['uid']]);


// bookmark(表示SQL)
$sql = "SELECT * FROM bookmark_table WHERE pid = :pid AND uid = :uid";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':uid',$suid, PDO::PARAM_INT);
$stmt->bindValue(':pid',$id, PDO::PARAM_INT);
$status = $stmt->execute();
// var_dump($suid);

if ($status) {
    $bms = $stmt->fetch(PDO::FETCH_ASSOC);
};

include("./instance/header.php");

?>
<div class="editor_container">

        <!-- 投稿内容 start -->
        <p class="editor_title">投稿内容</p>
        <div>
            <p class="r_title"><?= $pos['title'] ?></p>
            <!-- <p class="r_title">jQueryでvideoやaudioを再生したい時はオブジェクト取得方法に注意が必要</p> -->
            <!-- <p class="r_comment">言語</p> -->
            <div class="r_fix">
            <p class="r_comment">投稿者コメント</p>
            <div class="r_comment">
                <?= $pos['star'] ?></div>
            </div>
            <p class="r_text"><?= $pos['cont'] ?></p>
            <!-- <p class="r_text">jQueryオブジェクトに対してplay()やgetContext(“2d”)を使用する場合、jQueryオブジェクトは配列のような形で取得されるため、get(0)などを使用して、「一番最初の要素」を取得した上で命令をしないといけない</p> -->

            <!-- <p class="r_url">URL<i class="angle right icon"></i><a href="<?= $pos['url'] ?>"><?= $pos['url'] ?></a></p> -->
            <p class="r_url">URL<i class="angle right icon"></i><a href="<?= $pos['url'] ?>" target="new"><?= $surl ?></a></p>
            <div class="r_fix">
            </div>
        </div>
        <!-- 投稿内容 end -->
        <div class="r_fix">
            <div class="ui large label"><?= $pos['lang'] ?></div>
            <div class="ui large label"><?= $pos['cost'] ?></div>

        <!-- bookmark start -->
            <?php if($bms["pid"] == $id AND $bms["uid"] == $_SESSION["id"]): ?>
            <form action="../src/php/delete_bm.php" method="POST" style="margin-left: auto;">
                <button class="ui orange button" type="submit" value="send_bm"><i class="star icon"></i> BookMark済み</button>
                <input type="hidden" name="id" value="<?=$pos["id"]?>">
                <input type="hidden" name="uid" value="<?= $suid ?>">
            </form>
            <?php else:?>
            <form action="../src/php/insert_bm.php" method="POST" style="margin-left: auto;">
                <button class="ui button" type="submit" value="send_bm"><i class="star icon"></i> BookMark</button>
                <input type="hidden" name="id" value="<?=$pos["id"]?>">
                <input type="hidden" name="uid" value="<?= $suid ?>">
            </form>
            <?php endif;?>
        <!-- bookmark end -->

            <?php if($pos['fpass']): ?>
            <button class="ui button">
            <i class="cloud download alternate icon"></i>
                <a href="../upload/<?= $pos['fpass'] ?>" download>添付ファイル</a>
            <?php endif; ?>
            </button>
        </div>
<!-- </div> -->

<div class="r_container">
    <div class="r_contents_l">
        <!-- comment start -->
        <p class="editor_title">コメント</p>
        <form action="../src/php/insert_res.php" method="POST">
            <p>
                <div class="ui fluid action input">
                <input type="text" id="res" name="res">
                <input type="hidden" name="pid" value="<?= $pos["id"] ?>">
                <button class="ui button" type="submit" value="送信">送信</button>
                </div>
            </p>
        </form>
            <div class="hide_r">
        <table>
            <thead>
                <tr class="k_tr">
                    <th>投稿者</th>
                    <th class="k_td_r">コメント</th>
                    <th>日付</th>
                    <th class="k_td_i">編集</th>
                    <th class="k_td_i">削除</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($responses as $res): ?>
                <tr class="k_tr_r">
                    <td  class="k_td"><?= $users[$res['uid']] ?></td>
                    <td  class="k_td_r"><?= $res['res'] ?></td>
                    <td  class="k_td"><?= $res['rdate'] ?></td>
                    <!-- session idのユーザーのみ「edit」ボタン -->
                    <td class="k_td_i">
                    <?php if ($res["uid"] == $_SESSION["id"]): ?>
                        <a href="update_res.php?res_id=<?= $res['id'] ?>"><i class="edit icon"></i></a>
                    <?php endif;?>
                    </td>
                    <!-- session idのユーザーのみ「delete」ボタン -->
                    <td class="k_td_i">
                    <?php if ($res["uid"] == $_SESSION["id"]): ?>
                        <a href="../src/php/delete_res.php?res_id=<?= $res['id'] ?>"><i class="trash alternate icon"></i></a>
                    <?php endif;?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
            </div>
        <!-- comment end -->
    </div>

    <div class="r_contents_r">
        <!-- 投稿者情報 start -->
        <p class="editor_title">投稿者情報</p>

<div class="ui card">
  <div class="image">
  <div class="prof_logo1">
    <img src="../prof/<?=$user['ipass']?>" alt="profile img">
  </div>
  </div>
  <div class="content">
    <a class="header"><p><?= $user['name'] ?></p></a>
    <div class="meta">
      <span class="date"><p><?= $user['camp'] ?>　<?= $user['course'] ?><?= $user['cls'] ?>th  -  <?= $user['student'] ?></p></span>
    </div>
    <div class="description"><?= $user['intro'] ?>
    </div>
  </div>
  <div class="extra content">
    <button class="ui facebook button" onclick="location.href='https://www.facebook.com/<?= $user['fb'] ?>'" >
        <i class="facebook icon"></i>
            Facebook
    </button>
    <button class="ui twitter button" onclick="location.href='https://twitter.com/<?= $user['tw'] ?>'">
        <i class="twitter icon"></i>
         Twitter
    </button>
  </div>
</div>
        <!-- 投稿者情報 end -->
    </div>
</div>

</div>

<?php
include("./instance/footer.php");
?>
