<?php
include_once("../src/php/funcs.php");
include_once("../src/php/db.php");
include_once("../src/php/user_db_list.php");

session_start();

// 認証下
// sschk();

$id = intval($_SESSION["id"]);
// $id = 1;
// var_dump($id);
// 本番環境ではコメントアウト
// $id = intval(24);

// DB接続
$pdo = db_conn();

// ユーザ情報を取得のためのクエリを作成
$sql = "
  SELECT
    *
  FROM
    user_table
  WHERE
    id=:id
  ;";
// echo $sql;
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
// クエリ実行
$status = $stmt->execute();

//SQLエラー
if ($status == false) {
  sql_error($stmt);
}

//user_tableからidで絞り込んだ1レコードを連想配列形式で取得
$userProf = $stmt->fetch(PDO::FETCH_ASSOC);
// v($userProf);



// 連想配列からJSON形式に変換
$userProf = json_encode($userProf, JSON_UNESCAPED_UNICODE);
// v($userProf);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ヘッダーBootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <!-- common.cssの読み込み -->

  <!-- line-awesome -->
  <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

  <!-- GBより移植 -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.js"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.8.7/semantic.min.css" media="all">
  <link rel="icon" href="../img/favicon.ico">
  <link rel="stylesheet" href="../src/css/main.css">
  <!-- ここまでGBエリア  -->

  <!-- ここのCSSはGTalkオリジナル -->
  <link rel="stylesheet" href="../src/css/my_profile.css">

  <title>マイプロフィール</title>

</head>

