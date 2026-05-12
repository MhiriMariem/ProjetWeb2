<?php
session_start();

require_once "pdo.php";

$cnx = new connexion();
$conn = $cnx->CNXbase();

 //recuperer l'id de la produit dans l'url cad prend la valeur dans l'url et le met dans l'id 
$id = $_GET['id'];

/* initialiser panier */
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

/* récupérer produit */
$sql = "SELECT * FROM produit WHERE id_produit = $id";
$res = $conn->query($sql);
$produit = $res->fetch();

/* ajouter au panier */
if ($produit) {

    $exist = false;

    /*on parcourt tous les produits du panier un par un*/
    for ($i = 0; $i < count($_SESSION['panier']); $i++) {

        if ($_SESSION['panier'][$i]['id'] == $id) {

            $_SESSION['panier'][$i]['quantite']++;

            $exist = true;

            break;
        }
    }

    /* sinon ajouter nouveau produit */
    if (!$exist) {

        $_SESSION['panier'][] = [
            'id' => $produit['id_produit'],
            'nom' => $produit['nom'],
            'prix' => $produit['prix'],
            'quantite' => 1
        ];
    }
}

/* retour page produits */
header("Location: produits.php");
exit();
?>