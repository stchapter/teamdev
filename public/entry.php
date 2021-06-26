<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/login.css">
  <title>GEEKBOOK</title>
</head>
<body>
<?php
include("../src/php/funcs.php");
include("../src/php/db.php");
include("../src/php/user_db_list.php");

// DBよりパラメーターを取得
$camp_list=camp_list();
$course_list=course_list();
$kw_c=kw_c();
?>

<div class="container_e">

  <form method="POST" action="entry_chk.php">

<!--
            <p>タイトル</p>
                <input type="text" name="title"  class="validate required max64" placeholder="64文字以内で入力してください" value=<?=h($row["title"])?>>
                </div>
            </div> -->

    <!-- <div> -->
      <div class="contents" style="margin: 30px auto 0 auto;">
        <lable for="kw">認証コード</label><br/>
        <small>学校発行の認証コードを入力してください</small><br/>
        <div class="ui input text_input">
          <input type="password" name="kw" class="" id="kw">
        </div>
      </div>

    <h2 class="title">ユーザー登録</h2>

    <div class="contents">
      <label for="name">お名前</label><br/>
      <div class="ui input text_input">
        <input type="text" name="name" class="" id="name">
      </div>
    </div>

    <div class="contents_fix">

    <div class="contents">
      <label for="camp">校舎</label><br/>
      <div class="select">
        <select type="text" name="camp" class="" id="camp">
          <?php foreach($camp_list as $value): ?>
            <option value="<?php echo h($value); ?>"><?php echo h($value); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="contents">
      <label for="course">受講コース</label><br/>
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
        <input type="number" name="cls" class="" id="cls">
      </div>
    </div>

    <div class="contents">
      <lable for="student">学籍番号</label><br/>
      <div class="ui input text_input">
      <input type="number" name="student" class="" id="student">
    </div>
    </div>

    </div>

    <div class="contents">
      <lable for="mail">メールアドレス</label><br/>
      <div class="ui input text_input">
      <input type="text" name="mail"class="" id="mail">
    </div>
    </div>

    <div class="contents_fix">

    <div class="contents">
      <lable for="pw">パスワード</label>
      <small>　4桁以上8桁以下の英数字</small><br/>
      <div class="ui input text_input">
      <input type="password" name="pw"class="" id="pw">
    </div>
    </div>


    <div class="contents">
      <lable for="cpw">パスワード確認入力</label><br/>
      <div class="ui input text_input">
      <input type="password" name="pw_c" class="" id="pw_c">
    </div>
    </div>
    </div>

    <input
    type="submit"
    value="登録"
    class="cost_submit big ui primary button"
    style="margin-top: 20px;">

  </form>
</div>

<?php
include("./instance/footer.php");
?>
