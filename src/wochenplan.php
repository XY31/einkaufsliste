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
		<table>
			<tr>
				<td><input type="submit" id="lastweek" name="update" value="letzte Woche" function="lastweek()">
					<script>
					document.getElementById("lastweek").addEventListener("click", myFunction);
		      function myFunction() {
		        window.location.href="wochenplan.php?jahr=<?php echo $jahr ?>&kalenderwoche=<?php $letzteKalenderwoche = $kalenderwoche - 1; echo $letzteKalenderwoche ?>";
		      }
					</script></td>
				<td style="background-color: lightblue; text-align: center; font-size: 22px;">Woche: <?php echo $kalenderwoche ?> Jahr: <?php echo $jahr ?></td>
				<td><input type="submit" id="nextweek" name="update" value="nächste Woche" function="nextweek()">
					<script>
					document.getElementById("nextweek").addEventListener("click", myFunction);
					function myFunction() {
						window.location.href="wochenplan.php?jahr=<?php echo $jahr ?>&kalenderwoche=<?php $naechsteKalenderwoche = $kalenderwoche + 1; echo $naechsteKalenderwoche ?>";
					}
					</script></td>
			</tr>
		</table>
	<form name="form1" method="post" action="wochenplan.php?jahr=<?php echo $jahr ?>&kalenderwoche=<?php echo $kalenderwoche ?>">
		<table>
			<tr>
				<td>Montag</td>
				<td>
					<?php $liste = mysqli_query($mysqli, "SELECT gericht FROM gerichte");
								$db_gericht = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag='Montag'");
								while ($res = $db_gericht ->fetch_assoc()) {
									$tagesgericht = $res['gericht'];
								};
						echo "<select name='montag'>";

				    while ($row = $liste->fetch_assoc()) {
				                  unset($montag);
				                  $montag = $row['gericht'];
													if($montag == $tagesgericht){
														echo '<option value="'.$montag.'" selected="selected">'.$montag.'</option>';
													}else {
														echo '<option value="'.$montag.'">'.$montag.'</option>';
													};
						}
					echo "</select>";?>
				</td>
			</tr>
			<tr>
				<td>Dienstag</td>
				<td>
					<?php $liste = mysqli_query($mysqli, "SELECT gericht FROM gerichte");
								$db_gericht = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag='Dienstag'");
								while ($res = $db_gericht ->fetch_assoc()) {
									$tagesgericht = $res['gericht'];
								};
						echo "<select name='dienstag'>";

						while ($row = $liste->fetch_assoc()) {
													unset($dienstag);
													$dienstag = $row['gericht'];
													if($dienstag == $tagesgericht){
														echo '<option value="'.$dienstag.'" selected="selected">'.$dienstag.'</option>';
													}else {
														echo '<option value="'.$dienstag.'">'.$dienstag.'</option>';
													};
						}
					echo "</select>";?>
				</td>
			</tr>
			<tr>
				<td>Mittwoch</td>
				<td>
					<?php $liste = mysqli_query($mysqli, "SELECT gericht FROM gerichte");
								$db_gericht = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag='Mittwoch'");
								while ($res = $db_gericht ->fetch_assoc()) {
									$tagesgericht = $res['gericht'];
								};
						echo "<select name='mittwoch'>";

						while ($row = $liste->fetch_assoc()) {
													unset($mittwoch);
													$mittwoch = $row['gericht'];
													if($mittwoch == $tagesgericht){
														echo '<option value="'.$mittwoch.'" selected="selected">'.$mittwoch.'</option>';
													}else {
														echo '<option value="'.$mittwoch.'">'.$mittwoch.'</option>';
													};
						}
					echo "</select>";?>
				</td>
			</tr>
			<tr>
				<td>Donnerstag</td>
				<td>
					<?php $liste = mysqli_query($mysqli, "SELECT gericht FROM gerichte");
								$db_gericht = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag='Donnerstag'");
								while ($res = $db_gericht ->fetch_assoc()) {
									$tagesgericht = $res['gericht'];
								};
						echo "<select name='donnerstag'>";

						while ($row = $liste->fetch_assoc()) {
													unset($donnerstag);
													$donnerstag = $row['gericht'];
													if($donnerstag == $tagesgericht){
														echo '<option value="'.$donnerstag.'" selected="selected">'.$donnerstag.'</option>';
													}else {
														echo '<option value="'.$donnerstag.'">'.$donnerstag.'</option>';
													};
						}
					echo "</select>";?>
				</td>
			</tr>
      <tr>
				<td>Freitag</td>
				<td>
					<?php $liste = mysqli_query($mysqli, "SELECT gericht FROM gerichte");
								$db_gericht = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag='Freitag'");
								while ($res = $db_gericht ->fetch_assoc()) {
									$tagesgericht = $res['gericht'];
								};
						echo "<select name='freitag'>";

						while ($row = $liste->fetch_assoc()) {
													unset($freitag);
													$freitag = $row['gericht'];
													if($freitag == $tagesgericht){
														echo '<option value="'.$freitag.'" selected="selected">'.$freitag.'</option>';
													}else {
														echo '<option value="'.$freitag.'">'.$freitag.'</option>';
													};
						}
					echo "</select>";?>
				</td>
			</tr>
			<tr>
				<td>Samstag</td>
				<td>
					<?php $liste = mysqli_query($mysqli, "SELECT gericht FROM gerichte");
								$db_gericht = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag='Samstag'");
								while ($res = $db_gericht ->fetch_assoc()) {
									$tagesgericht = $res['gericht'];
								};
						echo "<select name='samstag'>";

						while ($row = $liste->fetch_assoc()) {
													unset($samstag);
													$samstag = $row['gericht'];
													if($samstag == $tagesgericht){
														echo '<option value="'.$samstag.'" selected="selected">'.$samstag.'</option>';
													}else {
														echo '<option value="'.$samstag.'">'.$samstag.'</option>';
													};
						}
					echo "</select>";?>
				</td>
			</tr>
			<tr>
				<td>Sonntag</td>
				<td>
					<?php $liste = mysqli_query($mysqli, "SELECT gericht FROM gerichte");
								$db_gericht = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene WHERE jahr='$jahr' AND kalenderwoche='$kalenderwoche' AND wochentag='Sonntag'");
								while ($res = $db_gericht ->fetch_assoc()) {
									$tagesgericht = $res['gericht'];
								};
						echo "<select name='sonntag'>";

						while ($row = $liste->fetch_assoc()) {
													unset($sonntag);
													$sonntag = $row['gericht'];
													if($sonntag == $tagesgericht){
														echo '<option value="'.$sonntag.'" selected="selected">'.$sonntag.'</option>';
													}else {
														echo '<option value="'.$sonntag.'">'.$sonntag.'</option>';
													};
						}
					echo "</select>";?>
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
	<table>
		<tr>
			<input type="submit" id="createList" name="einkaufsliste" value="Einkaufsliste erzeugen" function="createList()">
				<script>
				document.getElementById("createList").addEventListener("click", myFunction);
				function myFunction() {
					window.location.href="einkaufsliste.php?jahr=<?php echo $jahr ?>&kalenderwoche=<?php echo $kalenderwoche ?>";
				}
				</script>
		</tr>
	</table>
</body>
</html>
