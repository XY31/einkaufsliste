<?php
// Include database connection file
include_once("config.php");

function createUpdateDay($mysqli, $jahr, $kalenderwoche, $wochentag, $gericht){
	$result = mysqli_query($mysqli, "SELECT * FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag ='$wochentag'");
	if( $result->num_rows == 0) {
			$stmt = $mysqli->prepare("INSERT INTO wochenplaene(jahr,kalenderwoche,wochentag,gericht) VALUES(?, ?, ?, ?)");
			$stmt->bind_param("iiss",  $jahr, $kalenderwoche, $wochentag, $gericht);
			$stmt->execute();
		} else {
			// Execute UPDATE
			$stmt = $mysqli->prepare("UPDATE wochenplaene SET gericht=? WHERE jahr=? AND kalenderwoche=? AND wochentag=?");
			$stmt->bind_param("siis", $gericht, $jahr, $kalenderwoche, $wochentag);
			$stmt->execute();
		}
}

if(isset($_POST['update']))
{
	// Retrieve record values
	$jahr = mysqli_real_escape_string($mysqli, $_POST['jahr']);
	$kalenderwoche = mysqli_real_escape_string($mysqli, $_POST['kalenderwoche']);
	$montag = mysqli_real_escape_string($mysqli, $_POST['montag']);
	$dienstag = mysqli_real_escape_string($mysqli, $_POST['dienstag']);
	$mittwoch = mysqli_real_escape_string($mysqli, $_POST['mittwoch']);
	$donnerstag= mysqli_real_escape_string($mysqli, $_POST['donnerstag']);
	$freitag = mysqli_real_escape_string($mysqli, $_POST['freitag']);
	$samstag = mysqli_real_escape_string($mysqli, $_POST['samstag']);
	$sonntag = mysqli_real_escape_string($mysqli, $_POST['sonntag']);

	createUpdateDay($mysqli, $jahr, $kalenderwoche, 'Montag', $montag);
	createUpdateDay($mysqli, $jahr, $kalenderwoche, 'Dienstag', $dienstag);
	createUpdateDay($mysqli, $jahr, $kalenderwoche, 'Mittwoch', $mittwoch);
	createUpdateDay($mysqli, $jahr, $kalenderwoche, 'Donnerstag', $donnerstag);
	createUpdateDay($mysqli, $jahr, $kalenderwoche, 'Freitag', $freitag);
	createUpdateDay($mysqli, $jahr, $kalenderwoche, 'Samstag', $samstag);
	createUpdateDay($mysqli, $jahr, $kalenderwoche, 'Sonntag', $sonntag);

		// Redirect to home page (index.php)
		$jahr = mysqli_real_escape_string($mysqli, $_POST['jahr']);
		$kalenderwoche = mysqli_real_escape_string($mysqli, $_POST['kalenderwoche']);
		header("Location:wochenplan.php?jahr=$jahr&kalenderwoche=$kalenderwoche");
	}
else if (isset($_POST['cancel'])) {
	// Redirect to home page (index.php)
	header("Location: index.php");
}
?>
<?php
$jahr = $_GET['jahr'];
$kalenderwoche = $_GET['kalenderwoche'];

// Get Nährwerte by gericht
$result = mysqli_query($mysqli, "SELECT * FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche'");
//$gerichte = mysqli_query($mysqli, "SELECT * FROM gerichte");

if (!$result) {
    printf("Error: %s\n", mysqli_error($mysqli));
    exit();
}
else {
	while($res = mysqli_fetch_array($result))
	{
		if ($res['wochentag'] == 'Montag') {
			$montag = $res['gericht'];
		} elseif ($res['wochentag'] == 'Dienstag') {
			$dienstag = $res['gericht'];
		} elseif ($res['wochentag'] == 'Mittwoch') {
			$mittwoch = $res['gericht'];
		} elseif ($res['wochentag'] == 'Donnerstag') {
			$donnerstag = $res['gericht'];
		} elseif ($res['wochentag'] == 'Freitag') {
			$freitag = $res['gericht'];
		} elseif ($res['wochentag'] == 'Samstag') {
			$samstag = $res['gericht'];
		} elseif ($res['wochentag'] == 'Sonntag') {
			$sonntag = $res['gericht'];
		};
	}
}
?>
<html>
<head>
	<title>Nährwerte bearbeiten</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<form name="form1" method="post" action="wochenplan.php?jahr=<?php echo $jahr ?>&kalenderwoche=<?php echo $kalenderwoche ?>">
		<table>
			<tr>
				<td style="background-color: lightblue; text-align: center; font-size: 22px;">Woche: <?php echo $kalenderwoche ?> Jahr: <?php echo $jahr ?></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>Montag</td>
				<td>
					<input type="text" name="montag" value="<?php echo $montag= isset($montag) ? $montag: '';?>">
				</td>
			</tr>
			<tr>
				<td>Dienstag</td>
				<td>
					<input type="text" name="dienstag" value="<?php echo $dienstag = isset($dienstag) ? $dienstag: '';?>">
				</td>
			</tr>
			<tr>
				<td>Mittwoch</td>
				<td>
					<input type="text" name="mittwoch" value="<?php echo $mittwoch = isset($mittwoch) ? $mittwoch: '';?>">
				</td>
			</tr>
			<tr>
				<td>Donnerstag</td>
				<td>
					<input type="text" name="donnerstag" value="<?php echo $donnerstag = isset($donnerstag) ? $donnerstag: '';?>">
				</td>
			</tr>
      <tr>
				<td>Freitag</td>
				<td>
					<input type="text" name="freitag" value="<?php echo $freitag = isset($freitag) ? $freitag: '';?>">
				</td>
			</tr>
			<tr>
				<td>Samstag</td>
				<td>
					<input type="text" name="samstag" value="<?php echo $samstag = isset($samstag) ? $samstag: '';?>">
				</td>
			</tr>
			<tr>
				<td>Sonntag</td>
				<td>
					<input type="text" name="sonntag" value="<?php echo $sonntag = isset($sonntag) ? $sonntag: '';?>">
				</td>
			</tr>
			<tr>
				<td>
					<input class="cancel" type="submit" name="cancel" value="Cancel">
				</td>
				<td>
					<input type="submit" name="update" value="Update">
					<input type="hidden" name="jahr" value=<?php echo $_GET['jahr'];?>>
					<input type="hidden" name="kalenderwoche" value=<?php echo $_GET['kalenderwoche'];?>>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
