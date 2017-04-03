<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "notesdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
    die("Connection failed: $conn->connect_error\n");

$notes_content = $conn->query("SELECT id, content FROM notes ORDER BY id DESC");
while ($row = $notes_content->fetch_assoc()) {
	$id = $row["id"];
	$content = $row["content"];
	echo <<<EOT
<div class="block" id="div$id">
	<div class="note">$content</div>
	<button class="delete">Удалить</button>
	<br>
</div>
EOT;
}

$conn->close();

?>
