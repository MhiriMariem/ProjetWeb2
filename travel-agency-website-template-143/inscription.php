<?php
session_start();
require_once "pdo.php";

$cnx = new connexion();
$conn = $cnx->CNXbase();

if (isset($_POST["register"])) {

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];
    $mot_de_passe = $_POST["pwd"]; 
    $confirm_pwd = $_POST["confirm_pwd"];

    if ($mot_de_passe !== $confirm_pwd) {
    header("Location: inscription.php?error=pwd");
    exit();
    }

    $role = "client";
    $hashedPassword = md5($mot_de_passe);

    try {
        $sql = "INSERT INTO utilisateur(nom,prenom, email, telephone, mot_de_passe, role)
                VALUES (?, ?, ?, ?,?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom,$prenom, $email, $telephone, $hashedPassword, $role]);

        header("Location: index.php?success=1");
        exit();

    } catch (PDOException $e) {
        header("Location: inscription.php?error=1");
        exit();
    }
}
?>