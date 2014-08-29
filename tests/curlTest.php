<?php
/*
 * Curl test will request csv from Google Trends
 * Note - If run frequently your user will get blocked on the ip address and the return will say you"ve reached your quota
 *
 * Update search string with desired request
 *
 */
  require_once( getcwd().'/Creds.php');

  $creds = new Creds();
  $csvFile = "curl.csv";
  $handle = fopen($csvFile, "w") or die("Cannot open file: ".$csvFile);

  // Data Array for Authorization
  $data  = array(
    "accountType" => "GOOGLE",
    "Email"       => $creds->username,
    "Passwd"      => $creds->password,
    "service"     => "trendspro",
    "source"      => "company-application-1.0"
  );

  // String for search to be requested
  $searchRequest = "skiing";

  // Initial Curl to get Google Authorization
  // Returns SID and Auth
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_HTTPAUTH, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  echo $response."\n";
  preg_match("/Auth=([a-z0-9_\-]+)/i", $response, $auth);

  // We now have an authorization-token
  $headers = array(
    "Authorization: GoogleLogin auth=" . $auth[1],
    "GData-Version: 3.0"
  );
  // Extract SID
  preg_match("/SID=(.+)/", $response, $sid);

  // // Erase POST variables used on the previous xhttp call
  $data = array();

  // // Set the SID in cookies
  $data["cookies"] = array(
    "SID" => $sid[1]
  );

  curl_setopt( $ch, CURLOPT_URL, "https://www.google.com/trends/trendsReport?hl=en-US&q=".$searchRequest."&content=1&export=1" );
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_POST, false);
  $csv = curl_exec($ch);
  curl_close($ch);

  fwrite($handle, $csv);
  fclose($handle);

  $csv = explode("\n",$csv);

  echo json_encode($csv);

?>
