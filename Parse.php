<?php
/*
 *Parse data returned from Google Trends
 */

Class Parse {

  public static function cleanData( $data ){
    $data = explode("Top regions", $data );
    $data = explode("\n",$data[0]);

    for( $i = 0, $iLen = count($data); $i < $iLen; $i++ ){
      $data[$i] = explode(",", $data[$i] );
      if( $data[$i] == "" || !isset( $data[$i][1] ) ){
        unset( $data[$i] );
      }
    }
    $data = array_values( $data );

    return $data;
  }
}

?>
