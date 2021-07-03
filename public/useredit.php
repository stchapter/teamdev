<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/main.css">
  <title>GEEKBOOK</title>
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

// DB接続
$pdo = db_conn();

$sql = "SELECT * FROM user_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();

//SQLエラー
if($status==false){
    sql_error($stmt);
}

//抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得

// DBより各種パラメーターを取得
$camp_list=camp_list();
$course_list=course_list();


include("./instance/header.php");

?>

<div class="m_container">

  <h2 class="editor_title">プロフィール編集</h2>

  <div>

  <?php if ($val[ipass]): ?>
          <div class="prof_logo">
            <img src="../prof/<?php echo h($val[ipass]); ?>">
          </div>
  <?php else: ?>
          <div class="prof_logo">
            <img src="../prof/noimg.png">
          </div>
  <?php endif; ?>

  </div>

  <div>
    <form method="POST" action="../src/php/profup.php" enctype="multipart/form-data" >
    <lable for="ipass">プロフィール画像</label>
    <input type="file" name="ipass" id="ipass" >
    <button type="submit" name="edit" value="画像を更新" class="ui primary button">画像を更新</button>
    </form>
  </div>




  <form method="POST" action="useredit_chk.php" enctype="multipart/form-data" >

    <div class="contents">
      <lable for="name">お名前</label><br/>
      <div class="ui input text_input">
      <input type="text" name="name" class="" id="name" value="<?php echo h($val[name]); ?>">
      </div>
    </div>

  <div class="contents_fix">

    <div class="contents">
      <lable for="camp">校舎</label>
      <div class="select">
        <select type="text" name="camp" class="" id="camp">
          <?php foreach($camp_list as $value): ?>
            <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="contents">
        <lable for="course">受講コース</label>
      <div class="select">
          <select type="text" name="course" class="" id="course">
            <?php foreach($course_list as $value): ?>
              <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
            <?php endforeach; ?>
          </select>
      </div>
    </div>
  </div>

  <div class="contents_fix">
    <div class="contents">
      <lable for="class">学期</label><br/>
      <div class="ui input text_input">
        <input type="number" name="cls" class="" id="cls" value="<?php echo h($val[cls]); ?>" >
      </div>
    </div>

    <div class="contents">
      <lable for="student">学籍番号</label><br/>
      <div class="ui input text_input">
        <input type="number" name="student" class="" id="student" value="<?php echo h($val[student]); ?>">
      </div>
    </div>
  </div>


    <div class="contents">
      <lable for="intro">自己紹介</label><br/>
      <textarea name="intro" class="m_text" id="intro" ><?php echo h($val[intro]); ?></textarea>
    </div>


  <div class="contents_fix">

    <div class="contents">
      <lable style="font-size: 16px;" for="fb">facebook</label>
      <small>　FacebookのIDのみ入力</samll><br/>
      <div class="ui input text_input">
        <input type="text" name="fb" class="" id="fb" value="<?php echo h($val[fb]); ?>">
      </div>
    </div>

    <div class="contents">
      <lable style="font-size: 16px;" for="tw">twitter</label>
      <small>　例「@acountrei」</samll><br/>
      <div class="ui input text_input">
        <input type="text" name="tw" class="" id="tw" value="<?php echo h($val[tw]); ?>">
      </div>
    </div>

  </div>

  <div class="contents_fix">

    <div class="contents">
      <lable style="font-size: 14px;" for="pw">パスワード</label>
      <small>4桁以上8桁以下の英数字</small><br/>
      <div class="ui input text_input">
        <input type="password" name="pw"class="" id="pw">
      </div>
    </div>

    <div class="contents">
      <lable style="font-size: 14px;" for="cpw">パスワード確認入力</label><br/>
      <div class="ui input text_input">
        <input type="password" name="pw_c" class="" id="pw_c">
      </div>
    </div>
  </div>

    <div class="contents">
    <!-- <div class="ui checkbox"> -->
      <lable style="font-size: 14px;" for="life">退会希望の場合はチェックをしてください</label>
      <input type="checkbox" name="life" value="1">
    </div>

    <input type="submit" value="更新" class="ui primary button" style="margin-top: 30px;">
  </form>
</div>

<?php
include("./instance/footer.php");
?>
</body>
</html>
