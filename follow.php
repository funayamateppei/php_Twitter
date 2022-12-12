<?php

session_start();

require_once('./function/login_function.php');

require_once('./function/config.php');
// ログインしているユーザーがフォローしているユーザーの情報を取得
// ログイン中のユーザーがフォローしているデータを follow_table から取得
// 取得したデータと user_table のデータを一致させる JOIN
$sql = 'SELECT * FROM follow_table LEFT OUTER JOIN (SELECT id, username FROM user_table) AS user_table2 ON follow_table.your_id = user_table2.id WHERE follow_table.my_id = :my_id';
// id カラムが重複していてJOINできなかった
// 次回からは気をつけるように！
// $sql1 = "SELECT user_id, img FROM myPage_table LEFT OUTER JOIN ($sql) AS follow_table2 ON myPage_table.user_id = follow_table2.my_id ORDER BY follow_table2.created_at ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':my_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetchALL(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($row);
// echo '</pre>';
// exit();

$htmlElements = '';
foreach($row as $v) {
  $sql = 'SELECT user_id, img FROM myPage_table WHERE user_id=:user_id';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_id', $v['your_id'], PDO::PARAM_INT);
  $stmt->execute();
  $value = $stmt->fetch(PDO::FETCH_ASSOC);

  // var_dump($value);

  if (!isset($value['img'])) {
    $img = './img/人物アイコン.png';
  } else if ($value['img']) {
    $img = $value['img'];
  }

  $htmlElements .= "
    <div class='item'>
      <img src='{$img}' alt='画像'>
      <div class='sentence'>
          <p class='username'>{$v['username']}</p>
          <div>
            <a href='./follow_update.php?id={$v['id']}'>フォロー解除</a>
            <a href='./user.php?id={$v['id']}'>ユーザーページへ</a>
          </div>
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
  <link rel="stylesheet" href="./css/search.css">
  <title>Document</title>
</head>

<body>
  <a id='homeBack' href="./myPage.php">戻る</a>

  <header>
    フォロー
  </header>

  <div id="display">
    <!-- 表示する -->
    <?= $htmlElements ?>
  </div>
</body>

</html>