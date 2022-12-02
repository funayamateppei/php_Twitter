<?php

// 各種項目設定
$dbn = 'mysql:dbname=gskadai_twitter;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]) . PHP_EOL;
  exit();
}