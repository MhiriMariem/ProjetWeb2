<?php
// ====================== PHP EN HAUT ======================
session_start();
require_once "pdo.php";

if (!isset($_SESSION["connecte"]) || $_SESSION["connecte"] != "1") {
    header("Location: login.html");
    exit();
}

$email = $_SESSION["email"];

$cnx = new connexion();
$conn = $cnx->CNXbase();

$stmt = $conn->prepare("SELECT nom, email, telephone, role FROM utilisateur WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Erreur : Utilisateur introuvable.";
    exit();
}
?>