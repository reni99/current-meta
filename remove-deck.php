<?php
include_once "constants.php";
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
$connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);	 
 if ($connection->connect_error) {
 	die("Connection failed: " . $connection->connect_error);
     exit();
 }
$query = "DELETE FROM deck WHERE id = ?";
$id = $_GET["id"];
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $id); 
$stmt->execute();
$stmt->close();
$connection->close();
header('Location: index.php?page=deck-editor.php');
?>