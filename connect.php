<?php 
	$server = 'localhost';
	$user = 'root';
	$mk = '';
	$dbname = 'note_db';
// Create connection
$conn = new mysqli($server, $user, $mk, $dbname);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
 ?>