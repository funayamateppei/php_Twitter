<?php

// var_dump($_POST);
// exit();

// jsでファイルを選択しないと送れないようにしているけど一応確認
if (!isset($_FILES) || $_FILES === '') {
header('Location:./myPage.php');
}

// var_dump($_FILES);
// exit();

// セッションすたーーーーーーーーーーーと
session_start();

// 画像ファイルをimagesフォルダに保存し、PathをDBに保存する
$imgUrl = '';
if (!empty($_FILES)) {
  // $_FILES['image']['name']もとのファイルの名前
  // $_FILES['image']['tmp_name']サーバーにあるファイルの名前
  $filename = $_SESSION['id'] . '-' . Date('Ymdhis');
  $uploaded_path = './images/' . $filename;
  $imgUrl .= $uploaded_path;
  move_uploaded_file($_FILES['img']['tmp_name'], $uploaded_path);
}

// DB接続
require_once('./function/config.php');

// もしmyPage_tableにログインしている人の情報があればUPDATE
// なければINSERTで条件分岐するためにまず探す作業
$sqlSelect = 'SELECT * FROM myPage_table WHERE user_id = :user_id';
$stmt = $pdo->prepare($sqlSelect);
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  $sqlInsert = 'INSERT INTO myPage_table (id, user_id, img, freetext, created_at, updated_at) VALUES (NULL, :user_id, :img, :freeText, now(), now())';
  $stmtInsert = $pdo->prepare($sqlInsert);
  $stmtInsert->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmtInsert->bindValue(':img', $imgUrl, PDO::PARAM_STR);
  $stmtInsert->bindValue(':freeText', '', PDO::PARAM_STR);
  $stmtInsert->execute();
} else {
  $sqlUpdate = 'UPDATE myPage_table SET img=:img, updated_at=now() WHERE user_id=:user_id';
  $stmtUpdate = $pdo->prepare($sqlUpdate);
  $stmtUpdate->bindValue(':img', $imgUrl, PDO::PARAM_STR);
  $stmtUpdate->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmtUpdate->execute();
}

header('Location:./myPage.php');

?>