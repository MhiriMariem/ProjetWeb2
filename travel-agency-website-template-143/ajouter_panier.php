<?php
session_start();
require_once "pdo.php";

$cnx = new connexion();
$conn = $cnx->CNXbase();

$id = $_GET['id'];

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

/* récupérer produit */
$stmt = $conn->prepare("SELECT * FROM produit WHERE id_produit = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if ($produit) {

    $found = false;

    foreach ($_SESSION['panier'] as $index => $item) {

        if ($item['id'] == $id) {
            $_SESSION['panier'][$index]['quantite'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['panier'][] = [
            'id' => $produit['id_produit'],
            'nom' => $produit['nom'],
            'prix' => $produit['prix'],
            'quantite' => 1
        ];
    }
}

header("Location: produits.php");
exit;
?>