<?php

// var_dump($_POST);
// exit();

$id = $_POST['id'];

require_once('../function/config.php');

$sql = 'DELETE FROM tweet_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

header("Location:../mypage.php");

?>