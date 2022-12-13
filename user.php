<?php

session_start();

require_once('./function/login_function.php');

// DB接続
require_once('./function/config.php');

$id = $_GET['id'];


// ログインしているユーザー情報を取得
// $stmt = $pdo->prepare('SELECT * FROM user_table WHERE id = :id');
// $stmt->bindValue(':id', $_SESSION['id']);
// $stmt->execute();
// $rowUser = $stmt->fetch(PDO::FETCH_ASSOC);

// フリーテキストとTOP画像を取得
// $stmtMyPage = $pdo->prepare('SELECT * FROM myPage_table WHERE user_id = :user_id');
// $stmtMyPage->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
// $stmtMyPage->execute();
// $rowMyPage = $stmtMyPage->fetch(PDO::FETCH_ASSOC);

// ログインしているユーザー情報とマイページ登録情報をJOINでまとめた
$sql = "SELECT * FROM user_table LEFT OUTER JOIN (SELECT * FROM myPage_table) AS myPage_table2 ON user_table.id = myPage_table2.user_id AND user_table.id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$rowUser = $stmt->fetch(PDO::FETCH_ASSOC);

$freeText = '';
if ($rowUser['freetext'] !== NULL) {
  $freeText .= $rowUser['freetext'];
}
// もし登録されているなら登録されている画像 それ以外はデフォ画像
$img = '';
if ($rowUser['img'] === NULL) {
  $img .= './img/人物アイコン.png';
} else {
  $img .= $rowUser['img'];
}


// ログインしているユーザーの投稿を全て取得
$stmt = $pdo->prepare('SELECT * FROM tweet_table WHERE user_id = :id');
$stmt->bindValue(':id', $id);
$stmt->execute();
$rowTweet = $stmt->fetchAll(PDO::FETCH_ASSOC);

$htmlElements = '';
// 繰り返し文で表示する用の文字列を作成
foreach ($rowTweet as $v) {
  // 返信の数を数える
  $sqlReply = 'SELECT * FROM reply_table WHERE tweet_id=:id';
  $stmtReply = $pdo->prepare($sqlReply);
  $stmtReply->bindValue(':id', $v['id'], PDO::PARAM_INT);
  $stmtReply->execute();
  $reply = $stmtReply->fetchAll(PDO::FETCH_ASSOC);

  // 返信数を数える
  $replyCount = count($reply);

  // ツイートした日時のフォーマットを変更
  $date = date('Y年n月j日 H:i', strtotime($v['created_at']));

  $htmlElements .= "
    <div class='item'>
      <img src='{$img}' alt='画像'>
      <div class='sentence'>
        <div class='who'>
          <p class='username'>{$v['username']}</p>
          <p class='tweetTime'>{$date}</p>
          <p class='replyCount'>返信数 : {$replyCount}</p>
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
  <a id='homeBack' href="./search.php?search_str=<?=$_GET['search_str']?>">戻る</a>

  <header>
    ユーザーページ
  </header>

  <div class="user">
    <div class="flex">
      <div class="topImg">
            <img src="<?= $img ?>">
      </div>

      <div class="userInfo">
        <div class="username">
          <p>ユーザー名</p>
          <p><?= $rowUser['username'] ?></p>
        </div>
        <div class="email">
          <p>メールアドレス</p>
          <p><?= $rowUser['email'] ?></p>
        </div>
        <div id="follow">
          <!-- フォロー中ーーーーーーーーーーーー -->
        </div>
      </div>
    </div>

    <div class="free">
      <p>
        <!-- php フリーテキスト表示 -->
        <?= $freeText ?>
      </p>
    </div>
  </div>


  <div id="display">
    <?= $htmlElements ?>
  </div>