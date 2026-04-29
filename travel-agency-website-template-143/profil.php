
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Camp&Co | Mon Profil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style1.css">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>

<body>
<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "client") {
    header("Location: ../template/login.php");
    exit();
}

$email = $_SESSION["email"]; // IMPORTANT

$cnx = new connexion();
$conn = $cnx->CNXbase();

$stmt = $conn->prepare("SELECT nom, email, telephone, role FROM utilisateur WHERE email = ?");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// sécurité
if (!$user) {
    $user = [
        "nom" => "",
        "email" => "",
        "telephone" => "",
        "role" => ""
    ];
}
?>
<header class="text-center py-3">
    <h3><a href="index.php" style="text-decoration:none;color:#000;">Camp&Co</a></h3>
</header>

<div class="profile-container profile-card">

    <div class="profile-header">
        <i class="fa fa-user-circle"></i>
        <h2>Mon Profil</h2>
    </div>

    <div class="profile-info">

        <div class="info-box">
            <label>Nom :</label>
            <span><?= htmlspecialchars($user["nom"] ?? 'Non renseigné') ?></span>
        </div>

        <div class="info-box">
            <label>Email :</label>
            <span><?= htmlspecialchars($user["email"]) ?></span>
        </div>

        <div class="info-box">
            <label>Téléphone :</label>
            <span><?= htmlspecialchars($user["telephone"] ?? 'Non renseigné') ?></span>
        </div>

        <div class="info-box">
            <label>Rôle :</label>
            <span><?= htmlspecialchars($user["role"]) ?></span>
        </div>

    </div>

    <div class="profile-actions">
        <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
        <a href="logout.php" class="btn btn-danger">Déconnexion</a>
    </div>

</div>

</body>
</html>