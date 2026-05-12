<?php
session_start();
require_once "pdo.php";

$panier = $_SESSION['panier'] ?? [];

if (empty($panier)) {
    echo "Panier vide";
    exit;
}

/* calcul total */
$total = 0;
foreach ($panier as $p) {
    $total += $p['prix'] * $p['quantite'];
}

/* clic valider */
if (isset($_POST['valider'])) {

    $cnx = new connexion();
    $conn = $cnx->CNXbase();

    /* 1. commande */
    $sql = "INSERT INTO commande (id_utilisateur, date_commande, total)
            VALUES ({$_SESSION['id_utilisateur']}, NOW(), $total)";

    $conn->query($sql);

    $id_commande = $conn->lastInsertId();

    /* 2. détails commande */
    foreach ($panier as $p) {

        $id_produit = $p['id_produit'];
        $quantite = $p['quantite'];
        $prix = $p['prix'];

        $sql = "INSERT INTO details_commande
                (id_commande, id_produit, quantite, prix_unitaire)
                VALUES ($id_commande, $id_produit, $quantite, $prix)";

        $conn->query($sql);
    }

    /* 3. vider panier */
    $_SESSION['panier'] = [];

    $_SESSION['message'] = "Commande confirmée avec succès !";
    $_SESSION['total'] = $total;

    header("Location: commande.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commande</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; text-align:center; }
        .box { background:white; padding:20px; width:50%; margin:auto; margin-top:50px; border-radius:10px; }
        button {
            padding:10px 20px;
            background:green;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }
        body{
    background:#f5f7f2;
    font-family:'Inter',sans-serif;
}

.commande-card{
    max-width:700px;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
}

h2,h3{
    color:#2c5a36;
}

.form-control{
    width:100%;
    padding:12px;
    border:1px solid #dcdcdc;
    border-radius:10px;
    margin-top:8px;
    margin-bottom:18px;
    font-size:15px;
}

.resume{
    background:#f7faf7;
    padding:15px;
    border-radius:12px;
    margin-top:20px;
}

.total{
    font-size:22px;
    font-weight:bold;
    color:#1f5e34;
    margin-top:15px;
}

.btn-valider{
    width:100%;
    padding:14px;
    background:#4b5320;
    color:white;
    border:none;
    border-radius:12px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
    margin-top:20px;
}

.btn-valider:hover{
    background:#3d4419;
}
.message{
    background:#dff0e1;
    color:#1f5e34;
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
}
    </style>
</head>
<body>

<div class="commande-card">
    <?php if ($message): ?>
    <div class="message">
        <i class="fas fa-check-circle"></i>
        <?= ($message) ?>
        <br>
        Total payé : <?= $total_confirm ?> DT
    </div>
    <?php endif; ?>
    <h2>Validation de la commande</h2>

    <form method="post">

        <h3>Informations client</h3>

        <input type="text" 
               name="nom" 
               class="form-control"
               placeholder="Nom"
               required>

        <input type="text" 
               name="prenom" 
               class="form-control"
               placeholder="Prénom"
               required>

        <input type="text" 
               name="telephone" 
               class="form-control"
               placeholder="Téléphone"
               required>

        <input type="text" 
               name="adresse" 
               class="form-control"
               placeholder="Adresse"
               required>

        <input type="text" 
               name="ville" 
               class="form-control"
               placeholder="Ville"
               required>

        <div class="resume">

            <h3>Résumé commande</h3>

            <?php foreach ($panier as $p): ?>
                <p>
                    <?= $p['nom'] ?> —
                    <?= $p['quantite'] ?> × <?= $p['prix'] ?> DT
                </p>
            <?php endforeach; ?>

            <div class="total">
                Total : <?= $total ?> DT
            </div>

        </div>

        <button type="submit" 
                name="valider"
                class="btn-valider">
            Valider la commande
        </button>
 
    </form>

</div>
</body>
</html>