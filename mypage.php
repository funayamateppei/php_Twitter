<?php

session_start();

require_once('./function/login_function.php');

// DB接続
require_once('./function/config.php');

// ログインしているユーザー情報を取得
$stmt = $pdo->prepare('SELECT * FROM user_table WHERE id = :id');
$stmt->bindValue(':id', $_SESSION['id']);
$stmt->execute();
$rowUser = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($rowUser);
// exit();

// ログインしているユーザーの投稿を全て取得
$stmt = $pdo->prepare('SELECT * FROM tweet_table WHERE user_id = :id');
$stmt->bindValue(':id', $_SESSION['id']);
$stmt->execute();
$rowTweet = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($rowTweet);
// exit();

// フリーテキストとTOP画像を取得
$stmtMyPage = $pdo->prepare('SELECT * FROM myPage_table WHERE user_id = :user_id');
$stmtMyPage->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$stmtMyPage->execute();
$rowMyPage = $stmtMyPage->fetch(PDO::FETCH_ASSOC);

$freeText = '';
if ($rowMyPage) {
  $freeText .= $rowMyPage['freetext'];
}
// もし登録されているなら登録されている画像 それ以外はデフォ画像
$img = '';
if (!$rowMyPage) {
  $img .= './img/人物アイコン.png';
} else if ($rowMyPage['img'] === '') {
  $img .= './img/人物アイコン.png';
} else {
  $img .= $rowMyPage['img'];
}
// var_dump($img);
// exit();

$htmlElements = '';
// 繰り返し文で表示する用の文字列を作成
foreach ($rowTweet as $v) {
  // 返信の数を数える
  $sqlReply = 'SELECT * FROM reply_table WHERE tweet_id=:id';
  $stmtReply = $pdo->prepare($sqlReply);
  $stmtReply->bindValue(':id', $v['id'], PDO::PARAM_INT);
  $stmtReply->execute();
  $reply = $stmtReply->fetchAll(PDO::FETCH_ASSOC);

  // 返信数を数える
  $replyCount = count($reply);

  // ツイートした日時のフォーマットを変更
  $date = date('Y年n月j日 H:i', strtotime($v['created_at']));

  $htmlElements .= "
    <div class='item'>
      <img src='{$img}' alt='画像'>
      <div class='sentence'>
        <div class='who'>
          <p class='username'>{$v['username']}</p>
          <p class='tweetTime'>{$date}</p>
          <p class='replyCount'>返信数 : {$replyCount}</p>
        </div>
        <p>{$v['text']}</p>
        <a href='./tweet.php?id={$v['id']}'>投稿画面へ</a>
      </div>
    </div>
  ";
}


// TOP画像を登録してあれば登録してあるものをなければデフォルトを表示
$topImg = '';


?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/mypage.css">
  <title>Document</title>
</head>

<body>
  <a id='homeBack' href="./home.php">戻る</a>

  <header>
    マイページ
  </header>

  <div class="user">
    <div class="flex">
      <div class="topImg">
        <form action="./img_update.php" method="POST" enctype="multipart/form-data">
          <input id="topImg" type="file" name="img" accept=".jpg, .jpeg, .png">
          <label for="topImg">
            <img src="<?= $img ?>" alt="TOP画像">
          </label>
          <button class="none">画像更新</button>
        </form>
      </div>

      <div class="userInfo">
        <div class="username">
          <p>ユーザー名</p>
          <p><?= $rowUser['username'] ?></p>
        </div>
        <div class="email">
          <p>メールアドレス</p>
          <p><?= $rowUser['email'] ?></p>
        </div>
      </div>
    </div>

    <div class="free">
      <p>
        <!-- php フリーテキスト表示 -->
        <?= $freeText ?>
      </p>
      <img id="freeText" src="./img/消しゴム付きの鉛筆のアイコン素材.png" alt="logo">
    </div>
  </div>

  <!-- フリーテキストフォーム画面 -->
  <div id="free">
    <form action="./freeText_update.php" method="POST">
      <img id="Close" src="./img/ノーマルの太さのバツアイコン.png" alt="logo">
      <textarea name="text" id="tweet" cols="50" rows="15"></textarea>
      <button>更新</button>
    </form>
  </div>


  <div id="display">
    <?= $htmlElements ?>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    // 画像ファイル選択時にだけ保存ボタンを
    $('#topImg').change(() => {
      if ($('#topImg').val() === '') {
        $('.none').hide();
      } else {
        $('.none').show();
      }
    })

    $('#freeText').on('click', () => {
      $('#free').fadeIn();
      $('#free form').fadeIn();
      $('#free form textarea').fadeIn();
    })

    $('#Close').on('click', () => {
      $('#free').fadeOut();
      $('#free form').fadeOut();
      $('#free form textarea').fadeOut();
    })

    $('#free button').on('click', () => {
      if ($('#tweet').val() === '') {
        alert('入力してください。');
        return
      }
    })
  </script>

</body>

</html>