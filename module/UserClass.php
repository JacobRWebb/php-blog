<?php
  require_once("session.php");  
  require_once("Connection.php");

  class User {

    public function Login($body) {
      $conn = Connection::CreateConnection();
      $this->ValidateInput($body, "username", 1, 20);
      $this->ValidateInput($body, "password", 1, 100);

      if (!isset($_SESSION["error"])) {
        $query = "SELECT * FROM user WHERE username = '".$body["username"]."' AND password = '".$body["password"]."';";
        $result = $conn->query($query);

        if ($result->num_rows < 1) {
          $_SESSION["error"] = "Username or Password is invalid!";
        } else {
          $row = $result->fetch_assoc();
          $_SESSION["userID"] = $row["ID"];
          $_SESSION["username"] = $row["username"];

          header("Location: index.php");
        }
      }

      mysqli_close($conn);
    }

    public function Signup($body) {
      $conn = Connection::CreateConnection();
      $this->ValidateInput($body, "username", 1, 20);
      $this->ValidateInput($body, "password", 1, 100);

      if (!isset($_SESSION["error"])) {
        $preQuery = "SELECT * FROM user WHERE username = '".$body["username"]."';";
        $preCheck = $conn->query($preQuery);
        if ($preCheck->num_rows > 0) {
          $_SESSION["error"] = "Username is already taken!";
        } else {
          $query = "INSERT INTO user (username, password) VALUES (?,?);";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("ss", $body["username"], $body["password"]);
          $result = $stmt->execute();

          if (!$result) {
            $_SESSION["Failed to create user"];
          } else {
            header("Location: index.php");
          }
        }
      }

      mysqli_close($conn);
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