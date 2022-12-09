<?php

// var_dump($_POST);
// exit();

// DB接続
require_once('./function/config.php');

// データ受け取り
$id = $_POST['id'];
$text = $_POST['text'];

// SQL準備実行取得
$sql = 'UPDATE tweet_table SET text=:text, updated_at=now() WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header('Location:./mypage.php');

?>