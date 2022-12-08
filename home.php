<?php

// sessionを使うところでは必ず最初にsession_start()しないと使えない！
session_start();

// var_dump($_SESSION);
// exit();

require_once('./function/login_function.php');

// 一応、もしsessionが設定されていないいならログインページにとばす
if(isset($_SESSION)){
$welcome = "ようこそ、".$_SESSION['username']."さん！";
}else{
header('Location:./login.php');
exit();
}

// DB接続
require_once('./function/config.php');

// SQL作成&実行 ツイート全て取得
$sql = 'SELECT id, text, user_id, username, created_at FROM tweet_table ORDER BY created_at ASC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo '<pre>';
// var_dump($row);
// echo '</pre>';

$htmlElements = '';
// 繰り返し文で表示する用の文字列を作成
foreach ($row as $v) {
  // 返信の数を数える
  $sqlReply = 'SELECT * FROM reply_table WHERE tweet_id=:id';
  $stmtReply = $pdo->prepare($sqlReply);
  $stmtReply->bindValue(':id', $v['id'], PDO::PARAM_INT);
  $stmtReply->execute();
  $reply = $stmtReply->fetchAll(PDO::FETCH_ASSOC);
  // 返信数を数える
  $replyCount = count($reply);

  // TOP画像を取得
  $stmtMyPage = $pdo->prepare('SELECT * FROM myPage_table WHERE user_id = :user_id');
  $stmtMyPage->bindValue(':user_id', $v['user_id'], PDO::PARAM_INT);
  $stmtMyPage->execute();
  $rowMyPage = $stmtMyPage->fetch(PDO::FETCH_ASSOC);
  // 投稿１つ１つでsrcを作成する（見つからなかったor空白orURLあり）
  $img = '';
  if (!$rowMyPage) {
    $img .= './img/人物アイコン.png';
  }else if ($rowMyPage['img'] === '') {
    $img .= './img/人物アイコン.png';
  } else {
    $img .= $rowMyPage['img'];
  }

  // 自分がいいねしているかどうか判断
  $sqlLike = 'SELECT like_check FROM like_table WHERE user_id=:user_id AND tweet_id=:tweet_id';
  $stmtLike = $pdo->prepare($sqlLike);
  $stmtLike->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
  $stmtLike->bindValue(':tweet_id', $v['id'], PDO::PARAM_INT);
  $stmtLike->execute();
  $like = $stmtLike->fetch(PDO::FETCH_ASSOC);
  $likeSrc = '';
  if (!$like) {
    $likeSrc .= './img/ハートマークの無料アイコン素材 11.png';
  } else if ($like['like_check'] === 1) {
    $likeSrc .= './img/キラっとしたハートの無料アイコン素材 2.png';
  } else {
    $likeSrc .= './img/ハートマークの無料アイコン素材 11.png';
  }

  // 投稿が何回いいねされているかカウントして表示

  // ツイートした日時のフォーマットを変更
  $date = date('Y年n月j日 H:i', strtotime($v['created_at']));
  $htmlElements .= "
      <div class='item'>
        <img class='logo' src='{$img}' alt='画像'>
        <div class='sentence'>
          <div class='who'>
            <p class='username'>{$v['username']}</p>
            <p class='tweetTime'>{$date}</p>
            <p class='replyCount'>返信数:{$replyCount}</p>
          </div>
          <p>{$v['text']}</p>
          <div class='flex'>
            <a href='./like.php?id={$v['id']}'>
              <img class='img' src='{$likeSrc}'>
            </a>
            <p>3</p>
            <a class='anchor' href='./reply.php?id={$v['id']}'>投稿画面へ</a>
          </div>
        </div>
      </div>
        ";
}

// var_dump($htmlElements);
// exit();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css" />
  <link rel="stylesheet" href="./css/home.css">
  <title>php</title>
</head>

<body>
  <div id="home">

    <!-- ヘッダー -->
    <header>
      <?= $welcome ?>
    </header>

    <div class="homeDisplay">
      <!-- サイドバー -->
      <div id="sideBar">
        <div id="myPage" class="bar">
          <a href="./myPage.php">マイページへ</a>
        </div>

        <div id="logout" class="bar">
          <a href="./logout.php">ログアウト</a>
        </div>
      </div>

      <!-- タイムライン -->
      <div id="display">
          <?= $htmlElements ?>
      </div>

      <!-- 掲示板 -->
      <div id="bbs">
        集り募集の掲示板みたいなやつ
      </div>
    </div>

  </div>

  <!-- 投稿form表示ボタン -->
  <div id="formBtn">
    <button>＋</button>
  </div>

  <!-- 投稿 -->
  <div id="tweet">
    <form action="./tweet_create.php" method="POST">
      <p id="tweetClose">キャンセル</p>
      <textarea name="text" id="tweet" cols="50" rows="15" placeholder="いまどうしてる？"></textarea>
      <button>ツイート</button>
    </form>
  </div>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
    $('#formBtn button').on('click', () => {
      $('#tweet').fadeIn();
      $('#tweet form').fadeIn();
      $('#tweet form textarea').fadeIn();
    })

    $('#tweetClose').on('click', () => {
      $('#tweet').fadeOut();
      $('#tweet form').fadeOut();
      $('#tweet form textarea').fadeOut();
    })
  </script>
</body>

</html>