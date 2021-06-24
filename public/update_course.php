<?php

// session ID
// sschk();

// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

$course = [];
$course_id = $_GET['id'];
$sql = "SELECT * FROM course_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $course_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $courseS = $stmt->fetch(PDO::FETCH_ASSOC);
};

// 更新ボタンをクリックした時
if ($_POST) {
    $course = $_POST['course'];
    $life = $_POST['life'];
    $update_sql = "UPDATE course_table SET course = :course, life = :life WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindValue(':course', $course, PDO::PARAM_STR);
    $stmt->bindValue(':life', $life, PDO::PARAM_INT);
    $stmt->bindValue(':id', $course_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        redirect('superuser.php');
    } else {
        sql_error($stmt);
        exit;
    }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update_course</title>
</head>
<body>
    <form action="" method="POST">
        <label>コース：<input type="text" name="course" value="<?=$courseS["course"]?>"></label><br>
        <label>
            表示：
            <select name="life" id="life">
                <option value="0" <?= $courseS['life'] === '0' ? 'selected' : '' ?>>表示</option>
                <option value="1" <?= $courseS['life'] === '1' ? 'selected' : '' ?>>非表示</option>
            </select>
        </label><br>
        <input type="submit" value="更新">
    </form>
</body>
</html>