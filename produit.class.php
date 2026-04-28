<?php        
class Produit
{
/* attributs de la classe produit*/
	
public $id_produit;
public $nom;
public $description;
public $prix;
public $photo;
/* constructeur de la classe */


function insertProduit()
{
require_once('pdo.php');
$cnx=new connexion();
$pdo=$cnx->CNXbase();
$req="INSERT INTO produit (nom,description,prix,photo) VALUES
('$this->nom','$this->description','$this->prix','$this->photo')";

$pdo->exec($req) or print_r($pdo->errorInfo());
}


 } ?>
