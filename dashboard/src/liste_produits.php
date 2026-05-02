<?php
session_start();

if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}

/* CONNEXION */
require_once('../../travel-agency-website-template-143/pdo.php');

$cnx = new connexion();
$pdo = $cnx->CNXbase();

/* DELETE PRODUIT */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM produit WHERE id=?");
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

    $stmt = $pdo->prepare("UPDATE produit 
        SET nom=?, description=?, prix=?, stock=? 
        WHERE id=?");

    $stmt->execute([$nom, $description, $prix, $stock, $id]);

    header("Location: liste_produits.php");
    exit();
}

/* PRODUIT A MODIFIER */
$editProd = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id=?");
    $stmt->execute([$id]);
    $editProd = $stmt->fetch();
}

/* LISTE PRODUITS */
$sql = "SELECT produit.*, categorie.nom AS cat_nom
        FROM produit
        LEFT JOIN categorie ON produit.categorie_id = categorie.id";
$res = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Gestion Produits</title>

<link rel="stylesheet" href="css/bootstrap.min.css">

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

<div class="col-md-10 col-xs-12">

<div class="panel panel-info">

<h1 class="panel-heading">Gestion des Produits</h1>

<div class="panel-body">

<br><br>

<table border="1" class="table table-striped">

<tr>
    <th>Nom</th>
    <th>Description</th>
    <th>Prix</th>
    <th>Quantité</th>
    <th>Catégorie</th>
    <th>Image</th>
    <th>Actions</th>
</tr>

<?php while ($row = $res->fetch()) { ?>

<tr>

    <td><?= $row['nom'] ?></td>

    <td><?= $row['description'] ?></td>

    <td><?= $row['prix'] ?> TND</td>

    <td><?= $row['stock'] ?></td>

    <td><?= $row['cat_nom'] ?></td>

    <td>
        <img src="../../uploads/<?= $row['image'] ?>" width="50" height="50">
    </td>

    <td>

    <?php
    $id = $row['id'];
    ?>

    <a href="?delete=<?= $id ?>" 
       onclick="return confirm('Supprimer ce produit ?')" 
       class="btn btn-danger btn-sm">
        Supprimer
    </a>

    <a href="?edit=<?= $id ?>" 
       class="btn btn-warning btn-sm">
        Modifier
    </a>

    </td>
    

</tr>

<?php } ?>
</table>

<!-- FORM MODIF -->
<?php if ($editProd) { ?>

<hr>

<h4>Modifier Produit</h4>

<form method="POST">

    <input type="hidden" name="id" value="<?= $editProd['id'] ?>">

    <input type="text" name="nom" value="<?= $editProd['nom'] ?>"><br><br>

    <textarea name="description"><?= $editProd['description'] ?></textarea><br><br>

    <input type="number" name="prix" value="<?= $editProd['prix'] ?>"><br><br>

    <input type="number" name="stock" value="<?= $editProd['stock'] ?>"><br><br>

    <button type="submit" name="update" class="btn btn-success">
        Enregistrer
    </button>

</form>

<?php } ?>

</div>
</div>

</div>

</body>
</html>