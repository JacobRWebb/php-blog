<?php
  require_once("session.php");
?>

<link rel="stylesheet" href="main.css" type="text/css" />
<div class="navbar">
  <p class="logo" onclick="document.location.href=`index.php`">A Random Blog...</p>
  <div class="navMenu">
    <button class="navButton" onclick="document.location.href=`index.php`">Home</button>
    <?php
      if ($userID && isset($username)) {
        ?>
        <button class="navButton" onclick="document.location.href=`profile.php`"><?php echo($username); ?></button>
        <button class="navButton" onclick="document.location.href=`logout.php`">Logout</button>
        <?php
      } else {
        ?>
        <button class="navButton" onclick="document.location.href=`login.php`">Login</button>
        <button class="navButton" onclick="document.location.href=`signup.php`">Signup</button>
        <?php
      }
    ?>
  </div>
</div>