<?php 
	$server = 'localhost';
	$user = 'root';
	$mk = '';
	$dbname = 'note_db';
// Create connection
$conn = new mysqli($server, $user, $mk, $dbname);
$conn->set_charset("utf8mb4");

// Check connection

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
 ?>