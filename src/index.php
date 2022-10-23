<?php
// Include the database connection file
include_once("config.php");

// Fetch contacts (in descending order)
$result = mysqli_query($mysqli, "SELECT * FROM gerichte ORDER BY id DESC");

// Get current week NumberFormatter
$ddate = date("Y-m-d");
$date = new DateTime($ddate);
$kalenderwoche = $date->format("W");
$jahr = date("Y");
?>
<html>
<head>
	<title>MariaDB Essensplan</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<table>
		<tr>
			<td style="background-color: lightblue; color: black; text-align: center; font-size: 22px;">Gerichte
				<div class="col-md-12 head">
						<div class="float-left">
								<a href="exportGerichte.php" class="btn btn-success" style="color:red"><i class="dwn"></i> Export Daten</a>
						</div>
				</div>
				<div class="col-md-12 head">
						<div class="float-left">
								<a href="importGerichteForm.php" class="btn btn-success" style="color:green"><i class="dwn"></i> Import Daten</a>
						</div>
				</div></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>Gericht</td>
			<td>Quelle</td>
			<td>Dauer</td>
			<td>Portionen</td>
			<td>Kommentar</td>
			<td><a class="button" href="add_gericht.php">Neues Gericht</a>
					<a class="button" href="wochenplan.php?jahr=<?php echo $jahr ?>&kalenderwoche=<?php echo $kalenderwoche ?>">Wochenplan</a></td>
		</tr>
		<?php
		// Print contacts
		while($res = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>".$res['gericht']."</td>";
			echo "<td>".$res['quelle']."</td>";
			echo "<td>".$res['dauer']."</td>";
			echo "<td>".$res['portionen']."</td>";
			echo "<td>".$res['kommentar']."</td>";
			echo "<td><a href=\"naehrwerte.php?gericht=$res[gericht]\">Nährwerte bearbeiten</a> |
								<a href=\"rezept.php?gericht=$res[gericht]\">Rezept bearbeiten</a> |
								<a href=\"edit_gericht.php?id=$res[id]\">Edit</a> |
								<a href=\"delete_gericht.php?id=$res[id]\" onClick=\"return confirm('Soll das Gericht wirklich gelöscht werden?')\">Delete</a></td>";
			echo "</tr>";
		}
		?>
	</table>
</body>
</html>
