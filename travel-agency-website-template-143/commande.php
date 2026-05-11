<?php
session_start();

$panier = $_SESSION['panier'] ?? [];

// si panier vide
if (empty($panier)) {
    echo "<h2>Votre panier est vide</h2>";
    echo "<a href='categorie.php'>Retour aux produits</a>";
    exit;
}

// calcul total
$total = 0;
foreach ($panier as $p) {
    $total += $p['prix'] * $p['quantite'];
}

// validation commande
if (isset($_POST['valider'])) {

    // ici normalement tu enregistres dans la base de données
    // (commande + details commande)

    // vider panier
    $_SESSION['panier'] = [];

    echo "<h2>Commande confirmée avec succès !</h2>";
    echo "<p>Total payé : " . $total . " DT</p>";
    echo "<a href='categorie.php'>Continuer shopping</a>";
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
    </style>
</head>
<body>

<div class="box">
    

    <form method="post">

    <h3>Informations client</h3>
    
    <input type="text" name="nom" placeholder="Nom" required><br><br>

    <input type="text" name="prenom" placeholder="Prénom" required><br><br>

    <input type="text" name="telephone" placeholder="Téléphone" required><br><br>

    <input type="text" name="adresse" placeholder="Adresse" required><br><br>

    <input type="text" name="ville" placeholder="Ville" required><br><br>

    <hr>

    <h3>Résumé commande</h3>

    <?php foreach ($panier as $p): ?>
        <p>
            <?= $p['nom'] ?> -
            <?= $p['quantite'] ?> x <?= $p['prix'] ?> DT
        </p>
    <?php endforeach; ?>

    <h3>Total : <?= $total ?> DT</h3>

    <button type="submit" name="valider">
        Valider la commande
    </button>

</form>
</div>

</body>
</html>