<!DOCTYPE html>
<head>
	<title>Rezept bearbeiten</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<?php
	// Include database connection file
	include_once("config.php");

	// Retrieve gericht value from querystring parameter
	$gericht = $_GET['gericht'];

	// Get Zutaten by gericht/ rezept
	$result = mysqli_query($mysqli, "SELECT * FROM rezepte WHERE gericht='$gericht'");
	?>
		<table>
			<tr>
				<td style="background-color: lightblue; color: black; text-align: center; font-size: 22px;">Gericht: <?php echo $gericht ?>
					<div class="col-md-12 head">
							<div class="float-left">
									<a href="exportRezepte.php" class="btn btn-success" style="color:red"><i class="dwn"></i> Export Daten</a>
							</div>
					</div>
					<div class="col-md-12 head">
							<div class="float-left">
									<a href="importRezepteForm.php" class="btn btn-success" style="color:green"><i class="dwn"></i> Import Daten</a>
							</div>
					</div></td>
			</tr>
		</table>
		<table>
			<tr>
				<td>Zutat</td>
				<td>Menge</td>
				<td>Einheit</td>
				<td><a class="button" href="add_rezepteintrag.php?gericht=<?php echo $gericht ?>">Neue Zutat</a>
						<a class="button" href="index.php">Zurück</a>
				</td>
			<tr>
				<?php
				// Print contacts
				while($res = mysqli_fetch_array($result)) {
					echo "<tr>";
					echo "<td>".$res['zutat']."</td>";
					echo "<td>".$res['rezeptmenge']."</td>";
					echo "<td>".$res['einheit']."</td>";
					echo "<td><a href=\"edit_rezepteintrag.php?gericht=$res[gericht]&zutat=$res[zutat]\">Edit</a> |
										<a href=\"delete_rezepteintrag.php?id=$res[id]&gericht=$res[gericht]\" onClick=\"return confirm('Soll die Zutat wirklich gelöscht werden?')\">Delete</a></td>";
				}
				?>
		</table>
</body>
</html>
<?php

if(isset($_POST['update']))
{
	// Retrieve record values
	$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	$gericht = mysqli_real_escape_string($mysqli, $_POST['gericht']);
	$zutat = mysqli_real_escape_string($mysqli, $_POST['zutat']);
	$rezeptmenge = mysqli_real_escape_string($mysqli, $_POST['rezeptmenge']);
	$einheit = mysqli_real_escape_string($mysqli, $_POST['einheit']);
	$portionen = mysqli_real_escape_string($mysqli, $_POST['portionen']);

	$gerichtErr= $zutatErr = $rezeptmengeErr = $einheitErr = $portionenErr = "";

		// check if entry exists
		$result = mysqli_query($mysqli, "SELECT * FROM rezepte WHERE id=$id");

		// Beispiel für update oder create
		if ($result->num_rows == 0) {
			$stmt = $mysqli->prepare("INSERT INTO rezepte(gericht,zutat,rezeptmenge,einheit,portionen) VALUES(?, ?, ?, ?, ?)");
			$stmt->bind_param("ssisi",  $gericht, $zutat, $rezeptmenge, $einheit, $portionen);
			$stmt->execute();
		} else {
		// Execute UPDATE
		$stmt = $mysqli->prepare("UPDATE rezepte SET zutat=?, rezeptmenge=?, einheit=?, portionen=? WHERE gericht=? and zutat=?");
		$stmt->bind_param("ssisi",  $gericht, $zutat, $rezeptmenge, $einheit, $portionen);
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
