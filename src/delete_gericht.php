<?php
// Include database connection file
include("config.php");

// Retrieve [id] value from querystring parameter
$id = $_GET['id'];

$gerichtname = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM gerichte WHERE id=$id"));
$gericht = $gerichtname['gericht'];

// Delete row for a specified id
$stmt = $mysqli->prepare("DELETE FROM gerichte WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

//rezept löschen, wenn Gericht gelöscht wird
$stmt = $mysqli->prepare("DELETE FROM rezepte WHERE gericht=?");
$stmt->bind_param("s", $gericht);
$stmt->execute();


// Redirect to home page (index.php)
header("Location:index.php");
?>
