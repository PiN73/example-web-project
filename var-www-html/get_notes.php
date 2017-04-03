<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "notesdb";

try {
	$conn = new mysqli($servername, $username, $password, $dbname);
} catch (Exception $e) {
	echo 0;
	return;
}
if (!$conn || $conn->connect_error) {
	echo 0;
	return;
    //die("Connection failed: $conn->connect_error\n");
}

$notes_sql = $conn->query("SELECT id, content FROM notes ORDER BY id DESC");
$notes = array();

while ($row = $notes_sql->fetch_assoc()) {
	$id = $row["id"];
	$content = $row["content"];
	$notes[$id] = $content;
}

echo json_encode($notes);

$conn->close();

?>
