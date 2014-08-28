<?php
  $csvFile = "curl.csv";
  $handle = fopen($csvFile, "r") or die("Cannot open file: ".$csvFile);
  $csv = fread($handle, filesize($csvFile) );

  $searchTerm = "pudding";

  $csv = explode("Top regions", $csv);
  $csv = explode("\n",$csv[0]);
  for( $i = 0, $iLen = count($csv); $i < $iLen; $i++ ){
    $csv[$i] = explode(",", $csv[$i] );
    //$csv[$i] = json_encode( $csv[$i] );
    if( $csv[$i] == "" || !isset($csv[$i][1]) ){
      unset($csv[$i]);
    }
  }
  $csv = array_values($csv);
  
  echo json_encode($csv);

?>
