<?php

require_once(__DIR__.'/Auth.php');
require_once(__DIR__.'/Request.php');
require_once(__DIR__.'/Parse.php');

$auth = new Auth();
$request = new Request();
$parse = new Parse();

// Get Google Authorization by logging in
$auth->getAuth();

// Request CSV from Google Trends

// Parse CSV

// Store Return

?>
