<?php

session_start();
require_once('./function/login_function.php');

require_once('./function/config.php');

$htmlElements = '';

if (isset($_POST['search_str'])) {
  if ($_POST['search_str'] !== '') {
    $str = $_POST['search_str'];

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

    foreach ($rowUser as $v) {
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
                <a href='#'>フォローする</a>
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
  <form id="searchForm" action="./search.php" method="post">
    <label for="search_term">ユーザー名検索</label>
    <input type="text" name="search_str" id="search_str" />
    <input type="submit" value="search" id="search_button" />
  </form>

  <div id="display">
    <!-- 検索結果を表示する -->
    <?= $htmlElements ?>
  </div>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    // $('#search_str').on('keyup', (e) => {
    //   e.preventDefault();
    //   if ($('#search_str').val() !== '') {
    //     // inputタグの中の内容を投げるためにオブジェクト化
    //     let data = {
    //       str: $('#search_str').val()
    //     };
    //     $.ajax({
    //       url: "./search_create.php",
    //       type: "POST",
    //       data: data,
    //     }).done((data) => {
    //       $('#result').empty();
    //       let search_word = JSON.parse(data || "null");
    //     })

    //   }
    // })
  </script>
</body>

</html>