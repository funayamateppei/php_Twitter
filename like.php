<?php

// var_dump($_GET);

session_start();

$id = $_GET['id'];

require_once('./function/config.php');

// もしlike_tableにログインしている人と投稿のidが両方入っている
// 情報があればUPDATEなければINSERTで条件分岐するためにまず探す作業
$sqlSelect = 'SELECT * FROM like_table WHERE user_id = :user_id AND tweet_id = :tweet_id';
$stmt = $pdo->prepare($sqlSelect);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':tweet_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  $sqlInsert = 'INSERT INTO like_table (id, like_check, user_id, tweet_id, created_at, updated_at) VALUES (NULL, 1, :user_id, :tweet_id, now(), now())';
  $stmtInsert = $pdo->prepare($sqlInsert);
  $stmtInsert->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmtInsert->bindValue(':tweet_id', $id, PDO::PARAM_INT);
  $stmtInsert->execute();
} else {
  if ($row['like_check'] === 1) {
    $sqlUpdate = 'UPDATE like_table SET like_check=0, updated_at=now() WHERE user_id=:user_id AND tweet_id=:tweet_id';
  } else {
    $sqlUpdate = 'UPDATE like_table SET like_check=1, updated_at=now() WHERE user_id=:user_id AND tweet_id=:tweet_id';
  }
  $stmtUpdate = $pdo->prepare($sqlUpdate);
  $stmtUpdate->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmtUpdate->bindValue(':tweet_id', $id, PDO::PARAM_INT);
  $stmtUpdate->execute();
}

header('Location:./home.php');

?>