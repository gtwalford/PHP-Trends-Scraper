<?php
 /*
  * Get Authorization through Google Login
  */
require_once(__DIR__."/Creds.php");

Class Auth {

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

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPAUTH, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);
    //echo $response;

    // Extract Authorization Header
    preg_match("/Auth=([a-z0-9_\-]+)/i", $response, $auth);
    // Extract SID
    preg_match("/SID=(.+)/", $response, $sid);

    // // Erase POST variables used on the previous xhttp call
    $data = array();

    // We now have an authorization-token
    $data["headers"] = array(
      "Authorization" => "GoogleLogin auth=" . $auth[1],
      "GData-Version" =>  "3.0"
    );

    // // Set the SID in cookies
    $data["cookies"] = array(
      "SID" => $sid[1]
    );

    echo "======================\n".json_encode( $data )."\n======================\n";

    return $data;
  }

}

?>
