<?php
session_start();
require_once "utilisateur.class.php";

$us = new Utilisateur();

if (isset($_POST['login'])) {

    $us->email = $_POST["email"];
    $us->mot_de_passe = $_POST["pwd"];

    try {
        $res = $us->getUser();         
        $data = $res->fetchAll(PDO::FETCH_ASSOC);            

        if ($data) {
            $_SESSION["connecte"] = "1";
            $_SESSION["email"] = $data[0]["email"];
            $_SESSION["role"] = $data[0]["role"];

            // Redirection selon rôle
            if ($data[0]["role"] == "admin") {
                header("location:backoffice/dashboard.php");
            } else {
                header("location:index.php");
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