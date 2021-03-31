<?php
  include_once("session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog</title>
</head>
<body>
  <?php
    include_once("navbar.php")
  ?>
  <div class="content">
    <h1 style={{margin: 0}}>Index</h1>
    <?php
      if ($auth) {
        echo "<h2>You are logged in as $username</h2>";
      } else {
        echo "<p>You are not logged in </p>";
        echo "<br />";
        echo "<button onClick=\"document.location.href=`login.php`\">Login</button>";
      }
    ?>
  </div>
</body>
</html>