<?php
$id = $_POST["id"];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "notesdb";

$conn = new mysqli($servername, $username, $password, $dbname);
$query = <<<EOT
DELETE FROM notes
WHERE id = $id;
EOT;
echo $conn->query($query);
$conn->close();
?>