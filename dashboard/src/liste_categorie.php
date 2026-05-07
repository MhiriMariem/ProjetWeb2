<?php
session_start();

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}

require_once('../../travel-agency-website-template-143/pdo.php');

$cnx = new connexion();
$pdo = $cnx->CNXbase();

/* DELETE */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Vérifier si des produits existent
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM produit WHERE categorie_id=?");
    $stmt->execute([$id]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
    $_SESSION['error'] = "Impossible de supprimer cette catégorie";
} else {
    $stmt = $pdo->prepare("DELETE FROM categorie WHERE id=?");
    $stmt->execute([$id]);
    $_SESSION['success'] = "Catégorie supprimée avec succès";
}

header("Location: liste_categorie.php");
exit();
}

/* UPDATE */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];

    $stmt = $pdo->prepare("UPDATE categorie SET nom=? WHERE id=?");
    $stmt->execute([$nom, $id]);

    header("Location: liste_categorie.php");
    exit();
}

/* GET CATEGORY TO EDIT */
$editCat = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id=?");
    $stmt->execute([$id]);
    $editCat = $stmt->fetch();
}

$sql = "SELECT * FROM categorie";
$res = $pdo->query($sql);
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

<h3>Gestion des Catégories</h3>

<?php if (isset($_SESSION['error'])) { ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php } ?>

<?php if (isset($_SESSION['success'])) { ?>
    <div class="alert alert-success">
        <?= $_SESSION['success']; ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php } ?>

<table class="table table-striped">

<thead>
<tr>
    <th>Image</th>
    <th>Nom</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php while ($row = $res->fetch()) { ?>

<tr>

<td>
    <img class="cat-img"
         src="../../travel-agency-website-template-143/assets/images/<?= $row['image']; ?>">
</td>

<td><?= $row['nom']; ?></td>

<td class="btns">

<!-- MODIFIER -->
<a href="?edit=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
    Modifier
</a>

<!-- SUPPRIMER -->
<a href="?delete=<?= $row['id']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Supprimer cette catégorie ?')">
   Supprimer
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<!-- FORMULAIRE MODIFICATION -->
<?php if ($editCat) { ?>

<hr>

<h4>Modifier Catégorie</h4>

<form method="POST">

    <input type="hidden" name="id" value="<?= $editCat['id']; ?>">

    <input type="text" name="nom" value="<?= $editCat['nom']; ?>" required>

    <button type="submit" name="update" class="btn btn-success">
        Enregistrer
    </button>

    <a href="liste_categorie.php" class="btn btn-secondary">
        Annuler
    </a>

</form>

<?php } ?>

</div>
</div>
</div>
</div>

</body>
</html>