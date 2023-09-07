<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Neo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons'>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="form">
  <form action="authenticate.php" method="post">
    <div class="form-toggle"></div>
    <div class="form-panel one">
      <div class="form-header">
        <h1>Account Login</h1>
      </div>
      <div class="form-content">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required="required" title="Login with your company email" />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required="required" />
        </div>
        <div class="form-group">
          <label class="form-remember">
            <input type="checkbox" />Remember Me
          </label>
          <a class="form-recovery" href="#">Forgot Password?</a>
        </div>
        <div class="form-group">
          <button type="submit" onclick="validateUsername()">Log In</button>
        </div>
      </div>
    </div>
  </form>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://codepen.io/andytran/pen/vLmRVp.js"></script>
  <script src="validatescript.js"></script>
  <script>
    function validateUsername() {
      var usernameInput = document.getElementById('username');
      var usernameValue = usernameInput.value;
      var forbiddenChars = /[\/,%""]/;

      if (forbiddenChars.test(usernameValue)) {
        alert("You can't enter '/', ',', or '%' characters in the username.");
        usernameInput.value = '';
      }
    }
  </script>
</body>
</html>
