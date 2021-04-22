<?php
  require_once("module/session.php");
  session_destroy();
  header("Location: index.php");
?>