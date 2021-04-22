<?php
  include_once("module/session.php");
  include_once("module/UserClass.php");

  $userClass = new User();

  if ($userID) {
    header("Location: index.php");
    exit();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION["error"]);

    if (isset($_POST["METHOD"])) {
      $method = $_POST["METHOD"];
      $errorType = $method;

      if ($method == "loginForm") {
        $userClass->Login($_POST);
      }
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
  <link rel="stylesheet" href="main.css" type="text/css">
</head>
<body>
  <?php include_once("module/navbar.php"); ?>
  <div class="layout">
    <div class="container authContainer">
      <form method="POST">
        <p class="header">Login</p>
        <input required minlength="1" maxlength="100" autocomplete="username" name="username" placeholder="Username" type="text" class="input" />
        <input required minlength="1" autocomplete="password" name="password" placeholder="Password" type="password" class="input" />
        <input type="hidden" name="METHOD" value="loginForm" />
        <?php
          if (isset($errorType) && isset($_SESSION["error"])) {
            $error = $_SESSION["error"];
            if ($errorType == "loginForm") {
              echo("<p class='error'>$error</p>");
            }
          }
        ?>
        <div class="end">
          <button class="actionButton" type="submit">Login!</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>