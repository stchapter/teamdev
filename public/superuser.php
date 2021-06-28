<?php

// session ID
session_start();
// var_dump($_SESSION['name']);exit();
// sschk();

// $id = 1;

// $_SESSION['name'] = ['管理者'];
//セッションで[name]とってくる。
$name = '管理者';

// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

// 検索
$users = [];
// 送信ボタンが押されたらユーザーを検索する
if ($_POST) {
    // POST
    if (isset($_POST['user_search'])) {
        $name = $_POST['name'];
        $sql = "SELECT * FROM user_table WHERE name LIKE :name ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
        $status = $stmt->execute();
        // echo '<pre>';
        // var_dump($_POST);exit;
        // echo '</pre>';

        if ($status) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        };

    } else if (isset($_POST['camp_create'])) {
        // camp の登録処理
        $camp = $_POST['camp'];

        $stmt = $pdo->prepare("INSERT INTO camp_table(camp)VALUES(:camp)");
        $stmt->bindValue(':camp', $camp, PDO::PARAM_STR);
        $result = $stmt->execute();
        // var_dump($result);exit;

        if ($result) {
            $stmt = $pdo->prepare('SELECT * FROM camp_table ORDER BY id DESC');
            $stmt->execute();
            // var_dump($stmt->fetch(PDO::FETCH_ASSOC));exit;
            $camp_lists = $stmt->fetch(PDO::FETCH_ASSOC);
            redirect('superuser.php');
        } else {
            $error = 'データの保存に失敗しました。';
        }

    } else if (isset($_POST['course_create'])) {
        // course 登録処理
        $course = $_POST['course'];
        $stmt = $pdo->prepare("INSERT INTO course_table(course)VALUES(:course)");
        $stmt->bindValue(':course', $course, PDO::PARAM_STR);
        $result = $stmt->execute();
        // var_dump($result);exit;

        if ($result) {
            $stmt = $pdo->prepare('SELECT * FROM course_table ORDER BY id DESC');
            $stmt->execute();
            // var_dump($stmt->fetch(PDO::FETCH_ASSOC));exit;
            $course_lists = $stmt->fetch(PDO::FETCH_ASSOC);
            redirect('superuser.php');
        } else {
            $error = 'データの保存に失敗しました。';
        }
    }

};

// ユーザー一覧表示
//1.ユーザー一覧(データ表示SQL作成）
$stmt = $pdo->prepare("SELECT * FROM user_table ORDER BY id ASC");
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
}else{
    $user_lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
};


// camp
//1.camp(データ表示SQL作成）
$stmt = $pdo->prepare("SELECT * FROM camp_table ORDER BY id ASC");
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
}else{
    $camp_lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
};

// course
//1.course(データ表示SQL作成）
$stmt = $pdo->prepare("SELECT * FROM course_table ORDER BY id ASC");
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
}else{
    $course_lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
};


// code
//1. (codeデータ表示SQL作成）
$stmt = $pdo->prepare("SELECT * FROM key_table WHERE id = '1'");
$status = $stmt->execute();

// 現コードの表示
if($status==false) {
  sql_error($stmt);
}else{
  $key = $stmt->fetch(PDO::FETCH_ASSOC);
};

include("./instance/header.php");

?>




<h1 class="k_title"><i class="cat icon"></i> <?= $name ?>さん、こんにちは</h1>

