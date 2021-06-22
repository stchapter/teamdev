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

  <header>
  <div class="header_container">

    <div class="header_logo_container">
      <div class="header_logo">
        <img src="../img/topImg.png">
      </div>
      <p class="login_name">ログインしている人の名前　さん</p>
    </div>


    <div class="header_button">
      <div class="header_button_container">
        <div class="blue ui buttons">
          <a class="ui button">TOPへ</a>
          <a class="ui button">登録修正</a>
          <a class="ui button">新規投稿</a>
          <a class="ui button">自分の投稿</a>
          <a class="ui button">Bookmark</a>
  	  <div class="header_button_R">
            <a class="ui button">Logout</a>
	  </div>
        </div>
      </div>
    </div>

  </div>
  </header>

  <div class="main_container">

  <div class="main_left">
    <div class="ui vertical menu">
      <div class="item">
        <div class="header"><font style="vertical-align: inherit;">人気の言語</font></div>
        <div class="menu">
          <a class="item"><font style="vertical-align: inherit;">JavaScript</font></a>
          <a class="item"><font style="vertical-align: inherit;">PHP</font></a>
          <a class="item"><font style="vertical-align: inherit;">Python</font></a>
        </div>
      </div>
   </div>

  </div>

  <div class="main_right">

    <div class="search_container">
      <div class="ui fluid action input">
        <input type="text" placeholder="検索する">
        <div class="ui button">Search</div>
      </div>
    </div>
  <!-- ↑ search_container -->

    <div class="new_container">

      <div class="new_result">
      <a href="#" class="new_title">【JS】ガチで学びたい人のためのJavaScriptメカニズム</a>
      <p class="new_p">JavaScriptでの開発が苦手ですか？JSのメカニズムを学べば「これまでとは全く違うJSの世界」が見えてきます。React、Vue、JQuery、Firebaseを勉強したいと思っている人は、是非メカニズムから始めてみてください。</p>
      <div class="new_userview">
        <p class="new_person">投稿者：〇〇さん</p>
        <p class="new_review">評価：☆☆☆★★</p>
      </div>
      <div class="ui label"><font style="vertical-align: inherit;">JavaScript</font></div>
      </div>
      <div class="new_result">
      <a href="#" class="new_title">PHP+MySQL（MariaDB） Webサーバーサイドプログラミング入門</a>
      <p class="new_p">本格的なWebシステム開発に欠かせない、サーバーサイドプログラミングをPHP+MySQLで学ぼう。</p>
      <div class="new_userview">
        <p class="new_person">投稿者：〇〇さん</p>
        <p class="new_review">評価：☆☆★★★</p>
      </div>
      <div class="ui label"><font style="vertical-align: inherit;">PHP</font></div>
      <div class="ui label"><font style="vertical-align: inherit;">MySQL</font></div>
      </div>
      <div class="new_result">
      <a href="#" class="new_title">モダンJavaSciptの基礎から始める挫折しないためのReact入門</a>
      <p class="new_p">Reactの習得に苦戦する理由は「JavaScript」への理解不足です。このコースではスムーズにReact開発のスタート地点に立てるように、モダンJavaScriptの動作の仕組みや概念、機能から解説します。</p>
      <div class="new_userview">
        <p class="new_person">投稿者：〇〇さん</p>
        <p class="new_review">評価：☆★★★★</p>
      </div>
      <div class="ui label"><font style="vertical-align: inherit;">JavaScript</font></div>
      <div class="ui label"><font style="vertical-align: inherit;">React</font></div>
      </div>

    </div>
  <!-- ↑　new_container -->


  </div>
  <!-- ↑　main_right -->

  </div>

    <footer>
    <div class="footer">
      <p>copyright ©️ GEEKBOOK <br> For G's Academy</p>
    </div>
  </footer>

</body>
</html>
