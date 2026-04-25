<?php
class connexion
{ 
public function CNXbase()
  {
    $dbc=new PDO('mysql:host=localhost;dbname=camping','root',''); 
    return $dbc;
  }   
}
?>