<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/signup.css">
  <title>Document</title>
</head>

<body>
  <div id="signin">
    <div class="form-title">Sign up</div>

    <form action="./signup.create.php" method="POST">
      <div class="input-field">
        <label for="username">Username</label>
        <input name="username" type="text" id="username" autocomplete="off" />
      </div>
      <div class="input-field">
        <label for="email">Email</label>
        <input name="email" type="email" id="email" autocomplete="off" />
      </div>
      <div class="input-field">
        <label for="password">Password</label>
        <input name="password" type="password" id="password" />
      </div>
      <div class="input-field">
        <label for="cfmpassword">Confirm Password</label>
        <input name="cfmpassword" type="cfmpassword" id="cfmpassword" />
      </div>
      <a href="./login.php" class="signUp">Sign in</a>
      <button class="login">Sign Up</button>
    </form>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
      $('.signup')
    </script>
  </div>
</body>

</html>