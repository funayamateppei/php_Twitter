<?php

session_start();
require_once('./function/login_function.php');

require_once('./function/config.php');

$str = '';
$htmlElements = array();

// 本当はajaxをkeyupイベントで起動してリアルタイム検索したかった。。。

if (isset($_POST['search_str'])) {
  if ($_POST['search_str'] !== '') {
    $str = $_POST['search_str'];

    //  検索でユーザー名の部分一致でひっかかったものdataを取得（user_table）
    //  ユーザー情報とマイページ登録情報(TOP画像)をJOINでまとめる (myPage_table)
    // フォローしているかも判断するためにfollow_tableもJOIN 
    // user_table  myPage_table follow_table JOINする必要がある

    // myPage_table + follow_table
    // $sql1 = "SELECT * FROM myPage_table LEFT JOIN (SELECT my_id, your_id FROM follow_table) AS follow_table2 ON myPage_table.user_id = follow_table2.your_id WHERE follow_table2.my_id = :id";
    // $sql = "SELECT * FROM user_table LEFT JOIN ($sql1) AS myPage_table2 ON user_table.id = myPage_table2.user_id WHERE user_table.username LIKE CONCAT('%',:str,'%') ORDER BY user_table.username ASC";
    $sql = "SELECT * FROM user_table LEFT JOIN (SELECT user_id, img FROM myPage_table) AS myPage_table2 ON user_table.id = myPage_table2.user_id WHERE user_table.username LIKE CONCAT('%',:str,'%') ORDER BY user_table.username ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':str', $str, PDO::PARAM_STR);
    $stmt->execute();
    $rowUser = $stmt->fetchALL(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // var_dump($rowUser);
    // echo '</pre>';
    // exit();

    // var_dump($count);
    // exit();

    foreach ($rowUser as $v) {
      $sql = "SELECT COUNT(*) FROM follow_table WHERE my_id = :my_id AND your_id = :your_id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':my_id', $_SESSION['id'], PDO::PARAM_INT);
      $stmt->bindValue(':your_id', $v['id'], PDO::PARAM_INT);
      $stmt->execute();
      $value = $stmt->fetchColumn();
      if ($value !== 0) {
        $follow = 'フォロー解除';
      } else {
        $follow = 'フォローする';
      }
      // もし登録されているなら登録されている画像 それ以外はデフォ画像
      $img = '';
      if ($v['img'] === NULL) {
        $img .= './img/人物アイコン.png';
      } else {
        $img .= $v['img'];
      }
      array_push($htmlElements, "
        <div class='item'>
          <img src='{$img}' alt='画像'>
          <div class='sentence'>
              <p class='username'>{$v['username']}</p>
              <div>
                <a href='./follow_create.php?id={$v['id']}&search_str={$str}'>{$follow}</a>
                <a href='./user.php?id={$v['id']}'>ユーザーページへ</a>
              </div>
          </div>
        </div>
      "
      );
    }
    echo json_encode($htmlElements, JSON_UNESCAPED_UNICODE);
  }
}
