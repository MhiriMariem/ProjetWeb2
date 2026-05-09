<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "client") {
    header("Location: ../template/login.php");
    exit();
}

$email = $_SESSION["email"];
$cnx = new connexion();
$conn = $cnx->CNXbase();

// Mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $new_nom = trim($_POST['nom']);
    $new_prenom = trim($_POST['prenom']);
    $new_telephone = trim($_POST['telephone']);
    $user_email = $_SESSION['email'];

    if (!empty($new_nom)) {
        $stmtUpdate = $conn->prepare("UPDATE utilisateur SET nom = ?, prenom = ?, telephone = ? WHERE email = ?");
        $stmtUpdate->execute([$new_nom, $new_prenom,$new_telephone, $user_email]);
        $_SESSION['message'] = "Profil mis à jour avec succès.";
        header("Location: profil.php");
        exit();
    }
}

// Récupération des données
$stmt = $conn->prepare("SELECT nom, prenom,email, telephone, role FROM utilisateur WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    $user = ["nom" => "","prenom" => "", "email" => "", "telephone" => "", "role" => ""];
}
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
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            border-radius: 28px;
            max-width: 450px;
            width: 90%;
            padding: 2rem;
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .close-modal { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #888; }
        .form-group-modal { margin-bottom: 1.2rem; }
        .form-group-modal label { display: block; font-weight: 500; margin-bottom: 0.4rem; }
        .form-group-modal input { width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #e2e8e0; border-radius: 16px; font-family: 'Inter', sans-serif; }
        .btn-save { background: #1f5e34; color: white; border: none; padding: 0.75rem; border-radius: 40px; font-weight: 600; width: 100%; cursor: pointer; }
        .btn-save:hover { background: #154a28; }
        .message { background: #dff0e1; color: #1f5e34; padding: 0.75rem; border-radius: 20px; text-align: center; margin-bottom: 1.5rem; }
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
                <div class="message"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></div>
            <?php endif; ?>

            <div class="profile-info">
                <div class="info-row">
                    <span class="info-label">Nom :</span>
                    <span id="displayNom" class="info-value"><?= htmlspecialchars($user["nom"] ?: 'Non renseigné') ?></span>
                    <button class="btn-edit" type="button" ><i class="fas fa-pen"></i></button>
                </div>
                <div class="info-row">
                    <span class="info-label">Prénom :</span>
                    <span id="displayPrenom" class="info-value">
                        <?= htmlspecialchars($user["prenom"] ?: 'Non renseigné') ?>
                    </span>
                    <button class="btn-edit" type="button" >
                        <i class="fas fa-pen"></i>
                    </button>
                </div>
                <div class="info-row">
                    <span class="info-label">Email :</span>
                    <span class="info-value"><?= htmlspecialchars($user["email"]) ?></span>
                    <span style="width: 32px;"></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone :</span>
                    <span id="displayTel" class="info-value"><?= htmlspecialchars($user["telephone"] ?: 'Non renseigné') ?></span>
                    <button class="btn-edit" type="button"><i class="fas fa-pen"></i></button>
                </div>
                <div class="info-row">
                    <span class="info-label">Rôle :</span>
                    <span class="info-value"><?= htmlspecialchars($user["role"]) ?></span>
                    <span style="width: 32px;"></span>
                </div>
            </div>

            <div class="profile-actions" style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                <a href="index.php" class="btn btn--secondary" style="background:#e9ecef; color:#2c5a36; padding: 0.7rem 1.5rem; border-radius:40px; text-decoration:none; font-weight:500;">Retour à l'accueil</a>
                <a href="logout.php" class="btn btn--danger" style="background:#d9534f; color:white; padding: 0.7rem 1.5rem; border-radius:40px; text-decoration:none; font-weight:500;">Déconnexion</a>
            </div>
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