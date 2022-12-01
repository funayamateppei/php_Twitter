<?php

// var_dump($_POST['email']);
// exit();
session_start();

require_once('./config.php');

// メールアドレスのバリデーション
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力された値が不正です。';
  return false;
}

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  // PHP_EOL いいかんじに改行
  echo json_encode(["db error" => "{$e->getMessage()}"]) . PHP_EOL;
  exit();
}

// 
$stmt = $pdo->prepare('SELECT * FROM user_table WHERE email = :email');
$stmt->bindParam(':email', $_POST['email']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($row);
// exit();

//emailがDB内に存在しているか確認
if (!isset($row['email'])) {
  echo 'メールアドレス又はパスワードが間違っています。';
  return false;
}
//パスワード確認後sessionにメールアドレスとidとusernameを渡す
if (password_verify($_POST['password'], $row['pass'])) {
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['email'] = $row['email'];
  $_SESSION['id'] = $row['id'];
  $_SESSION['username'] = $row['username'];
} else {
  echo 'メールアドレス又はパスワードが間違っています。';
}

header('Location:./home.php');


?>