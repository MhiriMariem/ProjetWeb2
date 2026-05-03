<?php
session_start();
require_once('pdo.php');

$cnx = new connexion();
$pdo = $cnx->CNXbase();

$id = $_GET['categorie_id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM categorie WHERE id=?");
$stmt->execute([$id]);
$categorie = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM produit WHERE categorie_id=?");
$stmt->execute([$id]);
$produits = $stmt->fetchAll();

if (isset($_GET['add'])) {
    $idProduit = $_GET['add'];

    // chercher le produit en base
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id_produit=?");
    $stmt->execute([$idProduit]);
    $produit = $stmt->fetch();

    if ($produit) {
        // initialiser panier
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        // vérifier si produit existe déjà
        $found = false;

        foreach ($_SESSION['panier'] as &$item) {
            if ($item['id'] == $idProduit) {
                $item['quantite']++;
                $found = true;
                break;
            }
        }

        // sinon ajouter
        if (!$found) {
            $_SESSION['panier'][] = [
                'id' => $produit['id'],
                'nom' => $produit['nom'],
                'prix' => $produit['prix'],
                'quantite' => 1
            ];
        }
    }

    // éviter rechargement double
    header("Location: produits.php?categorie_id=" . $id);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>PHPJabbers.com | Free Travel Agency Website Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">
  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <div class="sub-header">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-xs-12">
            <ul class="left-info">
              <li><a href="#"><i class="fa fa-envelope"></i>contact@company.com</a></li>
              <li><a href="#"><i class="fa fa-phone"></i>123-456-7890</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul class="right-icons">
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="index.php"><h2>Camp&Co</h2></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Acceuil
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="categorie.php">Produits</a>
              </li>
             
              <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">À propos</a>
              
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about.php">À propos</a>
                    <a class="dropdown-item" href="testimonials.php">Avis clients</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contactez-nous</a>
              </li>
              <li class="nav-item">
              <a href="panier.php" class="nav-link nav-profile-icon">
                <i class="fa fa-shopping-cart"></i>
                <span class="badge">
                  <?= count($_SESSION['panier'] ?? []) ?>
                </span>
              </a>
            </li>
              <li class="nav-item">
              <a href="profil.php" class="nav-link nav-profile-icon">
                <i class="fa fa-user"></i>
              </a>
            </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Page Content -->
    <div class="page-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1><?= $categorie['nom']; ?></h1>
            <span>
                Découvrez les produits de la catégorie <?= $categorie['nom']; ?> et équipez-vous pour vos aventures en plein air.
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="services">
    <div class="container">
        <div class="row">

        <?php foreach ($produits as $p) { ?>

        <div class="col-md-4">
            <div class="service-item">

            <img src="assets/images/<?= $p['image']; ?>" alt="">

            <div class="down-content">
                <h4><?= $p['nom']; ?></h4>
                <p><?= $p['prix']; ?> DT</p>

                <a href="produits.php?categorie_id=<?= $id ?>&add=<?= $p['id_produit'] ?>" class="btn btn-primary">
                Ajouter au panier
                </a>
            </div>

            </div>
        </div>

        <?php } ?>

        </div>
    </div>
    </div>



        <br>
        <br>

        <nav>
          <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">«</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">»</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </nav>

        <br>
        <br>
        <br>
        <br>
      </div>
    </div>

    <!-- Footer Starts Here -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-3 footer-item">
            <h4>Camp&Co</h4>
            <p>Camp&Co est une boutique en ligne spécialisée dans le matériel de camping : tentes, sacs, lampes et équipements outdoor.</p>
            <ul class="social-icons">
              <li><a rel="nofollow" href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
          <div class="col-md-3 footer-item">
            <h4>Liens utiles</h4>
            <ul class="menu-list">
              <li><a href="index.php">Accueil</a></li>
              <li><a href="categorie.php">Produits</a></li>
              <li><a href="contact.php">Contactez-nous</a></li>
              <li><a href="profil.php">Mon profil</a></li>
            </ul>
          </div>
          <div class="col-md-3 footer-item">
            <h4>Pages</h4>
            <ul class="menu-list">
              <li><a href="about.php">À propos</a></li>
              <li><a href="testimonials.php">Avis clients</a></li>
            </ul>
          </div>
          <div class="col-md-3 footer-item last-item">
            <h4>Contactez-nous</h4>
            <div class="contact-form">
              <form id="contact footer-contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Nom complet" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*" placeholder="Adresse e-mail" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" rows="6" class="form-control" id="message" placeholder="Votre message" required=""></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="filled-button">Envoyer</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </footer>
    
    <div class="sub-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <p>
                Copyright © 2020 Company Name
                - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/accordions.js"></script>

    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>

  </body>
</html>