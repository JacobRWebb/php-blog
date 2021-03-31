<?php
 session_start();
 $auth = false;
 $username = null;

 if (isset($_SESSION["auth"]) && isset($_SESSION["username"])) {
   $auth = $_SESSION["auth"];
   $username = $_SESSION["username"];
 }


 // Generally I would not post information, however, this is a local server that will never see daylight.

 $server = "localhost";
 $dbUsername = "Xodius";
 $dbPassword = "Xodius";
 $dbDatabase = "php_blog";
?>