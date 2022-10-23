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
                $quelle = $line[1];
                $dauer  = $line[2];
                $portionen = $line[3];
                $kommentar = $line[4];

                // Check whether member already exists in the database with the same gericht
                $prevResult = mysqli_query($mysqli, "SELECT * FROM gerichte WHERE gericht='$gericht'");
                $dbstate = mysqli_fetch_array($prevResult);

                if($prevResult->num_rows > 0){
                  $dbQuelle = $dbstate['quelle'];
                  $dbDauer = $dbstate['dauer'];
                  $dbPortionen= $dbstate['portionen'];
                  $dbKommentar = $dbstate['kommentar'];
                    // Update member data in the database
                    if($dbQuelle != $quelle or $dbDauer != $dauer or $dbPortionen != $portionen or $dbKommentar != $kommentar){
                      $stmt = $mysqli->prepare("UPDATE gerichte SET quelle=?, dauer=?, portionen=?, kommentar=? WHERE gericht=?");
                      $stmt->bind_param("siisi", $quelle, $dauer, $portionen, $kommentar, $gericht);
                      $stmt->execute();
                    }
                }else{
                    // Insert member data in the database
                    $mysqli->query("INSERT INTO gerichte(gericht, quelle, dauer, portionen, kommentar) VALUES ('".$gericht."', NULLIF('".$quelle."', ''), NULLIF('".$dauer."', ''), NULLIF('".$portionen."', ''), NULLIF('".$kommentar."', ''))");
                }
                unset($gericht);
                unset($quelle);
                unset($dauer);
                unset($portionen);
                unset($kommentar);
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
