<?php

  require_once(__DIR__.'/Request.php');
  require_once(__DIR__.'/Parse.php');

  $request = new Request();
  $parse = new Parse();
  $searchTerm = "skiing";

  // Get Google Authorization by logging in
  $headers = $request->getAuth();

  // Request CSV from Google Trends
  $trends = $request->getTrends( $searchTerm );
  assert( isset( $trends ) );

  // Parse CSV
  $cleanTrends = $parse->cleanData( $trends );
  echo "\n=============\n".json_encode( $cleanTrends )."\n=============\n";
  echo $parse->addData( $cleanTrends );


  // Store Return

?>
