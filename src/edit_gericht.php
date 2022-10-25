<!DOCTYPE html>
<head>
	<title>Gericht bearbeiten</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<?php
	// Include database connection file
	include_once("config.php");

	// Retrieve id value from querystring parameter
	$id = $_GET['id'];

	// Get contact by id
	$result = mysqli_query($mysqli, "SELECT * FROM gerichte WHERE id=$id");

	if (!$result) {
	    printf("Error: %s\n", mysqli_error($mysqli));
	    exit();
	}
	else {
		while($res = mysqli_fetch_array($result))
		{
			$gericht = $res['gericht'];
			$quelle = $res['quelle'];
			$dauer = $res['dauer'];
			$portionen = $res['portionen'];
			$kommentar = $res['kommentar'];
		}
	}
	?>
	<form name="form1" method="post" action="edit_gericht.php?id=<?php echo $id ?>">
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
					<input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
<?php
if(isset($_POST['update']))
{
	// Retrieve record values
	$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	$gericht = mysqli_real_escape_string($mysqli, $_POST['gericht']);
	$quelle = mysqli_real_escape_string($mysqli, $_POST['quelle']);
	$dauer = mysqli_real_escape_string($mysqli, $_POST['dauer']);
	$portionen = mysqli_real_escape_string($mysqli, $_POST['portionen']);
	$kommentar = mysqli_real_escape_string($mysqli, $_POST['kommentar']);

	$gerichtErr= $quelleErr = $dauerErr = $kommentarErr = "";

	// Check for empty fields
	if(empty($gericht)) {
		if(empty($gericht)) {
			$gerichtErr = "* required";
		}
	} else {
		// Execute UPDATE
		$stmt = $mysqli->prepare("UPDATE gerichte SET gericht=?, quelle=?, dauer=?, portionen=?, kommentar=? WHERE id=?");
		$stmt->bind_param("ssiisi", $gericht, $quelle, $dauer, $portionen, $kommentar, $id);
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
