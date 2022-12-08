<?php

// var_dump($_GET);
// exit();

session_start();

// ログイン状態のチェック関数
if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
  header('Location:../login.php');
  exit();
} else {
  session_regenerate_id(true);
  $_SESSION["session_id"] = session_id();
}

$id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  本当に削除して良いですか？
  <form action="./tweet_delete.php" method='POST'>
    <input type="hidden" name='id' value="<?=$id?>">
    <button>YES</button>
  </form>
  <a href="../tweet.php?id=<?=$id?>">NO</a>

</body>
</html>