<?php

// var_dump($_GET);
// exit();

session_start();

require_once('./function/login_function.php');

require_once('./function/config.php');

$id = $_GET['id'];

// var_dump($id);
// exit();

// SQL実行
$sql = 'SELECT * FROM tweet_table WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row1 = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($row);
// exit();

$htmlElements = '';

$sqlReply = 'SELECT * FROM reply_table WHERE tweet_id = :id ORDER BY created_at ASC';
$stmtReply = $pdo->prepare($sqlReply);
$stmtReply->bindValue(':id', $id, PDO::PARAM_INT);
$stmtReply->execute();
$row2 = $stmtReply->fetchAll(PDO::FETCH_ASSOC);

// var_dump($row2);
// exit();

$htmlElements = '';

if (count($row2) !== 0) {
  foreach ($row2 as $v) {
    $htmlElements .= "
      <div class='item'>
        <img src='./img/人物アイコン.png' alt='画像'>
        <div class='sentence'>
          <div class='who'>
            <p class='username'> {$v['username']} </p>
            <p class='tweetTime'> {$v['created_at']} </p>
          </div>
          <p> {$v['text']} </p>
        </div>
      </div>
    ";
  }
}



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
    <a href="./myPage.php">戻る</a>
    <div class='item'>
      <img src='./img/人物アイコン.png' alt='画像'>
      <div class='sentence'>
        <div class='who'>
          <p class='username'> <?= $row1['username'] ?> </p>
          <p class='tweetTime'> <?= $row1['created_at'] ?></p>
        </div>
        <p><?= $row1['text'] ?></p>
        <a href="./delete/tweet_delete_cfm.php?id=<?=$id?>">削除</a>
        <a href='./tweet_edit.php?id=<?=$row1['id']?>'>編集画面へ</a>
      </div>
    </div>
  </div>

  <div id="replyTweet">
    <!-- reply tweet を表示する -->
    <?=$htmlElements?>
  </div>

</body>

</html>