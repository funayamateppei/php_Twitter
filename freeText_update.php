<?php

// var_dump($_POST);
// exit();

if (!isset($_POST['text']) || $_POST['text'] === '') {
  header('Location:./myPage.php');
}

$text = $_POST['text'];

// var_dump($text);
// exit();

session_start();

require_once('./function/config.php');

// もしmyPage_tableにログインしている人の情報があればUPDATE
// なければINSERTで条件分岐するためにまず探す作業
$sqlSelect = 'SELECT * FROM myPage_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sqlSelect);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($result);
// exit();

if (!$result) {
  $sqlInsert = 'INSERT INTO myPage_table (id, user_id, img, freetext, created_at, updated_at) VALUES (NULL, :user_id, :img, :freeText, now(), now())';
  $stmtInsert = $pdo->prepare($sqlInsert);
  $stmtInsert->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmtInsert->bindValue(':img', '', PDO::PARAM_STR);
  $stmtInsert->bindValue(':freeText', $text, PDO::PARAM_STR);
  $stmtInsert->execute();
} else {
  $sqlUpdate = 'UPDATE myPage_table SET freetext=:freetext, updated_at=now() WHERE user_id=:user_id';
  $stmtUpdate = $pdo->prepare($sqlUpdate);
  $stmtUpdate->bindValue(':freetext', $text, PDO::PARAM_STR);
  $stmtUpdate->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmtUpdate->execute();
}

header('Location:./myPage.php');






?>