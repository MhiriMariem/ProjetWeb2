<?php        
class Utilisateur
{
    public $email;
    public $mot_de_passe;

    function getUser()
    {
require_once('pdo.php');
$cnx=new connexion();
$pdo=$cnx->CNXbase();
        $sql = "SELECT * FROM utilisateur 
                WHERE email='$this->email' 
                AND mot_de_passe='$this->mot_de_passe'";

$res=$pdo->query($sql) or print_r($pdo->errorInfo()); 	

        return $res;
    }
}
?>