<?php
// Basic connection settings
$databaseHost = '127.0.0.1';
$databaseUsername = 'test_user';
$databasePassword = 'test01';
$databaseName = 'essensplan_produktiv';

// Connect to the database
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
?>
