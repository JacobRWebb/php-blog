<?php
  require_once("session.php");
  require_once("Connection.php");

  class PostClass {

    public function fetchProfilePost($userID) {
      $conn = Connection::CreateConnection();
      $query = "SELECT post.ID as ID, title, content, username, ownerID, post.createdAt as createdAt FROM post, user WHERE post.parentID IS NULL AND post.ownerID = '".$userID."' AND post.ownerID = user.ID ORDER BY post.createdAt DESC;";
      $result = $conn->query($query);
      mysqli_close($conn);
      return $result;
    }

    public function fetchSinglePost($postID) {
      $conn = Connection::CreateConnection();
      $query = "SELECT post.ID as ID, title, content, username, ownerID, post.createdAt as createdAt FROM post, user WHERE post.ID = '".$postID."' AND post.ownerID = user.ID";
      $result = $conn->query($query);
      mysqli_close($conn);
      return $result;
    }

    public function fetchAllPost() {
      $conn = Connection::CreateConnection();

      $query = "SELECT post.ID as ID, title, content, username, ownerID, post.createdAt as createdAt FROM post, user WHERE post.parentID IS NULL AND post.ownerID = user.ID ORDER BY post.createdAt DESC";
      $result = $conn->query($query);
      mysqli_close($conn);

      return $result;
    }

    public function fetchReplies($postID) {
      $conn = Connection::CreateConnection();
      $query = "SELECT post.ID as ID, ownerID, username, content FROM post, user WHERE post.parentID = '".$postID."' AND post.ownerID = user.ID ORDER by post.createdAt DESC";
      $result = $conn->query($query);
      mysqli_close($conn);
      return $result;
    }

    public function createPost($body) {
      $conn = Connection::CreateConnection();

      $this->ValidateInput($body, "title", 3, 50);
      $this->ValidateInput($body, "content", 10, 4500);

      if (!isset($_SESSION["error"])) {
        $title = $body["title"];
        $content = $body["content"];

        $query = "INSERT INTO post (title, content, ownerID) VALUES (?,?,?);";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $title, $content, $_SESSION["userID"]);
        $result = $stmt->execute();

        if (!$result) {
          $_SESSION["error"] = "Something went wrong on the server side.";
        }
      }

      mysqli_close($conn);
      header("Location: index.php");
    }

    public function createReply($body) {
      $conn = Connection::CreateConnection();

      $this->ValidateInput($body, "postID", 0, 100);
      $this->ValidateInput($body, "content", 10, 300);

      $postID = $body["postID"];

      if (!isset($_SESSION["error"])) {
        $title = "REPLY";
        $content = $body["content"];

        $query = "INSERT INTO post (title, content, ownerID, parentID) VALUES (?,?,?,?);";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssii", $title, $content, $_SESSION["userID"], $postID);
        $result = $stmt->execute();
        if (!$result) {
          $_SESSION["error"] = "Something went wrong on the server side.";
        } else {
          mysqli_close($conn);
          header("Location: post.php?postID=$postID#post");
          exit();
        }
      }

      mysqli_close($conn);
      header("Location: post.php?postID=$postID#reply");
      exit();
    }

    public function deletePost($body) {
      $conn = Connection::CreateConnection();

      $this->ValidateInput($body, "postID", 0, 100);

      if (!isset($_SESSION["error"])) {
        $postID = $body["postID"];
        $query = "DELETE FROM post WHERE id = '".$postID."';";
        $result = $conn->query($query);

        if (!$result) {
          $_SESSION["error"] = "Failed to delete record";
        } else {
          if (isset($body["position"])) {
            $position = intval($body["position"]) - 1;
            header("Location: index.php#$position");
            mysqli_close($conn);
            exit();
          }
        }
      }

      mysqli_close($conn);
      header("Location: index.php");
    }

    private function ValidateInput($body, $field, $min, $max) {
      if (!isset($_SESSION["error"])) {
        if (!isset($body[$field])) {
          $_SESSION["error"] = "$field is missing!";
        } else if (strlen($body[$field]) > $max) {
          $_SESSION["error"] = "$field needs to be $max characters or less!";
        } else if (strlen($body[$field]) < $min) {
          $_SESSION["error"] = "$field needs to be $min characters or more!";
        }
      }
    }
  }
?>