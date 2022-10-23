<?php
// Include database connection file
include_once("config.php");

if(isset($_POST['update']))
{
	// Retrieve record values
	//$gericht = $_GET['gericht'];
	$gericht = mysqli_real_escape_string($mysqli, $_POST['gericht']);
	$zutat = mysqli_real_escape_string($mysqli, $_POST['zutat']);
	$rezeptmenge = mysqli_real_escape_string($mysqli, $_POST['rezeptmenge']);
	$einheit = mysqli_real_escape_string($mysqli, $_POST['einheit']);

	$gerichtErr = $zutatErr = "";

	// Check for empty fields
if(empty($gericht) && empty($zutat)) {
		if(empty($gericht)) {
			$gerichtErr = "* required";
		}
		if(empty($zutat)) {
			$zutatErr = "* required";
		}
	} else {
		// Insert new Zutat
		$stmt = $mysqli->prepare("INSERT INTO rezepte(gericht,zutat,rezeptmenge,einheit) VALUES(?, ?, ?, ?)");
		$stmt->bind_param("ssis", $gericht, $zutat, $rezeptmenge, $einheit);
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
<?php
$gericht = $_GET['gericht'];
?>
<html>
<head>
	<title>Neue Zutat</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<form name="form1" method="post" action="add_rezepteintrag.php?gericht=$gericht">
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
