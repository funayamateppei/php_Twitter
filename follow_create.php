<?php

// var_dump($_GET);
// exit();

session_start();

require_once('./function/config.php');

$id = $_GET['id'];

$sql = 'SELECT COUNT(*) FROM follow_table WHERE my_id = :my_id AND your_id = :your_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':my_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':your_id', $id, PDO::PARAM_INT);
$stmt->execute();
$count = $stmt->fetchColumn();

// var_dump($count);
// exit();

if ($count !== 0) {
  $sql = 'DELETE FROM follow_table WHERE my_id=:my_id AND your_id=:your_id';
} else {
  $sql = 'INSERT INTO follow_table (id, my_id, your_id) VALUES (NULL, :my_id, :your_id)';
}
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':my_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->bindValue(':your_id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location:./search.php?search_str=$_GET[search_str]");

?>