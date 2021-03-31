<?php
  include_once("session.php");

  if ($auth == true) {
    header("Location: index.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
      $username = $_POST["username"];
      $password = $_POST["password"];
      if (strlen($username) <= 3) {
        $error = "username must be more than 3 characters.";
      } else if (strlen($password) <= 3) {
        $error = "password must be more than 3 characters.";
      } else {
        $conn = mysqli_connect($server, $dbUsername, $dbPassword, $dbDatabase);
        $sql = "SELECT * FROM user WHERE username = \"".$username."\" AND password = \"".$password."\"";
        if ($result=$conn->query($sql)) {
          if (mysqli_num_rows($result) < 1) {
            $error = "Username or password is incorrect.";
          } else {
            $_SESSION["auth"] = true;
            $_SESSION["username"] = $username;
            header("Location: index.php");
          }
        }
      }
    } else {
      $error = "Username or password is missing.";
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="CSS/auth.css" type="text/css">
</head>
<body>
<?php include_once("navbar.php"); ?>
  <div class="content">
    <div class="wrapper">
      <div class="signup">
        <form method="POST">
          <h1 class="header">Login</h1>
          <input type="text" placeholder="Username" autocomplete="username" name="username"  class="auth-input" />
          <br />
          <input type="password" placeholder="Password" autocomplete="password" name="password" class="auth-input" />
          <br />
          <?php
            if (isset($error)) {
              echo "<p class='error'>$error</p>";
              echo "<br />";
            }
          ?>
          <button type="submit">Login</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>