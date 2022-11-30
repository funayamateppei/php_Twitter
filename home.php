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
      home
    </header>

    <!-- サイドバー -->
    <div id="sideBar">

    </div>

    <!-- タイムライン -->
    <div id="display">

    </div>

    <!-- 掲示板 -->
    <div id="bbs">

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