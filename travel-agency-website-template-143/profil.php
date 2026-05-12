<?php
session_start();
require_once "pdo.php";

/* connexion */
$cnx = new connexion();
$conn = $cnx->CNXbase();

/* sécurité */
if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "client") {
    header("Location: ../template/login.php");
    exit();
}

/* email utilisateur */
$email = $_SESSION["email"];

/* UPDATE profil */
if (isset($_POST['action']) && $_POST['action'] == "update") {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];

    $sql = "UPDATE utilisateur 
            SET nom='$nom', prenom='$prenom', telephone='$telephone'
            WHERE email='$email'";

    $conn->exec($sql);

    $_SESSION['message'] = "Profil mis à jour";
    header("Location: profil.php");
    exit();
}

/* SELECT utilisateur */
$sql = "SELECT * FROM utilisateur WHERE email='$email'";
$res = $conn->query($sql);
$user = $res->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camp&Co · Mon profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style1.css">
    <style>
        .profile-card { max-width: 600px; margin: 0 auto; }
        .info-row { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ecf2e8; padding: 1rem 0; }
        .info-label { font-weight: 600; color: #2c5a36; width: 120px; }
        .info-value { flex: 1; color: #1a2e22; }
        .btn-edit { background: none; border: none; color: #2c7a47; cursor: pointer; font-size: 1.1rem; }
        .btn-edit:hover { color: #1e5c32; }
        .btn-save { background: #1f5e34; color: white; border: none; padding: 0.75rem; border-radius: 40px; font-weight: 600; width: 100%; cursor: pointer; }
        .btn-save:hover { background: #154a28; }
        .message { background: #dff0e1; color: #1f5e34; padding: 0.75rem; border-radius: 20px; text-align: center; margin-bottom: 1.5rem; }
        .profile-actions .btn{
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: 0.3s;
    display: inline-block;
}

/* 🔴 ANNULER */
.profile-actions .btn--secondary:first-child{
    background-color: #ffc1cc;
    color: red;
}

.profile-actions .btn--secondary:first-child:hover{
    background-color: #ff9fb0;
}

/* 🟢 MODIFIER */
.profile-actions .btn--secondary:last-of-type{
    background-color: #d6d6d6;
    color: #333;
}

.profile-actions .btn--secondary:last-of-type:hover{
    background-color: #bfbfbf;
}

/* ⚫ DECONNEXION */
.profile-actions .btn--danger{
    background-color: #4b5320;
    color: white;
}

.profile-actions .btn--danger:hover{
    background-color: #3d4419;
}
.profile-actions button{
    border: none;
    cursor: pointer;
    background-color: #d6d6d6;
    color: #333;
}

.profile-actions button:hover{
    background-color: #bfbfbf;
}
    </style>
</head>
<body>

<header class="header">
    <div class="container header__container">
        <a href="index.php" class="brand">Camp&Co</a>
    </div>
</header>

<main class="main">
    <div class="container">
        <div class="profile-card login-card">
            <div class="login-card__header">
                <i class="fas fa-user-circle login-card__icon"></i>
                <h1>Mon profil</h1>
                <p>Consultez et modifiez vos informations</p>
            </div>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="message"><i class="fas fa-check-circle"></i> <?= ($_SESSION['message']); unset($_SESSION['message']); ?></div>
            <?php endif; ?>

            <form method="POST">

    <input type="hidden" name="action" value="update">

    <div class="profile-info">

        <div class="info-row">
            <span class="info-label">Nom :</span>

            <input type="text"
                   name="nom"
                   class="form-control"
                   value="<?= ($user["nom"]) ?>">
        </div>

        <div class="info-row">
            <span class="info-label">Prénom :</span>

            <input type="text"
                   name="prenom"
                   class="form-control"
                   value="<?= ($user["prenom"]) ?>">
        </div>

        <div class="info-row">
            <span class="info-label">Email :</span>

            <input type="email"
                   class="form-control"
                   value="<?= ($user["email"]) ?>"
                   readonly>
        </div>

        <div class="info-row">
            <span class="info-label">Téléphone :</span>

            <input type="text"
                   name="telephone"
                   class="form-control"
                   value="<?= ($user["telephone"]) ?>">
        </div>

        <div class="info-row">
            <span class="info-label">Rôle :</span>

            <input type="text"
                   class="form-control"
                   value="<?= ($user["role"]) ?>"
                   readonly>
        </div>

    </div>

    <div class="profile-actions"
         style="display:flex; gap:1rem; justify-content:center; margin-top:2rem;">

        <a href="index.php" class="btn btn--secondary">
            ANNULER
        </a>

        <button type="submit" class="btn btn--secondary">
            ENREGISTRER
        </button>

        <a href="logout.php" class="btn btn--danger">
            DECONNEXION
        </a>

    </div>

</form>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container footer__container">
        <p>&copy; 2025 Camp&Co – Tous droits réservés</p>
    </div>
</footer>

</body>
</html>