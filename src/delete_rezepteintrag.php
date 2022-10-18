<?php
// Include database connection file
include("config.php");

// Retrieve [id] value from querystring parameter
$gericht = $_GET['gericht'];
$zutat = $_GET['zutat'];

// Delete row for a specified id
$stmt = $mysqli->prepare("DELETE FROM rezepte WHERE gericht=? AND zutat=?");
$stmt->bind_param("ss", $gericht, $zutat);
$stmt->execute();

// Redirect to rezept page (rezept.php)
header("Location:rezept.php?gericht=$gericht");
?>
