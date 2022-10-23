<?php
// Include database connection file
include_once("config.php");

if(isset($_POST['update']))
{
	// Retrieve record values
	$gericht = mysqli_real_escape_string($mysqli, $_POST['gericht']);
	$quelle = mysqli_real_escape_string($mysqli, $_POST['quelle']);
	$dauer = mysqli_real_escape_string($mysqli, $_POST['dauer']);
	$portionen = mysqli_real_escape_string($mysqli, $_POST['portionen']);
	$kommentar = mysqli_real_escape_string($mysqli, $_POST['kommentar']);

	$gerichtErr = "";

	// Check for empty fields
if(empty($gericht)) {
		if(empty($gericht)) {
			$gerichtErr = "* required";
		}
	} else {
		// Insert new contact
		$stmt = $mysqli->prepare("INSERT INTO gerichte(gericht,quelle,dauer,portionen,kommentar) VALUES(?, ?, ?, ?, ?)");
		$stmt->bind_param("ssiis", $gericht, $quelle, $dauer, $portionen, $kommentar);
		$stmt->execute();

		// Redirect to home page (index.php)
		header("Location: index.php");
	}
}
else if (isset($_POST['cancel'])) {
	// Redirect to home page (index.php)
	header("Location: index.php");
}
?>
<html>
<head>
	<title>Gericht bearbeiten</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<form name="form1" method="post" action="add_gericht.php">
		<table>
			<tr>
				<td>Gericht</td>
				<td>
					<input type="text" name="gericht" value="<?php echo $gericht = isset($gericht) ? $gericht: ''; ?>">
					<span class="error"><? php echo $gerichtErr; ?></span>
				</td>
			</tr>
			<tr>
				<td>Quelle</td>
				<td>
					<input type="text" name="quelle" value="<?php echo $quelle = isset($quelle) ? $quelle: '';?>">
				</td>
			</tr>
			<tr>
				<td>Dauer</td>
				<td>
					<input type="text" name="dauer" value="<?php echo $dauer = isset($dauer) ? $dauer: '';?>">
				</td>
			</tr>
			<tr>
				<td>Portionen</td>
				<td>
					<input type="text" name="portionen" value="<?php echo $portionen = isset($portionen) ? $portionen: '';?>">
				</td>
			</tr>
			<tr>
				<td>Kommentar</td>
				<td>
					<input type="text" name="kommentar" value="<?php echo $kommentar = isset($kommentar) ? $kommentar: '';?>">
				</td>
			</tr>
			<tr>
				<td>
					<input class="cancel" type="submit" name="cancel" value="Cancel">
				</td>
				<td>
					<input type="submit" name="update" value="Update">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
