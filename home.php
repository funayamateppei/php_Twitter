<?php

// sessionを使うところでは必ず最初にsession_start()しないと使えない！
session_start();

// var_dump($_SESSION);
// exit();

// もしsessionが設定されていないいならログインページにとばす
if(isset($_SESSION)){
$welcome = "ようこそ、".$_SESSION['username']."さん！";
}else{
header('Location:./login.php');
exit();
}

require_once('./config.php');

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  // PHP_EOL いいかんじに改行
  echo json_encode(["db error" => "{$e->getMessage()}"]) . PHP_EOL;
  exit();
}

// SQL作成&実行 ツイート全て取得
$sql = 'SELECT id, text, user_id, username, created_at FROM tweet_table ORDER BY created_at ASC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($row);
// echo '</pre>';


$htmlElements = '';
foreach ($row as $v) {
  // var_dump($v['username']);
  // exit();
  $htmlElements .= "
      <div class='item'>
        <img src='./wooden-board-empty-table-top-on-of-blurred-background.jpg' alt='画像'>
        <div class='sentence'>
          <div class='who'>
            <p class='username'>{$v['username']}</p>
            <p class='tweetTime'>{$v['created_at']}</p>
          </div>
          <p>{$v['text']}</p>
        </div>
      </div>
        ";
}

// var_dump($htmlElements);
// exit();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/home.css">
  <title>php</title>
</head>

<body>
  <div id="home">

    <!-- ヘッダー -->
    <header>
      <?= $welcome ?>
    </header>

    <div class="homeDisplay">
      <!-- サイドバー -->
      <div id="sideBar">
        マイページとかのメニュー欄
      </div>
      <!-- タイムライン -->
      <div id="display">
        <!-- 繰り返し文で表示 -->
        <?= $htmlElements ?>
        <!-- <div class="item">
          <img src="./wooden-board-empty-table-top-on-of-blurred-background.jpg" alt="画像">
          <div class="sentence">
            <div class="who">
              <p class="username">名前だお</p>
              <p class="tweetTime">ツイート時間表示</p>
            </div>
            <p>ツイートの内容</p>
          </div>
        </div> -->
      
      </div>
      <!-- 掲示板 -->
      <div id="bbs">
        集り募集の掲示板みたいなやつ
      </div>
    </div>

  </div>

  <!-- 投稿form表示ボタン -->
  <div id="formBtn">
    <button>＋</button>
  </div>

  <!-- 投稿 -->
  <div id="tweet">
    <form action="./tweet_create.php" method="POST">
      <p id="tweetClose">キャンセル</p>
      <textarea name="text" id="tweet" cols="50" rows="15" placeholder="いまどうしてる？"></textarea>
      <button>ツイート</button>
    </form>
  </div>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    $('#formBtn button').on('click', () => {
      $('#tweet').fadeIn();
      $('#tweet form').fadeIn();
      $('#tweet form textarea').fadeIn();
    })

    $('#tweetClose').on('click', () => {
      $('#tweet').fadeOut();
      $('#tweet form').fadeOut();
      $('#tweet form textarea').fadeOut();
    })
  </script>
</body>

</html>