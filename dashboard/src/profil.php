<?php
session_start();

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}

require_once('../../travel-agency-website-template-143/pdo.php');

$email = $_SESSION["email"];

$cnx = new connexion();
$conn = $cnx->CNXbase();

/* =========================
   UPDATE PROFIL
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'])
    && $_POST['action'] === 'update') {

    $nom = trim($_POST['nom']);
    $telephone = trim($_POST['telephone']);

    $stmtUpdate = $conn->prepare("
        UPDATE utilisateur
        SET nom = ?, telephone = ?
        WHERE email = ?
    ");

    $stmtUpdate->execute([$nom, $telephone, $email]);

    $_SESSION["nom"] = $nom;
    $_SESSION["message"] = "Profil mis à jour avec succès ✔";

    header("Location: profil.php");
    exit();
}

/* =========================
   GET USER
========================= */
$stmt = $conn->prepare("
    SELECT nom, email, telephone, role
    FROM utilisateur
    WHERE email = ?
");

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $user = [
        "nom" => "",
        "email" => "",
        "telephone" => "",
        "role" => ""
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profil Admin - Camp&Co</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">

    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        body{
            font-family: 'Inter', sans-serif;
        }

        /* PROFILE CARD */

        .profile-card{
            width:100%;
            max-width:700px;
            margin:auto;
            background:#fff;
            border-radius:20px;
            padding:40px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        }

        .profile-header{
            text-align:center;
            margin-bottom:35px;
        }

        .profile-header i{
            font-size:75px;
            color:#1f5e34;
            margin-bottom:15px;
        }

        .profile-header h1{
            font-size:30px;
            font-weight:700;
            color:#1f2937;
            margin-bottom:10px;
        }

        .profile-header p{
            color:#6b7280;
        }

        /* SUCCESS MESSAGE */

        .message{
            background:#dff0e1;
            color:#1f5e34;
            padding:15px;
            border-radius:12px;
            text-align:center;
            margin-bottom:25px;
            font-weight:600;
        }

        /* INFO ROW */

        .info-row{
            display:flex;
            align-items:center;
            gap:20px;
            margin-bottom:22px;
        }

        .info-label{
            width:140px;
            font-weight:600;
            color:#1f5e34;
        }

        .form-control{
            flex:1;
            border-radius:12px;
            border:1px solid #d1d5db;
            padding:12px 15px;
        }

        .form-control:focus{
            border-color:#1f5e34;
            box-shadow:0 0 0 0.2rem rgba(31,94,52,0.15);
        }

        .form-control[readonly]{
            background:#f3f4f6;
        }

        /* BUTTONS */

        .profile-actions{
            display:flex;
            justify-content:center;
            gap:15px;
            margin-top:35px;
            flex-wrap:wrap;
        }

        .btn-custom{
            padding:12px 24px;
            border:none;
            border-radius:10px;
            font-weight:600;
            text-decoration:none;
            transition:0.3s;
            cursor:pointer;
        }

        .btn-retour{
            background:#ffd6dd;
            color:#d11a2a;
        }

        .btn-retour:hover{
            background:#ffc2cc;
        }

        .btn-save{
            background:#d9d9d9;
            color:#333;
        }

        .btn-save:hover{
            background:#c7c7c7;
        }

        .btn-logout{
            background:#1f5e34;
            color:white;
        }

        .btn-logout:hover{
            background:#174827;
            color:white;
        }

        @media(max-width:768px){

            .profile-card{
                padding:25px;
            }

            .info-row{
                flex-direction:column;
                align-items:flex-start;
            }

            .info-label{
                width:100%;
            }

            .form-control{
                width:100%;
            }

            .profile-actions{
                flex-direction:column;
            }

            .btn-custom{
                width:100%;
                text-align:center;
            }
        }

    </style>
</head>

<body>

<div class="container-scroller">

    <!-- NAVBAR -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">

            <a class="navbar-brand brand-logo" href="index.php">
                <strong>Camp&Co</strong>
            </a>

            <a class="navbar-brand brand-logo-mini" href="index.php">
                <strong>C&C</strong>
            </a>

        </div>

        <div class="navbar-menu-wrapper d-flex align-items-stretch">

            <button class="navbar-toggler navbar-toggler align-self-center"
                    type="button"
                    data-toggle="minimize">

                <span class="mdi mdi-menu"></span>

            </button>

            <ul class="navbar-nav navbar-nav-right">

                <li class="nav-item nav-profile dropdown">

                    <a class="nav-link dropdown-toggle"
                       href="#"
                       data-bs-toggle="dropdown">

                        <div class="nav-profile-img">
                            <img src="assets/images/faces/face1.jpg" alt="image">
                            <span class="availability-status online"></span>
                        </div>

                        <div class="nav-profile-text">
                            <p class="mb-1 text-black">
                                <?= ($_SESSION["nom"] ?? 'Administrateur') ?>
                            </p>
                        </div>

                    </a>

                    <div class="dropdown-menu navbar-dropdown">
              
              <a class="dropdown-item" href="profil.php">
                <i class="mdi mdi-account me-2"></i> Mon Profil
              </a>
  <a class="dropdown-item" href="notification.php">
    <i class="mdi mdi-bell me-2"></i> Notifications
</a>
              <div class="dropdown-divider"></div>

              <a class="dropdown-item" href="../../travel-agency-website-template-143/logout.php">
                <i class="mdi mdi-logout me-2"></i> Déconnexion
              </a>

            </div>
          </li>
        </ul>
        </div>
    </nav>

    <!-- PAGE BODY -->
    <div class="container-fluid page-body-wrapper">

        <!-- SIDEBAR -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">

            <ul class="nav">

                <li class="nav-item nav-profile">

                    <a href="#" class="nav-link">

                        <div class="nav-profile-image">
                            <img src="assets/images/faces/face1.jpg" alt="profile" />
                            <span class="login-status online"></span>
                        </div>

                        <div class="welcome-box">
                            <h3>
                                Bonjour,
                                <?= ($_SESSION["nom"] ?? 'Admin') ?>
                            </h3>
                        </div>

                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <span class="menu-title">Dashboard</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="liste_produits.php">
                        <span class="menu-title">Gestion des Produits</span>
                        <i class="mdi mdi-package-variant menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ajouter_produit.php">
                        <span class="menu-title">Ajouter un Produit</span>
                        <i class="mdi mdi-plus-circle menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ajouter_categorie.php">
                        <span class="menu-title">Ajouter une Catégorie</span>
                        <i class="mdi mdi-plus-circle menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="liste_categorie.php">
                        <span class="menu-title">Gestion des Catégories</span>
                <i class="mdi mdi-package-variant menu-icon"></i>
                    </a>
                </li>
 <li class="nav-item">
                 <a class="nav-link" href="gestion_utilisateur.php">
                   <span class="menu-title">Gestion des Utilisateurs</span>
                   <i class="mdi mdi-account-group menu-icon"></i>
                 </a>
              </li>

            

                <li class="nav-item">
                    <a class="nav-link"
                       href="../../travel-agency-website-template-143/logout.php">

                        <span class="menu-title">Déconnexion</span>
                        <i class="mdi mdi-logout menu-icon"></i>

                    </a>
                </li>

            </ul>

        </nav>

        <!-- MAIN PANEL -->
        <div class="main-panel">

            <div class="content-wrapper">

                <div class="profile-card">

                    <!-- HEADER -->
                    <div class="profile-header">

                        <i class="fa fa-user-circle"></i>

                        <h1>Mon Profil</h1>

                        <p>Consultez et modifiez vos informations</p>
                    </div>
                    <!-- MESSAGE -->
                    <?php if (isset($_SESSION['message'])): ?>

                        <div class="message">

                            <i class="fa fa-check-circle"></i>

                            <?= ($_SESSION['message']); ?>

                        </div>

                        <?php unset($_SESSION['message']); ?>

                    <?php endif; ?>

                    <!-- FORM -->
                    <form method="POST">

                        <input type="hidden"
                               name="action"
                               value="update">

                        <!-- NOM -->
                        <div class="info-row">

                            <span class="info-label">
                                Nom :
                            </span>

                            <input type="text"
                                   name="nom"
                                   class="form-control"
                                   value="<?= ($user['nom']) ?>"
                                   required>

                        </div>

                        <!-- EMAIL -->
                        <div class="info-row">

                            <span class="info-label">
                                Email :
                            </span>

                            <input type="email"
                                   class="form-control"
                                   value="<?= ($user['email']) ?>"
                                   readonly>

                        </div>

                        <!-- TELEPHONE -->
                        <div class="info-row">

                            <span class="info-label">
                                Téléphone :
                            </span>

                            <input type="text"
                                   name="telephone"
                                   class="form-control"
                                   value="<?= ($user['telephone']) ?>">

                        </div>

                        <!-- ROLE -->
                        <div class="info-row">

                            <span class="info-label">
                                Rôle :
                            </span>

                            <input type="text"
                                   class="form-control"
                                   value="<?= ($user['role']) ?>"
                                   readonly>

                        </div>

                        <!-- BUTTONS -->
                        <div class="profile-actions">

                            <a href="index.php"
                               class="btn-custom btn-retour">

                                RETOUR

                            </a>

                            <button type="submit"
                                    class="btn-custom btn-save">

                                ENREGISTRER

                            </button>

                            <a href="../../travel-agency-website-template-143/logout.php"
                               class="btn-custom btn-logout">

                                DÉCONNEXION

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>

<!-- inject:js -->
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/misc.js"></script>
<script src="assets/js/dashboard.js"></script>

</body>
</html>