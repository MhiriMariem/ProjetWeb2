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

    $stmt = $pdo->prepare("DELETE FROM categorie WHERE id=?");
    $stmt->execute([$id]);

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
<title>Gestion Catégories</title>

<link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="assets/css/style.css">

<style>
.cat-img{
    width:60px;
    height:60px;
    border-radius:10px;
    object-fit:cover;
}
.btns{
    display:flex;
    gap:10px;
}
</style>
</head>

<body>

<div class="container-scroller">
<div class="container-fluid page-body-wrapper">
<div class="main-panel">
<div class="content-wrapper">

<h3>Gestion des Catégories</h3>

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