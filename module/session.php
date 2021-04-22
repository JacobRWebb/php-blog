<?php
  session_start();

  $userID = false;
  $username = "";

  if (isset($_SESSION["userID"]) && isset($_SESSION["username"])) {
    $userID = $_SESSION["userID"];
    $username = $_SESSION["username"];
  }

  function CreateConnection() {
    //  Local Development 
    $server = "localhost";
    $dbUsername = "Xodius";
    $dbPassword = "Xodius";
    $dbDatabase = "php_blog";

    $conn = mysqli_connect($server, $dbUsername, $dbPassword, $dbDatabase);

    return $conn;
  }
?>