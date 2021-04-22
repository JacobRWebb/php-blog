<?php
  ob_start();
  require_once("module/session.php");
  require_once("module/PostClass.php");

  $post = new PostClass();
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $method = $_POST["METHOD"];
    $_SESSION["errorType"] = $method;
    unset($_SESSION["error"]);

    if ($method == "postReply") {
      $post->createReply($_POST);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Viewing Post</title>
  <link rel="stylesheet" href="main.css" type="text/css">
</head>
<body>
  <?php include_once("module/navbar.php"); ?>
  <div class="layout">
    <div class="container">
      <p class="inform">You are currently viewing a blog post.</p>
    </div>
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["postID"])) {
          $result = $post->fetchSinglePost($_GET["postID"]);
          if ($result->num_rows < 1) {
            header("Location: index.php");
            exit();
          }

          $row = $result->fetch_assoc();
          ?>
          <div class="container" id="post">
            <div class="post">
              <p class="title"><?php echo($row["title"]); ?></p>
              <p class="content"><?php echo($row["content"]); ?></p>
            </div>
            <form action="index.php" class="end" method="POST">
              <input type="hidden" value="postDelete" name="METHOD" />
              <input type="hidden" value="<?php echo($row["ID"]); ?>" name="postID" />
              <p class="username"><?php echo($row["username"]); ?></p>
              <?php
                if ($userID) {
                  ?>
                  <button type="submit" class="actionButton">Delete Post!</button>
                  <?php
                }
              ?>
            </form>
          </div>
          <div class="container">
            <?php
              if ($userID) {
                ?>
                <form id="reply" action="post.php" method="POST">
                  <input type="hidden" value="postReply" name="METHOD" />
                  <input type="hidden" value="<?php echo($row["ID"]); ?>" name="postID" />
                  <h1>Leave Reply</h1>
                  <textarea required minlength="10" maxlength="300" placeholder="Reply Content..." name="content" class="input textarea"></textarea>
                  <?php
                    if (isset($errorType) && $_SESSION["error"]) {
                      $error = $_SESSION["error"];

                      if ($errorType="postReply") {
                        echo("<p class='error'>$error</p>");
                      }
                    }
                  ?>
                  <div class="end">
                    <button type="submit" class="actionButton">Reply!</button>
                  </div>
                </form>
                <?php
              } else {
                ?>
                  <p class="inform">In order to reply you must be logged in!</p>
                <?php
              }
            ?>
          </div>
          <?php

          $replies = $post->fetchReplies($row["ID"]);
          
          if ($replies->num_rows > 0) {
            while ($row = mysqli_fetch_array($replies)) {
              ?>
                <div class="container">
                  <p><?php echo($row["username"]); ?></p>
                  <p><?php echo($row["content"]); ?></p>
                </div>
              <?php
            }
          }
          
        } else {
          header("Location: index.php");
          exit();
        }
      }
    ?>
  </div>
  <script type="text/javascript">
    window.onload = function() {
      if (location.hash === "reply") {
        goto("#reply", this);
        
      }
    }
  </script>
</body>
</html>