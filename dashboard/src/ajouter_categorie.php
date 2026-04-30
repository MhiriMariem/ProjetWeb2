<?php
session_start();

$message = "";

// 🔒 Sécurité admin
if (!isset($_SESSION["connecte"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../travel-agency-website-template-143/login.php");
    exit();
}

// 🔥 Connexion PDO (IMPORTANT)
require_once('../../travel-agency-website-template-143/pdo.php');

$cnx = new connexion();
$pdo = $cnx->CNXbase();


// =====================
// TRAITEMENT FORMULAIRE
// =====================
if (isset($_POST['ajouter'])) {

    $nom = htmlspecialchars($_POST['nom']);

    // image
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if (!empty($image)) {
        $image = time() . "_" . $image;
        move_uploaded_file($tmp, "../../travel-agency-website-template-143/assets/images/" . $image);  
          } else {
        $image = "default.png";
    }

    // INSERT
    $sql = "INSERT INTO categorie (nom, image)
            VALUES (:nom, :image)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':image' => $image
    ]);

    $message = "<div class='alert alert-success'>Catégorie ajoutée avec succès ✅</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter Catégorie - Camp&Co</title>

    <!-- CSS admin template -->
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

                <!-- HEADER -->
                <div class="page-header">
                    <h3 class="page-title">Ajouter une Catégorie</h3>
                </div>

                <!-- FORM CARD -->
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">

                                <!-- MESSAGE -->
                                <?= $message; ?>

                                <!-- FORM -->
                                <form method="POST" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Nom de la catégorie</label>
                                        <input type="text" name="nom" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Image de la catégorie</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>

                                    <button type="submit" name="ajouter" class="btn btn-gradient-primary mr-2">
                                        Ajouter la catégorie
                                    </button>

                                    <a href="index.php" class="btn btn-light">
                                        Retour
                                    </a>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <footer class="footer">
                <span class="text-muted">© 2025 Camp&Co - Mini Projet</span>
            </footer>

        </div>
    </div>
</div>

<!-- JS -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/misc.js"></script>

</body>
</html>