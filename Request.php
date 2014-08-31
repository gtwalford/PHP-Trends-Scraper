<?php
/*
 * Once Google SID is provided request Trends CSV
 */
require_once(__DIR__."/Creds.php");

Class Request {

  // Initial Curl to get Google Authorization
  // Returns SID and Auth
  public function getAuth(){

    $creds = new Creds();
    $data = array (
      "accountType" => "GOOGLE",
      "Email"       => $creds->username,
      "Passwd"      => $creds->password,
      "service"     => "trendspro",
      "source"      => "company-application-1.0"
    );
    $url = "https://www.google.com/accounts/ClientLogin";

    echo json_encode( $data );
    assert( isset($data["Email"]) && isset($data["Passwd"]) );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
    curl_setopt($ch, CURLOPT_HTTPAUTH, false );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    $response = curl_exec( $ch );
    curl_close( $ch );

    // Extract Authorization Header
    preg_match("/Auth=([a-z0-9_\-]+)/i", $response, $auth);
    // Extract SID
    preg_match("/SID=(.+)/", $response, $sid);

    // Erase POST variables used on the previous xhttp call
    $data = array();

    //We now have an authorization-token
    $data["headers"] = array(
      "Authorization" => "GoogleLogin auth=" . $auth[1],
      "GData-Version" =>  "3.0"
    );

    // Set the SID in cookies
    $data["cookies"] = array(
      "SID" => $sid[1]
    );

    return $data;
  }

  public function getTrends( $searchTerm, $params ){
    $url = "https://www.google.com/trends/trendsReport?hl=en-US&q=".$searchTerm."&content=1&export=1";
    assert( isset($params["headers"]) && isset($params["cookies"]) );

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $params["headers"]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params["cookies"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, false);

    $csv = curl_exec($ch);
    curl_close($ch);

    return $csv;

  } 

}

?>
