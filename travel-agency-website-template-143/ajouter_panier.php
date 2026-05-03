<?php
session_start();

$id = $_GET['id'];

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// si produit existe déjà
if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]++;
} else {
    $_SESSION['panier'][$id] = 1;
}

header("Location: produits.php");
exit;
?>