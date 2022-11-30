<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/login.css">
  <title>Document</title>
</head>

<body>

  <div id="signin">
    <div class="form-title">Sign in</div>

    <form action="./login_create.php" method="POST">
      <div class="input-field">
        <label for="email">Email</label>
        <input type="email" id="email" autocomplete="off" />
      </div>
      <div class="input-field">
        <label for="password">Password</label>
        <input type="password" id="password" />
      </div>
      <a href="./signup.php" class="signUp">Sign up</a>
      <button class="login">Login</button>
    </form>

  </div>

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


  <script>
    // $("input").on('focusout', function() {
    //   $(this).each(function(i, e) {
    //     if ($(e).val() != "") {
    //       $(e).addClass('not-empty');
    //     } else {
    //       $(e).removeClass('not-empty');
    //     }
    //   });
    // });
  </script>
</body>

</html>