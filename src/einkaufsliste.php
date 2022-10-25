<!DOCTYPE html>
<head>
	<title>Einkausliste</title>
	<link rel="stylesheet" href="styles.css" />
</head>
<body>
	<?php
	// Include database connection file
	include_once("config.php");

	if(isset($_POST['update']))
	{
			// Redirect to home page (index.php)
			header("Location: index.php");
	}
	else if (isset($_POST['cancel'])) {
		// Redirect to home page (index.php)
		header("Location: index.php");
	}
	?>
	<?php
	function consolidateList(array $einkaufsliste){

		for ($i=0; $i < count($einkaufsliste); $i++) {
			for ($j=$i+1; $j < count($einkaufsliste); $j++) {
				if ($einkaufsliste[$i]['zutat'] == $einkaufsliste[$j]['zutat']
				and $einkaufsliste[$i]['einheit'] == $einkaufsliste[$j]['einheit']) {
					$sortedlist[$i]['zutat'] = $einkaufsliste[$i]['zutat'];
					if (isset($sortedlist[$i]['rezeptmenge'])){
						$sortedlist[$i]['rezeptmenge'] = $sortedlist[$i]['rezeptmenge'] + $einkaufsliste[$j]['rezeptmenge'];
					} else {
						$sortedlist[$i]['rezeptmenge'] = $einkaufsliste[$i]['rezeptmenge'] + $einkaufsliste[$j]['rezeptmenge'];
					}
					$sortedlist[$i]['einheit'] = $einkaufsliste[$i]['einheit'];
					\array_splice($einkaufsliste, $j, 1);
				}
			}
			if (!isset($sortedlist[$i])) {
				$sortedlist[$i]['zutat'] = $einkaufsliste[$i]['zutat'];
				$sortedlist[$i]['rezeptmenge'] = $einkaufsliste[$i]['rezeptmenge'];
				$sortedlist[$i]['einheit'] = $einkaufsliste[$i]['einheit'];
			}
		};
		return $sortedlist;
	};
	// Retrieve gericht value from querystring parameter
	$jahr = $_GET['jahr'];
	$kalenderwoche = $_GET['kalenderwoche'];
	$gerichte = mysqli_query($mysqli, "SELECT gericht FROM wochenplaene
																										WHERE jahr='$jahr'
																										AND kalenderwoche='$kalenderwoche'");

	if (!isset($gerichte)) {
		header("Location: wochenplan.php?jahr=$jahr&kalenderwoche=$kalenderwoche");
	} else {
		$i=0;
		while($gericht = $gerichte->fetch_assoc()) {
			unset($tagesliste);
			$mahlzeit = $gericht['gericht'];
			$rezepteintrag = mysqli_query($mysqli, "SELECT zutat, rezeptmenge, einheit FROM rezepte
																																								 WHERE gericht='$mahlzeit'");

			while($res = mysqli_fetch_array($rezepteintrag)) {
				$einkaufsliste[$i] = $res;
				$i++;
			}
		}
	};
	//$sortedlist = $einkaufsliste;
	if (isset($einkaufsliste)) {
		$sortedlist = consolidateList($einkaufsliste);
	} else {
		header("Location: wochenplan.php?jahr=$jahr&kalenderwoche=$kalenderwoche");
	};
	?>
		<table>
			<tr>
				<td>Zutat</td>
				<td>Menge</td>
				<td>Einheit</td>
				<td><a class="button" href="index.php">Zurück</a></td>
			</tr>
				<?php
				// Print contacts
				foreach ($sortedlist as $row) {
					echo "<tr>";
					echo "<td>".$row['zutat']."</td>";
					echo "<td>".$row['rezeptmenge']."</td>";
					echo "<td>".$row['einheit']."</td>";
				/*	echo "<td><a href=\"edit_rezepteintrag.php?gericht=$res[gericht]&zutat=$res[zutat]\">Edit</a> |
										<a href=\"delete_rezepteintrag.php?gericht=$res[gericht]&zutat=$res[zutat]\" onClick=\"return confirm('Soll die Zutat wirklich gelöscht werden?')\">Delete</a></td>";
				*/
				echo "</tr>";
				}
				?>
		</table>
</body>
</html>
