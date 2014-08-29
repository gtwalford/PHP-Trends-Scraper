<?php
/*
 * Set Google Credentials here
 */
Class Creds {

  // User name is gmail account - User@gmail.com
  private $username = "";
  // Add Password
  private $password = "";

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }
}

?>
