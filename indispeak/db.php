
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "langlearn"; // make sure this matches your actual DB name

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>