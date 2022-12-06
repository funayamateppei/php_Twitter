<?php

session_start();

if (!isset($_POST) || $_POST['text'] === '') {
  header("Location:./tweet_home.php?id={$_POST['tweetId']}");
  return false;
}

// var_dump($_POST);
// exit();

require_once('./config.php');

$sql = 'INSERT INTO reply_table (id, text, user_id, username, tweet_id, created_at, updated_at) VALUES (NULL, :text, :user_id, :username, :tweet_id, now(), now())';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':text', $_POST['text'], PDO::PARAM_STR);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':username', $_SESSION['username'], PDO::PARAM_STR);
$stmt->bindValue(':tweet_id', $_POST['tweetId'], PDO::PARAM_INT);
$stmt->execute();

header("Location:./reply.php?id={$_POST['tweetId']}");

?>