<div class="editor_container">
        <!-- ユーザー検索 始まり -->
            <p class="k_title_mini">ユーザー　検索</p>
            <form action="" method="POST">
                <div>
                    <!-- <label for="name">名前</label> -->
                  <div class="ui action input text_input">
                    <input type="text" name="name" id="name" placeholder="ユーザー名">
                    <button type="submit" name="user_search" value="検索" class="ui button" id="k_click">検索</button>
                    <!-- <i class="search icon"></i> -->
                  </div>
                </div>
            </form>
            <form action="" method="POST">
            <table class="">
                <thead id="k_thead">
                    <tr>
                        <th>ユーザー名</th>
                        <th>校舎</th>
                        <th>コース</th>
                        <th>クラス</th>
                        <th>学籍番号</th>
                        <th>管理</th>
                        <th>在籍</th>
                        <th>編集</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="k_tr">
                        <td class="k_td"><?= $user['name'] ?></td>
                        <td class="k_td"><?= $user['camp'] ?></td>
                        <td class="k_td"><?= $user['course'] ?></td>
                        <td class="k_td"><?= $user['cls'] ?></td>
                        <td class="k_td"><?= $user['student'] ?></td>
                        <?php if ($user["kanri"] == 0): ?>
                            <td class="k_td">一般</td>
                        <?php else:?>
                            <td class="k_td">管理者</td>
                        <?php endif;?>
                        <?php if ($user["life"] == 0): ?>
                            <td class="k_td">在籍</td>
                        <?php else:?>
                            <td class="k_td">離籍</td>
                        <?php endif;?>
                        <td class="k_td"><a href="update_usearch.php?user_id=<?= $user['id'] ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </form>

            <p class="k_title_mini">ユーザー　一覧</p>
            <form action="" method="POST">
            <table class="mytable">
                <thead>
                    <tr>
                        <th>ユーザー名</th>
                        <th>校舎</th>
                        <th>コース</th>
                        <th>クラス</th>
                        <th>学籍番号</th>
                        <th>管理</th>
                        <th>在籍</th>
                        <th>編集</th>
                    </tr>
                <tbody>
                <?php foreach ($user_lists as $u): ?>
                    <tr>
                        <td class="k_td"><?= $u['name'] ?></td>
                        <td class="k_td"><?= $u['camp'] ?></td>
                        <td class="k_td"><?= $u['course'] ?></td>
                        <td class="k_td"><?= $u['cls'] ?></td>
                        <td class="k_td"><?= $u['student'] ?></td>
                        <?php if ($u["kanri"] == 0): ?>
                            <td class="k_td">一般</td>
                        <?php else:?>
                            <td class="k_td">管理者</td>
                        <?php endif;?>
                        <?php if ($u["life"] == 0): ?>
                            <td class="k_td">在籍</td>
                        <?php else:?>
                            <td class="k_td">離籍</td>
                        <?php endif;?>
                        <td class="k_td"><a href="update_usearch.php?user_id=<?= $u['id'] ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </form>
        </div>
        <!-- ユーザー検索 終わり -->

</div>

<div class="k_top_container">

<div class="k_top_contents">

        <!-- 校舎 始まり -->
        <div class="k_content">
            <p class="k_head" id="a_head"><i class="huge primary school icon"></i>　校舎一覧</p>
            <div class="hide">
            <form action="" method="POST">
            <table class="">
                <thead>
                    <tr>
                        <th>校舎名</th>
                        <th>編集</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($camp_lists as $camp): ?>
                    <tr>
                        <td class="k_td" id="camp_color"><?= $camp['camp'] ?></td>
                        <td class="k_td"><a href="update_camp.php?id=<?= $camp['id'] ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </form>
            <p class="k_title_mini">　新規登録</p>
            <form action="" method="POST">
        <div class="ui action left icon input">
                <input type="text" name="camp" placeholder="新校舎">
                <button type="submit" name="camp_create" value="登録" class="ui button">登録</button>
                <i class="school icon"></i>
            </form>
        </div>
        </div>
        </div>
        <!-- 校舎 終わり -->

        <!-- コース 始まり -->
        <div class="k_content">
            <p class="k_head" id="b_head"><i class="huge primary file alternate icon"></i>コース一覧</p>
            <div class="hide">
            <form action="" method="POST">
            <table class="">
                <thead>
                    <tr>
                        <th>コース名</th>
                        <th>編集</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($course_lists as $course): ?>
                    <tr>
                        <td class="k_td"><?= $course['course'] ?></td>
                        <td class="k_td"><a href="update_course.php?id=<?= $course['id'] ?>">edit</a></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </form>
            <p class="k_title_mini">　新規登録</p>
            <form action="" method="POST">
                <div class="ui action left icon input">
                <input type="text" name="course" placeholder="新規コース">
                <button type="submit" name="course_create" value="登録" class="ui button">登録</button>
                      <i class="file alternate icon"></i>
                </div>
            </form>
        </div>
        </div>
        <!-- コース 終わり -->

        <!-- コード始まり -->
        <div class="k_content">
        <p class="k_head" id="c_head"><i class="huge primary address card icon"></i>現在のコード</p>
        <div class="hide">
        <div class="k_keyword"><?= $key['kw'] ?></div>
        <form action="../src/php/update_code.php" method="POST">
            <p class="k_title_mini">　コードの更新</p>
        <div class="ui action left icon input">
            <input type="text" name="kw" id="kw" placeholder="新しいコード">
            <button type="submit" value="更新" class="ui button"><font style="vertical-align: inherit;">更新</font></button>
            <i class="address card icon"></i>
        </div>
        </form>
        </div>
        </div>
        <!-- コード 終わり -->

</div>

</div>

  <footer>
    <div class="s_footer">
      <p>copyright ©️ GEEKBOOK <br> For G’s Academy</p>
    </div>
  </footer>





    <script src="../src/JS/jquery-2.1.3.min.js"></script>
    <script src="../src/JS/main.js"></script>
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
