<?php 
$content = $_POST["content"];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "notesdb";

$conn = new mysqli($servername, $username, $password, $dbname);

$content = $conn->real_escape_string($content);
$content = addcslashes($content, "%_");

//while(1);

$query = <<<EOT
INSERT INTO notes (content)
VALUES ("$content");
EOT;

$conn->query($query);
echo $conn->insert_id;

$conn->close();
?>