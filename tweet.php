<?php

// var_dump($_GET);
// exit();

session_start();

require_once('./config.php');

$id = $_GET['id'];

// SQL実行
$sql = 'SELECT * FROM tweet_table WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row1 = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($row);
// exit();

$htmlElements = '';



?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/tweet.css">
  <title>Document</title>
</head>

<body>

  <div id="display">
    <div class='item'>
      <img src='./img/人物アイコン.png' alt='画像'>
      <div class='sentence'>
        <div class='who'>
          <p class='username'> <?= $row1['username'] ?> </p>
          <p class='tweetTime'> <?= $row1['created_at'] ?></p>
        </div>
        <p><?= $row1['text'] ?></p>
        <a href='./tweet_edit.php?id=<?=$row1['id']?>'>編集画面へ</a>
      </div>
    </div>
  </div>

  <div class="replyTweet">
    <!-- reply tweet を表示する -->
  </div>

</body>

</html>