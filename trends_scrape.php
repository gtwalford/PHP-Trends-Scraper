<?php

require_once(__DIR__.'/Auth.php');
require_once(__DIR__.'/Request.php');
require_once(__DIR__.'/Parse.php');

$auth = new Auth();
$request = new Request();
$parse = new Parse();
$searchTerm = 'skiing';

// Get Google Authorization by logging in
$headers = $request->getAuth();
echo "\n<^^^^^^^^^^^^^^^^^^^^^^^^^^^\n".json_encode($headers)."\n^^^^^^^^^^^^^^^^^^^^^^^^^^^^\n";
assert( isset($headers) );

// Request CSV from Google Trends
$csv = $request->getTrends($searchTerm, $headers);
echo "\n<^^^^^^^^^^^^^^^^^^^^^^^^^^^\n".json_encode($csv)."\n^^^^^^^^^^^^^^^^^^^^^^^^^^^^\n";
assert( isset($csv) && is_string($csv), 0);

// Parse CSV
//$parse->extractData();


// Store Return

?>
