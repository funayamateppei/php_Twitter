<?php

// var_dump($_POST);
// exit();

// DB接続
if (
  !isset($_POST['text']) || $_POST['text'] === ''
) {
  exit('テキストを入力してください。');
}

$text = $_POST['text'];

require_once('./config.php');

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// SQL作成&実行
$sql = 'INSERT INTO tweet_table (id, text, user_id, created_at, updated_at) VALUES (NULL, :text, :user_id, now(), now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':user_id', '1', PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header('Location:./home.php');

?>