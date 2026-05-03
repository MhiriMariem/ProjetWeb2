<?php
session_start();

$panier = $_SESSION['panier'] ?? [];

// Supprimer un produit
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];

    foreach ($panier as $index => $produit) {
        if ($produit['id'] == $id) {
            unset($panier[$index]);
            break;
        }
    }

    $_SESSION['panier'] = array_values($panier);
    header("Location: panier.php");
    exit();
}

// Calcul total
$total = 0;
foreach ($panier as $p) {
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
    </style>
</head>
<body>

<div class="container">
    <h2>🛒 Mon panier</h2>

    <?php if (empty($panier)): ?>
        <p class="empty">Votre panier est vide 😢</p>
    <?php else: ?>

        <table>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Action</th>
            </tr>

            <?php foreach ($panier as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nom']) ?></td>
                    <td><?= $p['prix'] ?> DT</td>
                    <td><?= $p['quantite'] ?></td>
                    <td><?= $p['prix'] * $p['quantite'] ?> DT</td>
                    <td>
                        <a class="btn" href="?remove=<?= $p['id'] ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="total">
            <strong>Total : <?= $total ?> DT</strong>
        </div>

    <?php endif; ?>

    <br>
    <a href="categorie.php">⬅ Continuer mes achats</a>
</div>

</body>
</html>