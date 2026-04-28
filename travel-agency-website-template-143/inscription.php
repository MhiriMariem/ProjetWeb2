<?php
session_start();
require_once "pdo.php";

$cnx = new connexion();
$conn = $cnx->CNXbase();

if (isset($_POST["register"])) {

    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $mot_de_passe = $_POST["pwd"]; 
    $role = "client";

    try {
        $sql = "INSERT INTO utilisateur(nom, email, telephone, mot_de_passe, role)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $email, $telephone, $mot_de_passe, $role]);

        header("Location: index.php?success=1");
        exit();

    } catch (PDOException $e) {
        header("Location: inscription.html?error=1");
        exit();
    }
}
?>