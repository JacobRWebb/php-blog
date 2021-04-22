<?php
  require_once("module/session.php");
  require_once("module/PostClass.php");

  $postClass = new PostClass();

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $type = "personal";
    
    if (!isset($_GET["id"]) && !$userID) {
      header("Location: login.php");
      exit();
    }

    if (isset($_GET["id"])) {
      $conn = CreateConnection();
      $type = "other";
      $query = "SELECT * FROM user WHERE user.ID = '".$_GET["id"]."';";
      $result = $conn->query($query);
      if (!$result || $result->num_rows < 1) {
        header("Location: index.php");
        exit();
      } else {
        $row = $result->fetch_assoc();
        $username = $row["username"];
      }
      mysqli_close($conn);
    }
  } else {
    header("Location: index.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
</head>
<body>
  <?php include_once("module/navbar.php") ?>
  <div class="layout">
    <div class="container">
      <?php
        if ($type == "personal") {
          echo("<p class='inform'>You are viewing your own profile</p>");
          $result = $postClass->fetchProfilePost($_SESSION["userID"]);
        } else {
          echo("<p class='inform'>You are viewing $username</p>");
          $result = $postClass->fetchProfilePost($_GET["id"]);
        }
      ?>
    </div>
    <?php
      while ($row = mysqli_fetch_array($result)) {
        $id = $row["ID"];
        $title = $row["title"];
        $content = $row["content"];
        $ownerUsername = $row["username"];
        $ownerID = $row["ownerID"];

        ?>
        <div class="container" id="<?php echo($position); ?>">
          <div class="post">
            <p class="title" onclick="document.location.href=`post.php?postID=<?php echo($id); ?>`"><?php echo($title); ?></p>
            <p class="content"><?php echo($content); ?></p>
            <form class="end" method="POST" action="index.php">
              <input type="hidden" value="postDelete" name="METHOD" />
              <input type="hidden" value="<?php echo($id); ?>" name="postID" />
              <p class="postUsername"><?php echo($ownerUsername); ?></p>
              <button type="button" class="actionButton" onclick="document.location.href=`post.php?postID=<?php echo($id); ?>`">View Post!</button>
              <input type="hidden" value="<?php echo($position++); ?>" name="position" />
              <?php
              if ($userID == $ownerID) {
                ?>
                  <button type="submit" class="actionButton">Delete Post!</button>
                <?php
              }
              ?>
            </form>
          </div>
        </div>
        <?php
      }
    ?>
  </div>
</body>
</html>