<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "five";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if (!$conn) {
  echo "DB Connection Failed";
}


?>