<?php
  require_once("module/session.php");
  require_once("module/PostClass.php");
  $post = new PostClass();

  if ($_SERVER["REQUEST_METHOD"] == "POST" && $userID) {
    unset($_SESSION["error"]);
    if (isset($_POST["METHOD"])) {
      $method = $_POST["METHOD"];
      $_SESSION["errorType"] = $method;
    
      if ($method == "postCreate") {
        $post->createPost($_POST);
      } else if ($method == "postDelete") {
        $post->deletePost($_POST);
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
  <title>Blog Thingy</title>
</head>
<body>
  <?php include_once("module/navbar.php") ?>
  <div class="layout">
    <div class="container">
      <?php
        $position = 0;
        if ($userID) {
          ?>
          <form method="POST" action="index.php">
            <p class="header">Post Creation</p>
            <input required minlength="3" maxlength="50" placeholder="Blog Title" name="title" class="input" />
            <textarea required minlength="10" maxlength="4500" placeholder="Content for your blog post." name="content" class="input textarea"></textarea>
            <input type="hidden" value="postCreate" name="METHOD" />
            <?php
            if (isset($_SESSION["errorType"]) && isset($_SESSION["error"])) {
              if ($_SESSION["errorType"] == "postCreate") {
                $error = $_SESSION["error"];
                echo("<p class='error'>$error</p>");
              }
            }
            ?>
            <div class="end">
              <button type="submit" class="actionButton">Create Post!</button>
            </div>
          </form>
          <?php
        } else {
          ?>
          <p class="inform">In order to post you must login!</p>
          <?php
        }
      ?>
    </div>
    <?php
      $result = $post->fetchAllPost();

      if ($result->num_rows < 1) {
        ?>
          <div class="container">
            <p class="inform">There are currently no posts. Perhaps you should make one!</p>
          </div>
        <?php
      } else {
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
                <p class="postUsername" onclick="document.location.href=`profile.php?id=<?php echo($ownerID); ?>`"><?php echo($ownerUsername); ?></p>
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
      }
    ?>
  </div>
  <script type="text/javascript">
    window.onload = function() {
      if (location.hash !== undefined) {
        goto(location.hash, this);
      }
    }
  </script>
</body>
</html>