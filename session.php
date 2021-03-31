<?php
 session_start();
 $auth = false;
 $username = null;

 if (isset($_SESSION["auth"]) && isset($_SESSION["username"])) {
   $auth = $_SESSION["auth"];
   $username = $_SESSION["username"];
 }
?>