<?php
// Load the database configuration file
include_once 'config.php';

if(isset($_POST['importSubmit'])){

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){

        // If the file is uploaded
        if(is_uploaded_file($_FILES['file']['tmp_name'])){

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row dat
                $gericht = $line[0];
                $zutat = $line[1];
                $rezeptmenge  = $line[2];
                $einheit = $line[3];


                // Check whether member already exists in the database with the same gericht
                $prevResult = mysqli_query($mysqli, "SELECT * FROM rezepte WHERE gericht='$gericht' AND zutat='$zutat'");
                $dbstate = mysqli_fetch_array($prevResult);

                if($prevResult->num_rows > 0){
                  $dbRezeptmenge = $dbstate['rezeptmenge'];
                  $dbEinheit = $dbstate['einheit'];
                    // Update member data in the database
                    if($dbRezeptmenge != $rezeptmenge or $dbEinheit != $einheit){
                      $stmt = $mysqli->prepare("UPDATE rezepte SET rezeptmenge=?, einheit=? WHERE gericht=? AND zutat=?");
                      $stmt->bind_param("isss", $rezeptmenge, $einheit, $gericht, $zutat);
                      $stmt->execute();
                    }
                }else{
                    // Insert member data in the database
                    $mysqli->query("INSERT INTO rezepte(gericht, zutat, rezeptmenge, einheit) VALUES ('".$gericht."', '".$zutat."', ".$rezeptmenge.", '".$einheit."')");
                }
                unset($gericht);
                unset($zutat);
                unset($rezeptmenge);
                unset($einheit);
            }

            // Close opened CSV file
            fclose($csvFile);

            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
}

// Redirect to the listing page
header("Location: index.php".$qstring);
