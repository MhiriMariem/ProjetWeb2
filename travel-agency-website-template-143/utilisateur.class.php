<?php        
class Utilisateur
{
    public $email;
    public $mot_de_passe;

    function getUser()
    {
    require_once('pdo.php');
    $cnx = new connexion();
    $pdo = $cnx->CNXbase();

    $sql = "SELECT id_utilisateur, nom,prenom, email, role, mot_de_passe
            FROM utilisateur
            WHERE email = ? AND mot_de_passe = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $this->email,
        $this->mot_de_passe
    ]);

    return $stmt;
    }}
?>