<?php
session_start();
require_once("pdo.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

  <title>Camp&Co | Avis clients</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/owl.css">

</head>

<body>

<!-- Header -->
<header class="">
  <nav class="navbar navbar-expand-lg">
    <div class="container">

      <a class="navbar-brand" href="index.php"><h2>Camp&Co</h2></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="index.php">Accueil</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="categorie.php">Produits</a>
          </li>

          <li class="nav-item dropdown active">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#">À propos</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="about.php">À propos</a>
              <a class="dropdown-item active" href="testimonials.php">Avis clients</a>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contactez-nous</a>
          </li>
 <li class="nav-item">
              <a href="panier.php" class="nav-link nav-profile-icon">
<i class="fa fa-shopping-cart" style="color:white;"></i>
                <span class="badge">
                  <?php echo count($_SESSION['panier'] ?? []); ?>
                </span>
              </a>
            </li>

              <li class="nav-item">
              <a href="profil.php" class="nav-link nav-profile-icon">
<i class="fa fa-user" style="color:white;"></i>              </a>
            </li>
        </ul>
      </div>

    </div>
  </nav>
</header>

<!-- Page Heading -->
<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <h1>Avis de nos clients</h1>
        <span>Expériences réelles de nos clients en Tunisie</span>

      </div>
    </div>
  </div>
</div>

<!-- Testimonials -->
<div class="services">
  <div class="container">
    <div class="row">


     

        <div class="col-md-4">
          <div class="service-item">
            <div class="down-content text-center">
              <h4>Amine Ben Ali</h4>
              <span>Tunis</span>
              <p>"Tente très solide, parfaite pour le camping à Aïn Draham."</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="service-item">
            <div class="down-content text-center">
              <h4>Yasmine Trabelsi</h4>
              <span>Sousse</span>
              <p>"Très bonne qualité et livraison rapide."</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="service-item">
            <div class="down-content text-center">
              <h4>Mohamed Ali Jaziri</h4>
              <span>Hammamet</span>
              <p>"Excellent matériel pour camping en famille."</p>
            </div>
          </div>
        </div>


    </div>
  </div>
</div>

<!-- Footer -->
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