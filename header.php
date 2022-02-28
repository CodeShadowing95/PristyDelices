<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="./images/default.png" type="image/x-icon">
    <title>Pristy Délices | Accueil</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Owl carousel CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS file -->
    <link rel="stylesheet" href="style.css">

    <?php
      // Require config.php file
      require("functions.php");
      // include('./auth/login-check.php');
    ?>

</head>
<body>

    <!-- Header starts -->
    <header id="header" class="sticky-top">
        <div class="strip d-flex justify-content-between px-4 py-1 bg-light">
            <p class="font-raleway font-size-12 text-black-50 m-0">Pristy Délices | <a href="#" data-toggle="modal" data-target="#pd_map" class="text-primary">Yaoundé, Cité U</a> | (+237) 697 53 79 55</p>
            <div class="font-rale font-size-14">
                <!-- <a href="#" class="px-3 border-right border-left text-dark">Login</a> -->
                <?php
                if(isset($_SESSION['user'])) {
                  ?>
                  <a href="panier.php?#wishlist" class="px-3 border-right text-dark">Mes envies(<?php echo count($product->getProducts('envies', $_SESSION['user'])) != 0 ? count($product->getProducts('envies', $_SESSION['user'])) : 0; ?>)</a>
                  <?php
                }
                ?>
            </div>
        </div>

        <!-- Primary Navigation starts -->
        <nav class="navbar navbar-expand-lg navbar-dark color-orange-bg">
          <a class="navbar-brand font-baloo text-white" href="index.php">
            <img src="./images/default.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Pristy Délices
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto font-rubik">
              <li class="nav-item active">
                <a class="nav-link text-light" href="index.php">Accueil <span class="sr-only">(current)</span></a>
              </li>
              <!-- basename(__FILE__) give the filename that it is called from -->
              <?php
                $phpFile = explode("/", $_SERVER['REQUEST_URI']);
                ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                    Catégories
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                      $sn = 1;
                      foreach ($activeCategories as $category) {
                        if($phpFile[2] != 'index.php') {
                          ?>
                          <a class="dropdown-item" href="index.php#<?php echo str_replace(' ', '', $category['nom']); ?>"><i class="fas fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['nom']; ?></a>
                          <?php
                        } else {
                          ?>
                          <a class="dropdown-item" href="#<?php echo str_replace(' ', '', $category['nom']); ?>"><i class="fas fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['nom']; ?></a>
                          <?php
                        }
                      }
                    ?>
                    <!-- <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a> -->
                  </div>
                </li>
                <?php
              ?>
              <li class="nav-item">
                <a class="nav-link text-light" href="grid-price.php">Grille des prix</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-light" href="#">Évènements</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link text-light" href="#">Nous localiser</a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="#" class="btn btn-outline-dark font-weight-bold">Commandez</a>
              </li> -->
            </ul>
            <span class="form-inline py-2">
              <!-- Example split danger button -->
              <div class="btn-group mr-2">
                <?php
                if(isset($_SESSION['user'])) {
                  ?>
                  <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php
                    $firstname = explode(" ", $_SESSION['nom']);
                    $lastname = explode(" ", $_SESSION['prenom']);
                    ?>
                    <i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $firstname[0]." ".$lastname[0]; ?>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Mon profil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;&nbsp;Déconnexion</a>
                  </div>
                  <?php
                } else {
                  ?>
                  <a href="./auth/sign_in.php" class="btn btn-light btn-sm">
                    <i class="fas fa-user"></i>&nbsp;&nbsp;Se connecter
                  </a>
                  <?php
                }
                ?>
              </div>
              <?php
              if(isset($_SESSION['user'])) {
                ?>
                <form action="" class="font-size-14 font-raleway">
                    <a href="panier.php" class="py-2 rounded color-primary-bg">
                        <span class="font-size-16 px-2 text-white"><i class="fas fa-shopping-cart"></i></span>
                        <span class="px-3 py-2 rounded text-dark bg-light"><?php echo count($product->getProducts('panier', $_SESSION['user'])) != 0 ? count($product->getProducts('panier', $_SESSION['user'])) : 0; ?></span>
                    </a>
                </form>
                <?php
              }
              ?>
            </span>
          </div>
        </nav>
        <!-- Primary Navigation ends -->
    </header>
    <!-- Header ends -->

    <!-- Hint message modal -->
    <div class="modal fade" id="pd_map" tabindex="-1" role="dialog" aria-labelledby="labelHint" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width: 700px">
          <div class="modal-header">
            <h5 class="modal-title" id="labelHint">Plan de localisation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3980.790134135319!2d11.498228114845034!3d3.8551674971957204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcf19a3997a3f%3A0xfcab79f001aabf7d!2sCit%C3%A9%20universitaire!5e0!3m2!1sfr!2scm!4v1644775854105!5m2!1sfr!2scm" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Session messages -->
    <?php
      if(isset($_SESSION['added'])) {
        echo $_SESSION['added'];
        unset($_SESSION['added']);
      }

      if(isset($_SESSION['conn_succeeded'])) {
        echo $_SESSION['conn_succeeded'];
        unset($_SESSION['conn_succeeded']);
      }
  
    ?>

    <!-- Main starts -->
    <main id="main-site">