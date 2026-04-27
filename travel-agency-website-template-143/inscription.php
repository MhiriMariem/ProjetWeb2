<?php
session_start();
require_once "pdo.php";

$message = "";

if (isset($_POST["register"])) {

    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $mot_de_passe = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    $role = "client";

    try {
        $sql = "INSERT INTO utilisateur(nom, email, telephone, mot_de_passe, role)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $email, $telephone, $mot_de_passe, $role]);

        $message = "Compte créé avec succès 👍";

    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
?>