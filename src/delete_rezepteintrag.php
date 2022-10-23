<?php
// Include database connection file
include("config.php");

// Retrieve [id] value from querystring parameter
$id = $_GET['id'];
$gericht = $_GET['gericht'];

// Delete row for a specified id
$stmt = $mysqli->prepare("DELETE FROM rezepte WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Redirect to rezept page (rezept.php)
header("Location:rezept.php?gericht=$gericht");
?>
