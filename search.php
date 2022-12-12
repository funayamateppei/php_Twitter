<?php

session_start();
require_once('./function/login_function.php');

require_once('./function/config.php');

$str = '';
$htmlElements = '';

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
      $htmlElements .= "
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
      ";
    }
  }
}




if (isset($_GET['search_str'])) {
  if ($_GET['search_str'] !== '') {
    $str = $_GET['search_str'];

    //  検索に部分一致でひっかかったものを取得しながら
    //  ユーザー情報とマイページ登録情報をJOINでまとめる
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
      $htmlElements .= "
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
      ";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/search.css">
  <title>Document</title>
</head>

<body>
  <a id='homeBack' href="./home.php">戻る</a>

  <form id="searchForm" action="./search.php" method="post">
    <label for="search_term">ユーザー名検索</label>
    <input type="text" name="search_str" id="search_str" value='<?= $str ?>' />
    <input type="submit" value="search" id="search_button" />
  </form>

  <div id="display">
    <!-- 検索結果を表示する -->
    <?= $htmlElements ?>
  </div>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    // ajax通信でうまいことできんか？
    // $('#search_str').on('keyup', (e) => {
    //   let str = $('#search_str').val();
    //   $.ajax({
    //     type: "POST",
    //     url: "search.php",
    //     data: {
    //       search_str: str
    //     },
    //     dataType: "json"
    //   }).done((data) => {
    //     console.log('hoge')
    //   }).catch((e) => {
    //     console.log('fuga')
    //   })
    // })
  </script>
</body>

</html>