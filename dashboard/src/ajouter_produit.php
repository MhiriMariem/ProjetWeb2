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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un Produit - Camp&Co Admin</title>

    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<div class="container-scroller">

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
                                                <option value="<?= $c['id'] ?>">
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

                                    <a href="liste.php" class="btn btn-light">Retour à la liste</a>

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