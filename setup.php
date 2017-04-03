<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "root";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error)
    die("Connection failed: $conn->connect_error \n");
echo "Connected to $servername\n";

$dbname = "notesdb";
$conn->query("CREATE DATABASE $dbname");
$conn->select_db($dbname);
$conn->query("CREATE TABLE IF NOT EXISTS notes (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
content TEXT);");

echo "OK\n";

$conn->close();

?>
