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
$message = "";
$edit = isset($_GET['edit']);
if (isset($_POST['update'])) {

    $nom = $_POST['nom'];
    $telephone = $_POST['telephone'];

    $stmt = $conn->prepare("
        UPDATE utilisateur 
        SET nom = ?, telephone = ? 
        WHERE email = ?
    ");

    $stmt->execute([$nom, $telephone, $email]);

    $_SESSION["nom"] = $nom; // update session

    $message = "Profil mis à jour avec succès ✔";
}

/* =========================
   GET USER
========================= */
$stmt = $conn->prepare("SELECT nom, email, telephone, role FROM utilisateur WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard Admin - Camp&Co</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">

    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">

      <!-- Navbar -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <a class="navbar-brand brand-logo" href="dashboard.php"><strong>Camp&Co</strong></a>
          <a class="navbar-brand brand-logo-mini" href="dashboard.php"><strong>C&C</strong></a>
        </div>

        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>

          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <div class="nav-profile-img">
                <img src="assets/images/faces/face1.jpg" alt="image">
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?= htmlspecialchars($_SESSION["nom"] ?? 'Administrateur') ?></p>
              </div>
            </a>

            <div class="dropdown-menu navbar-dropdown">
              
              <a class="dropdown-item" href="profil.php">
                <i class="mdi mdi-account me-2"></i> Mon Profil
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

      <!-- Sidebar -->
      <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="assets/images/faces/face1.jpg" alt="profile" />
                  <span class="login-status online"></span>
                </div>
                <div class="welcome-box">
                  <h3>Bonjour, <?= htmlspecialchars($_SESSION["nom"] ?? 'Admin') ?></h3>
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
                <i class="mdi mdi-plus-circle menu-icon"></i>
              </a>
            </li>
               <li class="nav-item">
              <a class="nav-link" href="gestion_utilisateur.php">
                <span class="menu-title">Gestion des Utilisateurs</span>
                <i class="mdi mdi-package-variant menu-icon"></i>
              </a>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="notification.php">
                <span class="menu-title">Notifications</span>
                <i class="mdi mdi-package-variant menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">

              <a class="nav-link" href="../../travel-agency-website-template-143/logout.php">
                <span class="menu-title">Déconnexion</span>
                <i class="mdi mdi-logout menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>


<!-- MAIN -->
<!-- MAIN PANEL -->
<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-account"></i>
        </span>
        Mon Profil
      </h3>
    </div>

    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">

        <div class="card">
          <div class="card-body">

            <h4 class="card-title">Informations utilisateur</h4>
            <p class="text-muted">Vos données personnelles</p>

            <hr>

<div class="mb-3">
  <label class="form-label">Nom</label>
  <input class="form-control" value="<?= htmlspecialchars($user['nom']) ?>" readonly>
</div>

<div class="mb-3">
  <label class="form-label">Email</label>
  <input class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
</div>

<div class="mb-3">
  <label class="form-label">Téléphone</label>
  <input class="form-control" value="<?= htmlspecialchars($user['telephone']) ?>" readonly>
</div>

<div class="mb-3">
  <label class="form-label">Rôle</label>
  <input class="form-control" value="<?= htmlspecialchars($user['role']) ?>" readonly>
</div>

<a href="profil.php?edit=1" class="btn btn-primary">
  Modifier mes informations
</a>
<?php if ($edit): ?>

<div class="card mt-4">
<div class="card-body">

<h4 class="card-title">Modifier mes informations</h4>

<?php if ($message): ?>
  <div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<form method="POST">

  <div class="form-group">
    <label>Nom</label>
    <input type="text" name="nom" class="form-control"
           value="<?= htmlspecialchars($user['nom']) ?>">
  </div>

  <div class="form-group mt-2">
    <label>Téléphone</label>
    <input type="text" name="telephone" class="form-control"
           value="<?= htmlspecialchars($user['telephone']) ?>">
  </div>

  <button type="submit" name="update"
          class="btn btn-gradient-primary mt-3">
    Sauvegarder
  </button>

  <a href="profil.php" class="btn btn-light mt-3">
    Annuler
  </a>

</form>

</div>
</div>

<?php endif; ?>
            <div class="d-flex gap-2 mt-4">

              <a href="index.php" class="btn btn-light">
                Retour Dashboard
              </a>

              <a href="../../travel-agency-website-template-143/logout.php" class="btn btn-danger">
                Déconnexion
              </a>

            </div>

          </div>
        </div>

      </div>


    </div>

  </div>
</div>

</div>
</div>
<!-- Scripts -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>