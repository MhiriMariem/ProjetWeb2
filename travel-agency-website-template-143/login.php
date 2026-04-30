<?php
session_start();
require_once "utilisateur.class.php";

$us = new Utilisateur();

if (isset($_POST['login'])) {

    $us->email = $_POST["email"];
    
    $motDePasse = md5($_POST['pwd']);
    $us->mot_de_passe = $motDePasse;
    try {
        $res = $us->getUser();         
        $data = $res->fetchAll(PDO::FETCH_ASSOC);            

        if ($data) {
            $_SESSION["connecte"] = "1";
            $_SESSION["email"] = $data[0]["email"];
            $_SESSION["role"] = $data[0]["role"];
            $_SESSION["nom"] = $data[0]["nom"];

            if ($data[0]["role"] == "admin") {
                header("Location: ../dashboard/src/index.php");
            } else {
                header("Location: index.php");
            }
            exit();

        } else {
            echo "Aucun utilisateur trouvé";
        }

    } catch (PDOException $e) {
        echo "ERREUR : " . $e->getMessage();
    }
}
?>