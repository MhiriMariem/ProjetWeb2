<?php
session_start();

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}

/* CONNEXION DB */
require_once('../../travel-agency-website-template-143/pdo.php');

$cnx = new connexion();
$pdo = $cnx->CNXbase();

/* =========================
   STATISTIQUES
========================= */

// PRODUITS
$stmt = $pdo->query("SELECT COUNT(*) AS total_produits FROM produit");
$totalProduits = $stmt->fetch(PDO::FETCH_ASSOC)['total_produits'];

// CLIENTS (table utilisateur)
$stmt2 = $pdo->query("SELECT COUNT(*) AS total_clients FROM utilisateur");
$totalClients = $stmt2->fetch(PDO::FETCH_ASSOC)['total_clients'];
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
                <a class="dropdown-item" href="../profil.php">
                  <i class="mdi mdi-account me-2"></i> Mon Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../logout.php">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Déconnexion
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

              <a class="nav-link" href="../../travel-agency-website-template-143/logout.php">
                <span class="menu-title">Déconnexion</span>
                <i class="mdi mdi-logout menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>

        <!-- Main Panel -->
        <div class="main-panel">
          <div class="content-wrapper">

            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> 
                Dashboard Camp&Co
              </h3>
            </div>

            <!-- Statistiques - Tu peux les modifier plus tard -->
           <div class="row">

  <!-- PRODUITS -->
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />

        <h4 class="font-weight-normal mb-3">
          Produits Total
        </h4>

        <h2 class="mb-5">
          <?= $totalProduits ?>
        </h2>

        <h6 class="card-text">Données en temps réel</h6>
      </div>
    </div>
  </div>

  <!-- COMMANDES (statique ou futur) -->
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />

        <h4 class="font-weight-normal mb-3">
          Commandes
        </h4>

        <h2 class="mb-5">18</h2>
        <h6 class="card-text">Statique</h6>
      </div>
    </div>
  </div>

  <!-- CLIENTS -->
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />

        <h4 class="font-weight-normal mb-3">
          Clients
        </h4>

        <h2 class="mb-5">
          <?= $totalClients ?>
        </h2>

        <h6 class="card-text">Inscription système</h6>
      </div>
    </div>
  </div>

</div>

            <!-- Graphiques et tableau (tu peux les laisser ou modifier plus tard) -->
            <div class="row">
              <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Statistiques des Ventes</h4>
                    <canvas id="visit-sale-chart" class="mt-4"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Sources de Trafic</h4>
                    <canvas id="traffic-chart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tableau exemple -->
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Dernières Activités</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Produit</th>
                            <th>Action</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Tu pourras remplir dynamiquement plus tard -->
                          <tr><td>Tente de camping 4 places</td><td>Ajouté</td><td>28/04/2026</td></tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <!-- Footer -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted">© 2025 Camp&Co - Mini Projet Programmation Web II</span>
            </div>
          </footer>
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