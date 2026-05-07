<?php
session_start();

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}

require_once('../../travel-agency-website-template-143/pdo.php');
$cnx = new connexion();
$pdo = $cnx->CNXbase();

/* Suppression utilisateur (sauf admin) */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $check = $pdo->prepare("SELECT role FROM utilisateur WHERE id_utilisateur = ?");
    $check->execute([$id]);
    $user = $check->fetch();

    if ($user && $user['role'] !== 'admin') {
        $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$id]);
    }

    header("Location: gestion_utilisateur.php");
    exit();
}

/* Liste utilisateurs */
$users = $pdo->query("SELECT * FROM utilisateur ORDER BY id_utilisateur DESC");
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
              <a class="nav-link" href="gestion_utilisateur.php">
                <span class="menu-title">Gestion des Utilisateurs</span>
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

    <!-- MAIN PANEL -->
    <div class="main-panel">
      <div class="content-wrapper">

        <div class="page-header">
          <h3 class="page-title">
            <i class="mdi mdi-account-multiple text-primary"></i>
            Gestion des utilisateurs
          </h3>
        </div>

        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Liste des utilisateurs</h4>

            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php while ($u = $users->fetch(PDO::FETCH_ASSOC)) { ?>
                  <tr>
                    <td><?= $u['id_utilisateur']; ?></td>
                    <td><?= htmlspecialchars($u['nom']); ?></td>
                    <td><?= htmlspecialchars($u['email']); ?></td>
                    <td><?= htmlspecialchars($u['telephone']); ?></td>
                    <td>
                      <?php if ($u['role'] === 'admin') { ?>
                        <span class="badge bg-gradient-danger">Admin</span>
                      <?php } else { ?>
                        <span class="badge bg-gradient-success">Client</span>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if ($u['role'] !== 'admin') { ?>
                        <a href="supprimer_utilisateur.php?id=<?= $u['id_utilisateur'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Supprimer cet utilisateur ?');">
                          Supprimer
                        </a>
                      <?php } else { ?>
                        —
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>

           

          </div>
        </div>

      </div>

      <footer class="footer">
        <span class="text-muted">© 2026 Camp&Co – Administration</span>
      </footer>

    </div>
  </div>
</div>

<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/misc.js"></script>
</body>
</html>