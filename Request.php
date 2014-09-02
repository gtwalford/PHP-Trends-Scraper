<?php
/*
 * Once Google SID is provided request Trends CSV
 */
require_once(__DIR__."/Creds.php");

Class Request {
  private $headers;
  private $cookies;

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

    //We now have an authorization-token
    $this->headers = array(
      "Authorization: GoogleLogin auth=" . $auth[1],
      "GData-Version: 3.0"
    );

    // Set the SID in cookies
    $this->cookies["cookies"] = array(
      "SID" => $sid[1]
    );

  }

  public function getTrends( $searchTerm){
    $url = "https://www.google.com/trends/trendsReport?hl=en-US&q=".$searchTerm."&content=1&export=1";
    assert(isset($this->headers));
    assert(isset($this->cookies));

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->cookies);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, false);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;

  } 

}

?>
