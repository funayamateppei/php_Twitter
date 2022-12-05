<?php

session_start();

// DB接続
require_once('./config.php');

// SQL実行作成取得
$stmt = $pdo->prepare('SELECT * FROM user_table WHERE id = :id');
$stmt->bindValue(':id', $_SESSION['id']);
$stmt->execute();
$rowUser = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($rowUser);
// exit();

$stmt = $pdo->prepare('SELECT * FROM tweet_table WHERE user_id = :id');
$stmt->bindValue(':id', $_SESSION['id']);
$stmt->execute();
$rowTweet = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($rowTweet);
// exit();

$htmlElements = '';
// 繰り返し文で表示する用の文字列を作成
foreach ($rowTweet as $v) {
  // var_dump($v['username']);
  // exit();
  $htmlElements .= "
<div class='item'>
  <img src='./img/人物アイコン.png' alt='画像'>
  <div class='sentence'>
    <div class='who'>
      <p class='username'>{$v['username']}</p>
      <p class='tweetTime'>{$v['created_at']}</p>
    </div>
    <p>{$v['text']}</p>
    <a href='./tweet.php?id={$v['id']}'>投稿画面へ</a>
  </div>
</div>
  ";
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/mypage.css">
  <title>Document</title>
</head>

<body>
  <header>マイページ</header>
  <h1>アカウント情報</h1>
  <div class="headerImg">
    <!-- ヘッダー画像を挿入 -->
    <!-- 設定されていないならグレーの画面を表示する -->
  </div>
  <div class="topImg">
    <!-- トプ画を表示する -->
    <!-- 登録されていないなら初期のアイコンを表示する -->
  </div>
  <div class="userInfo">
    <p>ユーザー名</p>
    <p><?= $rowUser['username'] ?></p>
    <p>メールアドレス</p>
    <p><?= $rowUser['email'] ?></p>
    <p>フリーテキストを表示/登録されていないなら何も表示しない</p>
  </div>


  <div id="display">
    <?= $htmlElements ?>
  </div>

</body>

</html>