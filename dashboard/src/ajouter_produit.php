<?php
session_start();

$message = "";

// Sécurité admin
if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}
require_once('../../travel-agency-website-template-143/pdo.php');

$cnx = new connexion();
$pdo = $cnx->CNXbase();
$cats = $pdo->query("SELECT * FROM categorie");

// Traitement formulaire
if (isset($_POST['ajouter'])) {

    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $categorie_id = $_POST['categorie_id'];

    // Gestion image
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if (!empty($image)) {
        $image = time() . "_" . $image;
        move_uploaded_file($tmp, "../../uploads/" . $image);
    } else {
        $image = "default.png";
    }

    // Insertion sécurisée
    $sql = "INSERT INTO produit (nom, description, prix, stock, categorie_id, image)
            VALUES (:nom, :description, :prix, :stock, :categorie_id, :image)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':description' => $description,
        ':prix' => $prix,
        ':stock' => $stock,
        ':categorie_id' => $categorie_id,
        ':image' => $image
    ]);

    header("Location: liste_produits.php?success=1");
    exit();
}
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
    <div class="container-fluid page-body-wrapper">

        <div class="main-panel">
            <div class="content-wrapper">

                <div class="page-header">
                    <h3 class="page-title">Ajouter un Nouveau Produit</h3>
                </div>

                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <?= $message; ?>

                                <form action="" method="POST" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Nom du Produit</label>
                                        <input type="text" name="nom" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Prix (TND)</label>
                                                <input type="number" name="prix" step="0.01" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="number" name="stock" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Catégorie</label>
                                    

                                        <select name="categorie_id" class="form-control" required>
                                            <option value="">-- Choisir une catégorie --</option>

                                            <?php while($c = $cats->fetch()) { ?>
                                                <option value="<?= $c['categorie_id'] ?>">
                                                    <?= $c['nom'] ?>
                                                </option>
                                            <?php } ?>

                                        </select>
                            
                                    </div>

                                    <div class="form-group">
                                        <label>Image du produit</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                    <button type="submit" name="ajouter" class="btn btn-gradient-primary mr-2">
                                        Ajouter le Produit
                                    </button>

                                 
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer">
                <span class="text-muted">© 2025 Camp&Co - Mini Projet</span>
            </footer>

        </div>
    </div>
</div>

<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/misc.js"></script>

</body>
</html>