<body>
  <?php include("./instance/header.php"); ?>
  <main>
    <form action="../src/php/update_my_profile.php" method="POST" enctype="multipart/form-data">
      <div class="profile_flex">
        <!-- プロフィールの１番目のブロック（アイコンとメッセージ） -->
        <div class="left">
          <div class="icon">
            <div class="gs_year">
              <p>地域</p>
              <select name="admission_area" id="admission_area" required>
                <option value=""></option>
                <option value="原宿">原宿</option>
                <option value="福岡">福岡</option>
                <option value="北海道">北海道</option>
                <option value="その他">その他</option>
              </select>
            </div>
            <div class="gs_course">
              <p>コース</p>
              <select id="course_name" name="course_name" required>
                <option value=""></option>
                <option value="LAB">LAB</option>
                <option value="DEV">DEV</option>
                <option value="BIZ">BIZ</option>
                <option value="その他">その他</option>
              </select>
              <input type="text" pattern="\d{2}" maxlength="2" name="admission_period" id="admission_period" required>
              <p>期</p>
            </div>
            <div class="graduate">
              <select id="year" name="graduation_date_year" required>
                <option value=""></option>
              </select>
              <p>年</p>
              <select id="month" name="graduation_date_month" required>
                <option value=""></option>
              </select>
              <p>月</p>
              <p>卒業</p>
            </div>
            <div class="icon_area">
              <div class="icon_area_img">
                <img src="../prof/noimg.png" alt="" id="img">
                <label for="profile_image" class="icon_select">
                  <input type="file" id="profile_image" name="profile_image" accept=".jpg,.png,.jpeg" style="display: none">
                  <i class="las la-camera" id="icon_select"></i>
                  <input type="text" id="default_icon" name="default_icon" style="display:none">
                </label>
              </div>
            </div>
            <div class="icon_name_area">
              <p class="name" id="name">名前</p>
              <div class="birth">
                <p>生年月日</p>
                <select id="birth_year" name="birthday_year">
                  <option value=""></option>
                </select>
                <p>年</p>
                <select id="birth_month" name="birthday_month">
                  <option value=""></option>
                </select>
                <p>月</p>
                <select id="birth_day" name="birthday_day">
                  <option value=""></option>
                </select>
                <p>日</p>
              </div>
            </div>
          </div>
          <div class="message_area">
            <textarea id="comment" cols="30" rows="2" placeholder="ひとこと" maxlength='42' name="comment"></textarea>
          </div>
          <div class="other">
            <table class="other_table">
              <tr class="cell">
                <td class="cell_left">血液型</td>
                <td class="cell_right">
                  <select name="blood_type" id="blood_type" required>
                    <option value="1"></option>
                    <option value="3">A型</option>
                    <option value="4">B型</option>
                    <option value="6">O型</option>
                    <option value="5">AB型</option>
                    <option value="2">不明</option>
                  </select>
                </td>
              </tr>
              <tr class="cell">
                <td class="cell_left">居住地</td>
                <td class="cell_right">
                  <select name="residence" id="address" required>
                    <option value=""></option>
                  </select>
                </td>
              </tr>
              <tr class="cell">
                <td class="cell_left">出身地</td>
                <td class="cell_right">
                  <select name="birthplace" id="from" required>
                    <option value=""></option>
                  </select>
                </td>
              </tr>
              <tr class="cell">
                <td class="cell_left">性格</td>
                <td class="cell_right">
                  <select name="personality" id="personality">
                    <option value="1"></option>
                    <option value="3">熱血</option>
                    <option value="4">冷静</option>
                    <option value="5">社交的</option>
                    <option value="6">内気</option>
                    <option value="7">上品</option>
                    <option value="8">派手</option>
                    <option value="9">インドア</option>
                    <option value="10">アウトドア</option>
                    <option value="11">ポジティブ</option>
                    <option value="12">ネガティブ</option>
                    <option value="13">決断力</option>
                    <option value="14">優柔不断</option>
                    <option value="15">朝型</option>
                    <option value="16">夜型</option>
                    <option value="17">現実的</option>
                    <option value="18">物怖じしない</option>
                    <option value="19">怖がり</option>
                    <option value="19">怖がり</option>
                    <option value="20">優しい</option>
                    <option value="21">理性的</option>
                    <option value="22">感情的</option>
                    <option value="23">真面目</option>
                    <option value="24">面倒くさがり</option>
                    <option value="25">丁寧</option>
                    <option value="26">がさつ</option>
                    <option value="27">目立ちたがり</option>
                    <option value="28">控えめ</option>
                    <option value="29">積極的</option>
                    <option value="30">受け身</option>
                    <option value="31">計画的</option>
                    <option value="32">行き当たりばったり</option>
                    <option value="33">おしゃべり</option>
                    <option value="34">寡黙</option>
                    <option value="35">我慢強い</option>
                    <option value="36">革新的</option>
                    <option value="37">保守的</option>
                    <option value="38">せっかち</option>
                    <option value="39">のんびり</option>
                    <option value="40">気分屋</option>
                    <option value="41">天然</option>
                    <option value="42">負けず嫌い</option>
                    <option value="43">綺麗好き</option>
                  </select>
                </td>
              </tr>
            </table>
          </div>
          <div class="other sns_link">
            <table>
              <tr class="cell2">
                <td><i class="lab la-twitter"></i>Twitter</td>
              </tr>
              <tr class="cell2">
                <td><input type="text" name="tw" placeholder="TwitterのリンクURL"></td>
              </tr>
              <tr class="cell2">
                <td><i class="lab la-facebook"></i>Facebook</td>
              </tr>
              <tr class="cell2">
                <td><input type="text" name="fb" placeholder="FacebookのリンクURL"></td>
              </tr>
              <tr class="cell2">
                <td><i class="lab la-instagram"></i>Instagram</td>
              </tr>
              <tr class="cell2">
                <td><input type="text" name="insta" placeholder="InstagramのリンクURL"></td>
              </tr>
              <tr class="cell2">
                <td><i class="lab la-linkedin-in"></i>LinkedIn</td>
              </tr>
              <tr class="cell2">
                <td><input type="text" name="linkedin" placeholder=" LinkedInのリンクURL"></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="right">
          <!-- なぜG'sに入学したか? -->
          <div class="profile_area">
            <div class="profile_area_title">
              <p class="profile_area_name"> なぜG'sに入学したか? </p>
            </div>
            <div class="profile_area_content">
              <textarea name="why_gs" id="why_gs" cols="62" rows="5" placeholder="背景・経緯など" class="profile_description" maxlength='400'></textarea>
            </div>
          </div>
          <!-- プロフィールの２番目のブロック（ポートフォリオ） -->
          <div class="second">
            <p class="portfolio_title">ポートフォリオ・作品（３点まで）</p>
            <!-- １つ目のポートフォリオ -->
            <div class="portfolio_area" id="portfolio_area_1">
              <input type="text" name="portfolio_title1" class="portfolio_area_title" id="portfolio_area_title1" placeholder="Title">
              <input type="text" name="portfolio_url1" class="portfolio_area_url" id="portfolio_area_url1" placeholder="URL">
              <textarea name="portfolio_comment1" cols="50" rows="4" class="portfolio_area_description" id="portfolio_area_description1" placeholder="説明"></textarea>
            </div>
            <!-- ２つ目のポートフォリオ -->
            <div class="portfolio_area" id="portfolio_area_2">
              <input type="text" name="portfolio_title2" class="portfolio_area_title" id="portfolio_area_title2" placeholder="Title">
              <input type="text" name="portfolio_url2" class="portfolio_area_url" id="portfolio_area_url2" placeholder="URL">
              <textarea name="portfolio_comment2" cols="50" rows="4" class="portfolio_area_description" id="portfolio_area_description2" placeholder="説明"></textarea>
            </div>
            <!-- ３つ目のポートフォリオ -->
            <div class="portfolio_area" id="portfolio_area_3">
              <input type="text" name="portfolio_title3" class="portfolio_area_title" id="portfolio_area_title3" placeholder="Title">
              <input type="text" name="portfolio_url3" class="portfolio_area_url" id="portfolio_area_url3" placeholder="URL">
              <textarea name="portfolio_comment3" cols="50" rows="4" class="portfolio_area_description" id="portfolio_area_description3" placeholder="説明"></textarea>
            </div>
          </div>
          <!-- プロフィールの３番目のブロック -->
          <div class="third">
            <!-- フリーコメント -->
            <div class="profile_area">
              <div class="profile_area_title">
                <p class="profile_area_name"> フリーコメント </p>
              </div>
              <div class="profile_area_content">
                <textarea name="free_space" id="free_space" cols="62" rows="5" placeholder="（例）〇〇の技術を持った方を探しています。〇〇の案件に興味あります。等" maxlength='400'></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="button_area">
        <input type="submit" class="edit_button" value="保存する">
      </div>
    </form>
  </main>
  <?php
  include("./instance/footer.php");
  ?>
  <script>
    // ----------------------------------------------
    // 年月のオプションを追加
    // ----------------------------------------------
    const year = document.getElementById('year');
    const month = document.getElementById('month');
    const birth_year = document.getElementById('birth_year');
    const birth_month = document.getElementById('birth_month');
    const birth_day = document.getElementById('birth_day');
    let date = new Date
    // 卒業年月エリアのセレクトに格納
    for (let i = 2000; i <= date.getFullYear() + 1; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      year.appendChild(option);
    }
    for (let i = 1; i <= 12; i++) {
      const option = document.createElement('option');
      const i_0 = ('00' + i).slice(-2);
      option.value = i_0;
      option.textContent = i;
      month.appendChild(option);
    }
    // 誕生日エリアのセレクト
    for (let i = 1900; i <= date.getFullYear() + 1; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      birth_year.appendChild(option);
    }
    for (let i = 1; i <= 12; i++) {
      const option = document.createElement('option');
      const i_0 = ('00' + i).slice(-2);
      option.value = i_0;
      option.textContent = i;
      birth_month.appendChild(option);
    }
    for (let i = 1; i <= 31; i++) {
      const option = document.createElement('option');
      const i_0 = ('00' + i).slice(-2);
      option.value = i_0;
      option.textContent = i;
      birth_day.appendChild(option);
    }
    // ----------------------------------------------
    // 都道府県のオプションを追加
    // ----------------------------------------------
    let array = [{
      code: '1',
      name: '北海道',
      en: 'Hokkaidô'
    }, {
      code: '2',
      name: '青森県',
      en: 'Aomori'
    }, {
      code: '3',
      name: '岩手県',
      en: 'Iwate'
    }, {
      code: '4',
      name: '宮城県',
      en: 'Miyagi'
    }, {
      code: '5',
      name: '秋田県',
      en: 'Akita'
    }, {
      code: '6',
      name: '山形県',
      en: 'Yamagata'
    }, {
      code: '7',
      name: '福島県',
      en: 'Hukusima'
    }, {
      code: '8',
      name: '茨城県',
      en: 'Ibaraki'
    }, {
      code: '9',
      name: '栃木県',
      en: 'Totigi'
    }, {
      code: '10',
      name: '群馬県',
      en: 'Gunma'
    }, {
      code: '11',
      name: '埼玉県',
      en: 'Saitama'
    }, {
      code: '12',
      name: '千葉県',
      en: 'Tiba'
    }, {
      code: '13',
      name: '東京都',
      en: 'Tôkyô'
    }, {
      code: '14',
      name: '神奈川県',
      en: 'Kanagawa'
    }, {
      code: '15',
      name: '新潟県',
      en: 'Niigata'
    }, {
      code: '16',
      name: '富山県',
      en: 'Toyama'
    }, {
      code: '17',
      name: '石川県',
      en: 'Isikawa'
    }, {
      code: '18',
      name: '福井県',
      en: 'Hukui'
    }, {
      code: '19',
      name: '山梨県',
      en: 'Yamanasi'
    }, {
      code: '20',
      name: '長野県',
      en: 'Nagano'
    }, {
      code: '21',
      name: '岐阜県',
      en: 'Gihu'
    }, {
      code: '22',
      name: '静岡県',
      en: 'Sizuoka'
    }, {
      code: '23',
      name: '愛知県',
      en: 'Aiti'
    }, {
      code: '24',
      name: '三重県',
      en: 'Mie'
    }, {
      code: '25',
      name: '滋賀県',
      en: 'Siga'
    }, {
      code: '26',
      name: '京都府',
      en: 'Kyôto'
    }, {
      code: '27',
      name: '大阪府',
      en: 'Ôsaka'
    }, {
      code: '28',
      name: '兵庫県',
      en: 'Hyôgo'
    }, {
      code: '29',
      name: '奈良県',
      en: 'Nara'
    }, {
      code: '30',
      name: '和歌山県',
      en: 'Wakayama'
    }, {
      code: '31',
      name: '鳥取県',
      en: 'Tottori'
    }, {
      code: '32',
      name: '島根県',
      en: 'Simane'
    }, {
      code: '33',
      name: '岡山県',
      en: 'Okayama'
    }, {
      code: '34',
      name: '広島県',
      en: 'Hirosima'
    }, {
      code: '35',
      name: '山口県',
      en: 'Yamaguti'
    }, {
      code: '36',
      name: '徳島県',
      en: 'Tokusima'
    }, {
      code: '37',
      name: '香川県',
      en: 'Kagawa'
    }, {
      code: '38',
      name: '愛媛県',
      en: 'Ehime'
    }, {
      code: '39',
      name: '高知県',
      en: 'Kôti'
    }, {
      code: '40',
      name: '福岡県',
      en: 'Hukuoka'
    }, {
      code: '41',
      name: '佐賀県',
      en: 'Saga'
    }, {
      code: '42',
      name: '長崎県',
      en: 'Nagasaki'
    }, {
      code: '43',
      name: '熊本県',
      en: 'Kumamoto'
    }, {
      code: '44',
      name: '大分県',
      en: 'Ôita'
    }, {
      code: '45',
      name: '宮崎県',
      en: 'Miyazaki'
    }, {
      code: '46',
      name: '鹿児島県',
      en: 'Kagosima'
    }, {
      code: '47',
      name: '沖縄県',
      en: 'Kagosima'
    }, {
      code: '49',
      name: 'その他',
      en: ''
    }, ];
    const address = document.getElementById('address');
    const from = document.getElementById('from');
    array.forEach(target => {
      const option = document.createElement('option');
      option.value = target.code;
      option.textContent = target.name;
      address.appendChild(option);
    })
    array.forEach(target => {
      const option = document.createElement('option');
      option.value = target.code;
      option.textContent = target.name;
      from.appendChild(option);
    })
    // ----------------------------------------------
    // アイコン画像のプレビューを表示
    // ----------------------------------------------
    // 1.input[type=file]とアイコン画像のDOM
    const profile_image = document.getElementById('profile_image');
    const img = document.getElementById('img');
    const default_icon = document.getElementById('default_icon');

    // プレビュー関数
    function imgPreview(file) {
      // FileReaderオブジェクトを作成
      const reader = new FileReader();
      // URLとして読み込まれたときに実行する処理
      reader.onload = function(e) {
        const img_url = e.target.result;
        img.src = img_url;
      }
      // ファイルをURLとして読み込む
      reader.readAsDataURL(file);
    }

    // 2.fileデータの取得
    const file = () => {
      const file_data = profile_image.files;
      imgPreview(file_data[0]);
    }

    // イベントを追加
    profile_image.addEventListener('change', file);

    // ----------------------------------------------
    // json_dataの取得
    // ----------------------------------------------
    // 1.user_infoの取得
    const json1 = <?= $userProf ?>;
    const json1_str = JSON.stringify(json1);
    const user_info = JSON.parse(json1_str);
    console.log(user_info);
    // デフォルトの画像をセット
    default_icon.value = user_info.profile_image;
    // selectに該当のvalueがあった際の関数
    function select_tab(option, object) {
      // objectがundefinedでなければ
      if (object != undefined) {
        //HTMLCollectionをNodeList的に変換
        Array.from(option).forEach(option_child => {
          if (option_child.value == object) {
            option_child.selected = true;
          }
        })
      }
    }

    // inputに該当のvalueを挿入する関数
    function input_insert(input, object) {
      if (object != undefined) {
        input.value = object;
      }
    }

    // 2.admission_areaのvalueを選択
    const admission_area = document.getElementById('admission_area').children;
    select_tab(admission_area, user_info.camp);
    // 3.admission_areaとadmission_periodのvalueを選択
    const course_name = document.getElementById('course_name').children;
    select_tab(course_name, user_info.course);
    const admission_period = document.getElementById('admission_period');
    input_insert(admission_period, user_info.cls);
    // 4.graduateのvalueを選択
    const select_year = document.getElementById('year').children;
    const select_month = document.getElementById('month').children;
    const graduate = user_info.graduation_date.split('-');
    select_tab(select_year, graduate[0]);
    select_tab(select_month, graduate[1]);
    // 5.iconのsrcを選択
    const icon_img = document.getElementById('img');
    const file_name = "../prof/"
    // アイコン画像をDBに登録していれば
    console.log(user_info.ipass)
    if (user_info.ipass != undefined) {
      icon_img.src = file_name + user_info.ipass;
    }
    //6.birthのvalueを選択
    const select_birth_year = document.getElementById('birth_year');
    const select_birth_month = document.getElementById('birth_month');
    const select_birth_day = document.getElementById('birth_day');
    const birth = user_info.birthday.split('-');
    select_tab(select_birth_year, birth[0]);
    select_tab(select_birth_month, birth[1]);
    console.log(birth[1]);
    select_tab(select_birth_day, birth[2]);
    //7.birthのvalueを選択
    const comment = document.getElementById('comment');
    input_insert(comment, user_info.comment);
    //8.blood_typeのvalueを選択
    const blood_type = document.getElementById('blood_type');
    select_tab(blood_type, user_info.blood_type);
    //9.residenceのvalueを選択
    const residence = document.getElementById('address');
    select_tab(residence, user_info.residence);
    //10.birthplaceのvalueを選択
    const birthplace = document.getElementById('from');
    select_tab(birthplace, user_info.birthplace);
    // //11.annual_incomeのvalueを選択
    // const annual_income = document.getElementById('annual_income');
    // select_tab(annual_income, user_info.annual_income);
    //12.english_skillのvalueを選択
    const english_skill = document.getElementById('english_skill');
    select_tab(english_skill, user_info.english_skill);
    //12.english_skillのvalueを選択
    const personality = document.getElementById('personality');
    select_tab(personality, user_info.personality);
    //13.why_gsのvalueを選択
    const why_gs = document.getElementById('why_gs');
    input_insert(why_gs, user_info.why_gs);
    // 14.portfolioのDOM
    const portfolio_area_title1 = document.getElementById('portfolio_area_title1');
    const portfolio_area_url1 = document.getElementById('portfolio_area_url1');
    const portfolio_area_description1 = document.getElementById('portfolio_area_description1');
    input_insert(portfolio_area_title1, user_info.portfolio_title1);
    input_insert(portfolio_area_url1, user_info.portfolio_url1);
    input_insert(portfolio_area_description1, user_info.portfolio_comment1);
    const portfolio_area_title2 = document.getElementById('portfolio_area_title2');
    const portfolio_area_url2 = document.getElementById('portfolio_area_url2');
    const portfolio_area_description2 = document.getElementById('portfolio_area_description2');
    input_insert(portfolio_area_title2, user_info.portfolio_title2);
    input_insert(portfolio_area_url2, user_info.portfolio_url2);
    input_insert(portfolio_area_description2, user_info.portfolio_comment2);
    const portfolio_area_title3 = document.getElementById('portfolio_area_title3');
    const portfolio_area_url3 = document.getElementById('portfolio_area_url3');
    const portfolio_area_description3 = document.getElementById('portfolio_area_description3');
    input_insert(portfolio_area_title3, user_info.portfolio_title3);
    input_insert(portfolio_area_url3, user_info.portfolio_url3);
    input_insert(portfolio_area_description3, user_info.portfolio_comment3);
    // 18.free_spaceのvalueを選択
    const free_space = document.getElementById('free_space');
    input_insert(free_space, user_info.free_space);
    // 19.nameのtextContent挿入
    const name = document.getElementById('name');
    name.textContent = user_info.name;
    //20.SNSのリンク
    const sns = {
      tw: document.querySelector('input[name="tw"]'),
      fb: document.querySelector('input[name="fb"]'),
      insta: document.querySelector('input[name="insta"]'),
      linkedin: document.querySelector('input[name="linkedin"]')
    }
    input_insert(sns.tw, user_info.tw)
    input_insert(sns.fb, user_info.fb)
    input_insert(sns.insta, user_info.insta)
    input_insert(sns.linkedin, user_info.linkedin)
  </script>

</body>

</html>
