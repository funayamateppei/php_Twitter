<?php

session_start();

require_once('./function/login_function.php');

// DB接続
require_once('./function/config.php');

$id = $_GET['id'];

// var_dump($id);
// exit();


$sql = 'SELECT * FROM tweet_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($row);
// echo '<pre>';
// exit();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DB連携型todoリスト（編集画面）</title>
</head>

<body>
  <form action="./tweet_update.php" method="POST">
    <fieldset>
      <legend>DB連携型todoリスト（編集画面）</legend>
      <a href="./tweet.php?id=<?=$id?>">戻る</a>
      <div>
        text: <input type="text" name="text" value="<?= $row['text'] ?>">
      </div>
      <input type="hidden" name='id' value="<?= $row['id'] ?>">
      <div>
        <button>submit</button>
      </div>
    </fieldset>
  </form>

</body>

</html>