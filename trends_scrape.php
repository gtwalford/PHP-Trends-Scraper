<?php

  require_once(__DIR__.'/Request.php');
  require_once(__DIR__.'/Parse.php');

  $request = new Request();
  $parse = new Parse();
  $searchTerm = 'skiing';

  // Get Google Authorization by logging in
  $headers = $request->getAuth();

  // Request CSV from Google Trends
  $csv = $request->getTrends($searchTerm);
  assert( isset($csv) && is_string($csv), 0);

  // Parse CSV
  //$parse->extractData();


  // Store Return

?>
