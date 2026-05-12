<?php
session_start();

// initialiser panier
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

/* SUPPRESSION PRODUIT */
if (isset($_GET['remove'])) {

    $id = $_GET['remove'];

    foreach ($_SESSION['panier'] as $index => $item) {

        if ($item['id_produit'] == $id) {

            unset($_SESSION['panier'][$index]);
            break;
        }
    }

    header("Location: panier.php");
    exit();
}

/* CALCUL TOTAL */
$total = 0;
foreach ($_SESSION['panier'] as $p) {
    $total += $p['prix'] * $p['quantite'];
}
?>  

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon panier</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            margin-top: 40px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #2c5a36;
            color: white;
        }
        .btn {
            padding: 5px 10px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .total {
            text-align: right;
            font-size: 20px;
            margin-top: 20px;
        }
        .empty {
            text-align: center;
            margin-top: 50px;
        }
        .btn-commander {
            padding: 10px 20px;
            background: #2c5a36;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn-commander:hover {
            background: #1f4227;
        }
        .commande {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Mon panier</h2>

<?php if (empty($_SESSION['panier'])): ?>
                <p class="empty">Votre panier est vide</p>
    <?php else: ?>

        <table>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

<?php foreach ($_SESSION['panier'] as $p): ?>                <tr>
                    <td><?= ($p['nom']) ?></td>
                    <td><?= $p['prix'] ?> DT</td>
                    <td><?= $p['quantite'] ?></td>
                    <td><?= $p['prix'] * $p['quantite'] ?> DT</td>
                    <td>
<a class="btn" href="?remove=<?= $p['id_produit'] ?>">
    Supprimer
</a>                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="total">
            <strong>Total : <?= $total ?> DT</strong>
        </div>

        
        <div class="commande">
            <a href="commande.php" class="btn-commander">
                Commander
            </a>
        </div>


    <?php endif; ?>

    <br>
    <a href="categorie.php">Continuer mes achats</a>
</div>

</body>
</html>