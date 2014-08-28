<?php
  $csvFile = 'curl.csv';
  $handle = fopen($csvFile, 'w') or die('Cannot open file: '.$csvFile);

  $data  = array(
    'accountType' => 'GOOGLE',
    'Email'       => 'cpbhotornot@gmail.com',
    'Passwd'      => 'coolcrispin',
    'service'     => 'trendspro',
    'source'      => 'company-application-1.0'
  );

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
     preg_match('/SID=(.+)/', $response, $sid);
    
    // // Erase POST variables used on the previous xhttp call
     $data = array();
    
    // // Set the SID in cookies
     $data['cookies'] = array(
       'SID' => $sid[1]
     );

    //curl_setopt($ch, CURLOPT_URL, "http://www.google.com/trends/viz?q=pudding&date=2013-2&geo=all&graph=all_csv&sort=0&sa=N");
    curl_setopt( $ch, CURLOPT_URL, "https://www.google.com/trends/trendsReport?hl=en-US&q=pudding&content=1&export=1" );
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
    
    $csv = explode('\n',$csv);
    for( $i = 0, $iLen = count($csv); $i < $iLen; $i++ ){
      $csv[i] = explode(',', $csv[i] );
    }

  // Returns : "You must be signed in to export data from Google Trends"
  // Expected: CSV data stream
  print_r(json_encode($csv));

?>
