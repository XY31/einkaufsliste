<?php
// Include database connection file
include_once("config.php");

if(isset($_POST['update']))
{
	// Retrieve record values
	$gericht = mysqli_real_escape_string($mysqli, $_POST['gericht']);
	$kalorien = mysqli_real_escape_string($mysqli, $_POST['kalorien']);
	$kohlenhydrate = mysqli_real_escape_string($mysqli, $_POST['kohlenhydrate']);
	$eiweiss = mysqli_real_escape_string($mysqli, $_POST['eiweiss']);
	$fett = mysqli_real_escape_string($mysqli, $_POST['fett']);

	$gerichtErr= $kalorienErr = $kohlenhydrateErr = $eiweissErr = $fettErr = "";

		// check if entry exists
		$result = mysqli_query($mysqli, "SELECT * FROM naehrwerte WHERE gericht='$gericht'");

		// Beispiel für update oder create
		if ($result->num_rows == 0) {
			$stmt = $mysqli->prepare("INSERT INTO naehrwerte(gericht,kalorien,kohlenhydrate,eiweiss,fett) VALUES(?, ?, ?, ?, ?)");
			$stmt->bind_param("siiii",  $gericht, $kalorien, $kohlenhydrate, $eiweiss, $fett);
			$stmt->execute();
		} else {
		// Execute UPDATE
		$stmt = $mysqli->prepare("UPDATE naehrwerte SET kalorien=?, kohlenhydrate=?, eiweiss=?, fett=? WHERE gericht=?");
		$stmt->bind_param("iiiis", $kalorien, $kohlenhydrate, $eiweiss, $fett, $gericht);
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
<?php
// Retrieve gericht value from querystring parameter
$gericht = $_GET['gericht'];

// Get Nährwerte by gericht
$result = mysqli_query($mysqli, "SELECT * FROM naehrwerte WHERE gericht='$gericht'");

if (!$result) {
    printf("Error: %s\n", mysqli_error($mysqli));
    exit();
}
else {
	while($res = mysqli_fetch_array($result))
	{
		$gericht = $res['gericht'];
		$kalorien = $res['kalorien'];
		$kohlenhydrate = $res['kohlenhydrate'];
		$eiweiss = $res['eiweiss'];
    $fett = $res['fett'];
	}
}
?>
<html>
<head>
	<title>Nährwerte bearbeiten</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<form name="form1" method="post" action="naehrwerte.php?gericht=<?php echo $gericht ?>">
		<table>
			<tr>
				<td>Gericht</td>
				<td>
          <?php echo $gericht ?>
        </td>
			</tr>
			<tr>
				<td>Kalorien</td>
				<td>
					<input type="text" name="kalorien" value="<?php echo $kalorien = isset($kalorien) ? $kalorien: '';?>">
				</td>
			</tr>
			<tr>
				<td>Kohlenhydrate</td>
				<td>
					<input type="text" name="kohlenhydrate" value="<?php echo $kohlenhydrate = isset($kohlenhydrate) ? $kohlenhydrate: '';?>">
				</td>
			</tr>
			<tr>
				<td>Eiweiß</td>
				<td>
					<input type="text" name="eiweiss" value="<?php echo $eiweiss = isset($eiweiss) ? $eiweiss: '';?>">
				</td>
			</tr>
      <tr>
				<td>Fett</td>
				<td>
					<input type="text" name="fett" value="<?php echo $fett = isset($fett) ? $fett: '';?>">
				</td>
			</tr>
			<tr>
				<td>
					<input class="cancel" type="submit" name="cancel" value="Cancel">
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
