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

/* UPDATE PRODUIT */
if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];


    $stmt = $pdo->prepare("
        UPDATE produit 
        SET nom=?, description=?, prix=?, stock=?, image=? 
        WHERE id_produit=?
    ");

    $stmt->execute([$nom, $description, $prix, $stock, $image, $id]);

    header("Location: liste_produits.php");
    exit();
}

/* PRODUIT A MODIFIER */
$editProd = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit=?");
    $stmt->execute([$id]);
    $editProd = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* LISTE PRODUITS */
$sql = "SELECT produit.id_produit, produit.nom, produit.description, produit.prix,
               produit.stock, produit.image,
               categorie.nom AS cat_nom
        FROM produit
        LEFT JOIN categorie ON produit.categorie_id = categorie.id";

$res = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Gestion Produits</title>

<link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
<link rel="stylesheet" href="assets/css/style.css">

<style>
.prod-img{
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
     src="/ProjetWeb/travel-agency-website-template-143/assets/images/<?= htmlspecialchars($row['image']) ?>">
</td>

    <td><?= htmlspecialchars($row['nom']) ?></td>
    <td><?= htmlspecialchars($row['description']) ?></td>
    <td><?= htmlspecialchars($row['prix']) ?> TND</td>
    <td><?= htmlspecialchars($row['stock']) ?></td>
    <td><?= htmlspecialchars($row['cat_nom']) ?></td>

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
<?php if ($editProd) { ?>

<hr>

<h4>Modifier Produit</h4>

<form method="POST">

    <input type="hidden" name="id" value="<?= $editProd['id_produit'] ?>">

    <input class="form-control mb-2" type="text" name="nom"
           value="<?= htmlspecialchars($editProd['nom']) ?>">

    <textarea class="form-control mb-2"
              name="description"><?= htmlspecialchars($editProd['description']) ?></textarea>

    <input class="form-control mb-2" type="number" name="prix"
           value="<?= htmlspecialchars($editProd['prix']) ?>">

    <input class="form-control mb-2" type="number" name="stock"
           value="<?= htmlspecialchars($editProd['stock']) ?>">

    <button type="submit" name="update" class="btn btn-success">
        Enregistrer
    </button>

    <a href="liste_produits.php" class="btn btn-secondary">
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