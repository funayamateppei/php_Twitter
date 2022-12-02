<?php

// DB接続
require_once('./config.php');

// SQL実行作成取得
$stmt = $pdo->prepare('SELECT * FROM user_table WHERE id = :id');
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

var_dump($row);
exit();

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
  
</body>
</html>