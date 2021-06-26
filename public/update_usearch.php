<?php

// session ID
// sschk();

// データベースに接続
include("../src/php/funcs.php");
include("../src/php/db.php");
$pdo = db_conn();

$user = [];
$user_id = $_GET['user_id'];
$sql = "SELECT * FROM user_table WHERE id = :id ";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
};
// var_dump($user);exit;

// 更新ボタンをクリックした時
if ($_POST) {
    $kanri = $_POST['kanri'];
    $life = $_POST['life'];
    $update_sql = "UPDATE user_table SET kanri = :kanri, life = :life WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->bindValue(':kanri', $kanri, PDO::PARAM_INT);
    $stmt->bindValue(':life', $life, PDO::PARAM_INT);
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        redirect('superuser.php');
    } else {
        sql_error($stmt);
        exit;
    }

}

include("./instance/header.php");

?>

<div class="ke_container">

    <div class="ke_card">

    <form action="" method="POST">

        <div class="ke_contents_fix">

            <p style="font-size: 40px;
                      font-weight: bold;"><?= $user['name'] ?></p>

            <p style="font-size: 40px;
                      font-weight: bold;
                      margin-left: 100px;"><?= $user['camp'] ?> 校</p>
        </div>
        <div class="ke_contents_fix1">
            <p style="font-size: 50px;
                      font-weight: bold;"><?= $user['course'] ?></p>
            <p style="font-size: 30px;
                      font-weight: bold;
                      margin-left: 60px;"><?= $user['cls'] ?> th</p>
            <p style="font-size: 30px;
                      font-weight: bold;
                      margin-left: 60px;">No. <?= $user['student'] ?></p>
        </div>

         <div class="ke_contents_fix">

            <div class="ke_div">
                <p class="ke_p">管理権限</p>
                <div class="ke_select">
                    <select style="background-color: #dee7f0;" name="kanri" id="kanri">
                        <option value="0" <?= $user['kanri'] === '0' ? 'selected' : '' ?>>一般</option>
                        <option value="1" <?= $user['kanri'] === '1' ? 'selected' : '' ?>>管理者</option>
                    </select>
                </div>
            </div>
            <div class="ke_div">
                <p class="ke_p"> 在籍</p>
                <div class="ke_select">
                <select style="background-color: #dee7f0;" name="life" id="life">
                    <option value="0" <?= $user['life'] === '0' ? 'selected' : '' ?>>在籍</option>
                    <option value="1" <?= $user['life'] === '1' ? 'selected' : '' ?>>離籍</option>
                </select>
                </div>
            </div>

        </div>

        <button
        class="big ui blue button"
        type="submit"
         value="更新"
        style="margin-top: 60px;">更新</button>
    </form>
        <!-- <div class="ke_logo">
            <img src="../img/stanp.png">
        </div> -->
    </div>

</div>

<?php
include("./instance/footer.php");
?>
