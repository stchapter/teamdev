<?php

// session ID
// sschk();

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiユーザー-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
</head>
<body>
    <h1>管理者画面</h1>

        <!-- ユーザー検索 始まり -->
        <div>
            <p>ユーザー検索</p>
            <form action="" method="POST">
                <div>
                    <label for="name">名前</label>
                    <input type="text" name="name" id="name">
                    <input type="submit" name="user_search" value="検索">
                </div>
            </form>
            <form action="" method="POST">
                <thead>
                    <tr>
                        <th>ユーザー名</th>
                        <th>校舎</th>
                        <th>コース</th>
                        <th>クラス</th>
                        <th>学籍番号</th>
                        <th>管理</th>
                        <th>在籍</th>
                        <th>編集</th><br>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['camp'] ?></td>
                        <td><?= $user['course'] ?></td>
                        <td><?= $user['cls'] ?></td>
                        <td><?= $user['student'] ?></td>
                        <td><?= $user['kanri'] ?></td>
                        <td><?= $user['life'] ?></td>
                        <td><a href="update_usearch.php?user_id=<?= $user['id'] ?>">edit</a></td><br>
                    </tr>
                <?php endforeach; ?>
            </form>

            <p>ユーザー一覧</p>
            <form action="" method="POST">
                <thead>
                    <tr>
                        <th>ユーザー名</th>
                        <th>校舎</th>
                        <th>コース</th>
                        <th>クラス</th>
                        <th>学籍番号</th>
                        <th>管理</th>
                        <th>在籍</th>
                        <th>編集</th><br>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($user_lists as $u): ?>
                    <tr>
                        <td><?= $u['name'] ?></td>
                        <td><?= $u['camp'] ?></td>
                        <td><?= $u['course'] ?></td>
                        <td><?= $u['cls'] ?></td>
                        <td><?= $u['student'] ?></td>
                        <td><?= $u['kanri'] ?></td>
                        <td><?= $u['life'] ?></td>
                        <td><a href="update_usearch.php?user_id=<?= $user['id'] ?>">edit</a></td><br>
                    </tr>
                <?php endforeach; ?>
            </form>
        </div>
        <!-- ユーザー検索 終わり -->

        <!-- 校舎 始まり -->
        <div>
            <p>校舎一覧</p>
            <form action="" method="POST">
                <thead>
                    <tr>
                        <th>校舎名</th>
                        <th>編集</th><br>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($camp_lists as $camp): ?>
                    <tr>
                        <td><?= $camp['camp'] ?></td>
                        <td><a href="update_camp.php?id=<?= $camp['id'] ?>">edit</a></td><br>
                    </tr>
                <?php endforeach; ?>
            </form>
            <p>新規登録</p>
            <form action="" method="POST">
                <label for="camp">名称（校舎）:</label>
                <input type="text" name="camp" id="camp">
                <input type="submit" name="camp_create" value="登録">
            </form>
        </div>
        <!-- 校舎 終わり -->

        <!-- コース 始まり -->
        <div>
            <p>コース一覧</p>
            <form action="" method="POST">
                <thead>
                    <tr>
                        <th>コース名</th>
                        <th>編集</th><br>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($course_lists as $course): ?>
                    <tr>
                        <td><?= $course['course'] ?></td>
                        <td><a href="update_course.php?id=<?= $course['id'] ?>">edit</a></td><br>
                    </tr>
                <?php endforeach; ?>
            </form>
            <p>新規登録</p>
            <form action="" method="POST">
                <label for="course">名称（コース名称）:</label>
                <input type="text" name="course" id="course">
                <input type="submit" name="course_create" value="登録">
            </form>
        </div>
        <!-- コース 終わり -->

        <!-- コード始まり -->
        <div>
        <p>現在のコード</p>
        <div><?= $key['kw'] ?></div>
        <form action="../src/php/update_code.php" method="POST">
            <p>コードの更新</p>
            <label for="kw">新コード：</label>
            <input type="text" name="kw" id="kw">
            <input type="submit" value="更新">
        </form>
        </div>
        <!-- コード 終わり -->

   
</body>
</html>