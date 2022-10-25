<!DOCTYPE html>
<head>
	<title>Neue Zutat</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<?php
	// Retrieve id value from querystring parameter
	$gericht = $_GET['gericht'];
	$zutat = $_GET['zutat'];

	// Get Zutat by Gericht und Zutat
	$result = mysqli_query($mysqli, "SELECT * FROM rezepte WHERE gericht='$gericht' AND zutat='$zutat'");

	if (!$result) {
	    printf("Error: %s\n", mysqli_error($mysqli));
	    exit();
	}
	else {
		while($res = mysqli_fetch_array($result))
		{
			$gericht = $res['gericht'];
			$zutat = $res['zutat'];
			$rezeptmenge = $res['rezeptmenge'];
			$einheit = $res['einheit'];
			$portionen = $res['portionen'];
		}
	}
	?>
	<form name="form1" method="post" action="edit_rezepteintrag.php?rezept=<?php echo $gericht ?>">
		<table>
			<tr>
				<td>Gericht</td>
				<td>
					<?php echo $gericht ?>
				</td>
			</tr>
			<tr>
				<td>Zutat</td>
				<td>
					<input type="text" name="zutat" value="<?php echo $zutat = isset($zutat) ? $zutat: '';?>">
				</td>
			</tr>
			<tr>
				<td>Menge</td>
				<td>
					<input type="text" name="rezeptmenge" value="<?php echo $rezeptmenge = isset($rezeptmenge) ? $rezeptmenge: '';?>">
				</td>
			</tr>
			<tr>
				<td>Einheit</td>
				<td>
					<input type="text" name="einheit" value="<?php echo $einheit = isset($einheit) ? $einheit: '';?>">
				</td>
			</tr>
			<tr>
				<td>Portionen</td>
				<td>
					<input type="text" name="portionen" value="<?php echo $portionen = isset($portionen) ? $portionen: '';?>">
				</td>
			</tr>
			<tr>
				<td>
					<input class="cancel" type="submit" name="cancel" value="Cancel">
					<input type="hidden" name="gericht" value=<?php echo $_GET['gericht'];?>>
				</td>
				<td>
					<input type="submit" name="update" value="Update">
					<input type="hidden" name="gericht" value=<?php echo $_GET['gericht'];?>>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php
// Include database connection file
include_once("config.php");

if(isset($_POST['update']))
{
	// Retrieve record values
	$gericht = mysqli_real_escape_string($mysqli, $_POST['gericht']);
	$zutat = mysqli_real_escape_string($mysqli, $_POST['zutat']);
	$rezeptmenge = mysqli_real_escape_string($mysqli, $_POST['rezeptmenge']);
	$einheit = mysqli_real_escape_string($mysqli, $_POST['einheit']);
	$portionen = mysqli_real_escape_string($mysqli, $_POST['portionen']);

	$gerichtErr= $zutatErr = "";

	// Check for empty fields
	if(empty($gericht) && empty($zutat)) {
			if(empty($gericht)) {
				$gerichtErr = "* required";
			}
			if(empty($zutat)) {
				$zutatErr = "* required";
			}
	} else {
		// Execute UPDATE
		$stmt = $mysqli->prepare("UPDATE rezepte SET gericht=?, zutat=?, rezeptmenge=?, einheit=?, portionen=? WHERE gericht=? AND zutat=?");
		$stmt->bind_param("ssisiss", $gericht, $zutat, $rezeptmenge, $einheit, $portionen, $gericht, $zutat);
		$stmt->execute();

		// Redirect to rezept page (rezept.php)
		header("Location:rezept.php?gericht=$gericht");
	}
}
else if (isset($_POST['cancel'])) {
	// Redirect to rezept page (rezept.php)
	$gericht = mysqli_real_escape_string($mysqli, $_POST['gericht']);
	header("Location:rezept.php?gericht=$gericht");
}
?>
