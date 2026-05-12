<?php
session_start();
require_once("pdo.php");

$cnx = new connexion();
$pdo = $cnx->CNXbase();

$success = false;

//est ce que formulaire a ete envoye
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $sujet = $_POST['sujet'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact (nom, email, sujet, message, date_envoi)
            VALUES ('$nom', '$email', '$sujet', '$message', NOW())";

    $pdo->exec($sql);

    $success = true;
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
              <li class="nav-item">
                <a class="nav-link" href="categorie.php">Produits</a>
              </li>
              <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">À propos</a>
              
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about.php">À propos</a>
                    <a class="dropdown-item" href="testimonials.php">Avis clients</a>
                </div>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="contact.php">Contactez-nous</a>
              </li>
              <li class="nav-item">
              <a href="panier.php" class="nav-link nav-profile-icon">
                <i class="fa fa-shopping-cart"></i>
                <span class="badge">
                  <?php echo count($_SESSION['panier'] ?? []); ?>
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
           <h1>Contactez‑nous</h1>
          <span>N’hésitez pas à nous envoyer un message</span>          </div>
        </div>
      </div>
    </div>

    <div class="contact-information">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="contact-item">
              <i class="fa fa-phone"></i>
              <h4>Téléphone</h4>
              <p>Service client disponible 7j/7</p>
              <a href="#">25 123 456</a>
            </div>
          </div>
          <div class="col-md-4">
  <div class="contact-item">
    <i class="fa fa-envelope"></i>
    <h4>Adresse e‑mail</h4>
    <p>
      Vous pouvez nous contacter par e‑mail pour toute question ou demande
      d’information. Notre équipe vous répondra dans les plus brefs délais.
    </p>
    <a href="mailto:campco@gmail.com">campco@gmail.com</a>
  </div>
</div>
          <div class="col-md-4">
            <div class="contact-item">
              <i class="fa fa-map-marker"></i>
              <h4>Localisation</h4>
              <p>Sfax – Tunisie</p>
              <a href="#">Voir sur Google Maps</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="callback-form contact-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
  <div class="section-heading">
    <h2>Envoyer un <em>message</em></h2>
    <span>N’hésitez pas à nous écrire pour toute question ou demande d’information.</span>
  </div>
</div>  
         <div class="col-md-12">
  <div class="contact-form">

    <form method="post">
      <div class="row">

        <!-- Nom -->
        <div class="col-lg-4 col-md-12 col-sm-12">
          <fieldset>
            <input type="text"
                   name="nom"
                   class="form-control"
                   placeholder="Nom complet"
                   required>
          </fieldset>
        </div>

        <!-- Email -->
        <div class="col-lg-4 col-md-12 col-sm-12">
          <fieldset>
            <input type="email"
                   name="email"
                   class="form-control"
                   placeholder="Adresse e-mail"
                   required>
          </fieldset>
        </div>

        <!-- Sujet -->
        <div class="col-lg-4 col-md-12 col-sm-12">
          <fieldset>
            <input type="text"
                   name="sujet"
                   class="form-control"
                   placeholder="Sujet"
                   required>
          </fieldset>
        </div>

        <!-- Message -->
        <div class="col-lg-12">
          <fieldset>
            <textarea name="message"
                      rows="6"
                      class="form-control"
                      placeholder="Votre message"
                      required></textarea>
          </fieldset>
        </div>

        <!-- Bouton -->
        <div class="col-lg-12 text-center">
          <fieldset>
            <button type="submit" class="filled-button">
              Envoyer
            </button>
          </fieldset>
        </div>

      </div>
    </form>

    <?php if ($success) { ?>
      <p style="color:green; margin-top:15px; text-align:center;">
        ✅ Message envoyé avec succès
      </p>
    <?php } ?>

  </div>
</div>
        </div>
      </div>

    <div id="map">
<!-- How to change your own map point
	1. Go to Google Maps
	2. Click on your location point
	3. Click "Share" and choose "Embed map" tab
	4. Copy only URL and paste it within the src="" field below
-->
      <iframe src="https://maps.google.com/maps?q=Av.+Lúcio+Costa,+Rio+de+Janeiro+-+RJ,+Brazil&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="500px" frameborder="0" style="border:0" allowfullscreen></iframe>
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