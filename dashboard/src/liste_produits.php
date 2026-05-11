<?php
session_start();

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}

require_once('../../travel-agency-website-template-143/pdo.php');

$cnx = new connexion();
$pdo = $cnx->CNXbase();

/* DELETE PRODUIT */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM produit WHERE id_produit=?");
    $stmt->execute([$id]);

    header("Location: liste_produits.php");
    exit();
}
if (isset($_POST['update'])) {

    $id = $_POST['id_produit'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];

    $stmt = $pdo->prepare("
        UPDATE produit 
        SET nom=?, description=?, prix=?, stock=? 
        WHERE id_produit=?
    ");

    $stmt->execute([$nom, $description, $prix, $stock, $id]);

    header("Location: liste_produits.php");
    exit();
}
/* UPDATE PRODUIT */
$editProd = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit=?");
    $stmt->execute([$id]);
    $editProd = $stmt->fetch();
}
$sql = "SELECT p.*, c.nom AS categorie_nom
        FROM produit p
        LEFT JOIN categorie c 
        ON p.categorie_id = c.categorie_id";
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
    <style>
/* Conteneur boutons */
.btn-group-custom{
    display:flex;
    gap:12px;
    margin-top:15px;
}

/* 🔴 ANNULER */
.btn-annuler{
    background-color:#e36613;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    font-weight:700;
    border:none;
    display:inline-block;
    transition:0.3s;
}

.btn-annuler:hover{
    background-color:#c95509;
    color:white;
}

/* 🟢 ENREGISTRER */
.btn-enregistrer{
    background-color:#2d8b52;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    border:none;
    font-weight:700;
    cursor:pointer;
    transition:0.3s;
}

.btn-enregistrer:hover{
    background-color:#246f42;
}

/* OMBRE */
.btn-annuler,
.btn-enregistrer{
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
}
</style>
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

              <a class="nav-link" href="../../travel-agency-website-template-143/logout.php">
                <span class="menu-title">Déconnexion</span>
                <i class="mdi mdi-logout menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>

<div class="main-panel">
<div class="content-wrapper">

<h3>Gestion des Produits</h3>



<table class="table table-striped">

<thead>
<tr>
    <th>Image</th>
    <th>Nom</th>
    <th>Description</th>
    <th>Prix</th>
    <th>Stock</th>
    <th>Catégorie</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php while ($row = $res->fetch()) { ?>

<tr>

<td>
<img class="prod-img"
     src="../../travel-agency-website-template-143/assets/images/<?= htmlspecialchars($row['image']) ?>">
  </td>

<td><?= htmlspecialchars($row['nom']) ?></td>
<td><?= htmlspecialchars($row['description']) ?></td>
<td><?= htmlspecialchars($row['prix']) ?> TND</td>
<td><?= htmlspecialchars($row['stock']) ?></td>
<td><?= htmlspecialchars($row['categorie_nom'] ?? 'Sans catégorie') ?></td>
<td class="btns">

    <a href="?edit=<?= $row['id_produit'] ?>"
       class="btn btn-warning btn-sm">
        Modifier
    </a>

    <a href="?delete=<?= $row['id_produit'] ?>"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Supprimer ce produit ?')">
        Supprimer
    </a>

</td>

</tr>

<?php } ?>

</tbody>
</table>

<!-- FORMULAIRE MODIFICATION -->
<?php if ($editProd !== false && $editProd !== null) { ?>

<hr>

<h4>Modifier Produit</h4>

<form method="POST">

<input type="hidden" name="id_produit" value="<?= $editProd['id_produit'] ?>">

<input class="form-control mb-2" type="text" name="nom"
       value="<?= htmlspecialchars($editProd['nom']) ?>" required>

<textarea class="form-control mb-2"
          name="description" required><?= htmlspecialchars($editProd['description']) ?></textarea>

<input class="form-control mb-2" type="number" step="0.01" name="prix"
       value="<?= htmlspecialchars($editProd['prix']) ?>" required>

<input class="form-control mb-2" type="number" name="stock"
       value="<?= htmlspecialchars($editProd['stock']) ?>" required>

<div class="btn-group-custom">

    <a href="liste_produits.php" class="btn-annuler">
        ANNULER
    </a>

    <button type="submit" name="update" class="btn-enregistrer">
        ENREGISTRER
    </button>

</div>

</form>

<?php } ?>

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