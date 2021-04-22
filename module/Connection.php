<?php
  class Connection {
    public static $server = "localhost";
    public static $db_username = "Xodius";
    public static $db_password = "Xodius";
    public static $db_database = "php_blog";

    public static function CreateConnection() {
      $conn = mysqli_connect(Connection::$server, Connection::$db_username, Connection::$db_password, Connection::$db_database);
      return $conn;
    }
  }
?>