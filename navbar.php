<?php
  include_once "session.php";
?>
<link rel="stylesheet" href="CSS/main.css" type="text/css">
<link rel="stylesheet" href="CSS/navbar.css" type="text/css">

<div class="nav">
  <h1 class="logo">A Random Blog Thing...</h1>
  <div class="rightMenu">
    <button onClick="document.location.href=`index.php`">Homepage</button>
    <?php
      if ($auth) {
        echo "<button onClick=\"document.location.href=`logout.php`\">Logout</button>";
      } else {
        echo "<button onClick=\"document.location.href=`login.php`\">Login</button>";
        echo "<button onClick=\"document.location.href=`signup.php`\">Signup</button>";
      }
    ?>
  </div>
</div>