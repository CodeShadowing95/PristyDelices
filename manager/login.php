<?php include("../config/constants.php"); ?>


<!doctype html>
<html lang="en">
  <head>
    <title>Authentification | Gestionnaire</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="shortcut icon" href="login-tools/images/pristy_delice.png" type="image/x-icon">
	
    <link rel="stylesheet" href="login-tools/css/style.css">

    <style>
        /* ********************************************** */
        /* Another form of toast */
        /* ********************************************** */
        #message_success {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #2ed573;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            right: 30px;
            top: 100px;
            font-size: 17px;
          }
          #message_success.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
          }
  
          #message_error {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #ff4757;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            right: 30px;
            top: 100px;
            font-size: 17px;
          }
          #message_error.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
          }
  
          @-webkit-keyframes fadein {
            from {right: 0; opacity: 0;} 
            to {right: 30px; opacity: 1;}
          }
  
          @keyframes fadein {
            from {right: 0; opacity: 0;}
            to {right: 30px; opacity: 1;}
          }
  
          @-webkit-keyframes fadeout {
            from {right: 30px; opacity: 1;} 
            to {right: 0; opacity: 0;}
          }
  
          @keyframes fadeout {
            from {right: 30px; opacity: 1;}
            to {right: 0; opacity: 0;}
          }
          /* ********************************************** */
          /* End another form of toast */
          /* ********************************************** */
    </style>
	
    <!-- <link rel="stylesheet" href="login-tools/css/style2.css"> -->

    </head>
    <body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        <div class="img" style="background-image: url(login-tools/images/default.png);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Connexion</h3>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <button type="button" data-toggle="modal" data-target="#hint" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-exclamation"></span></button>
                                    </p>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="hint" tabindex="-1" role="dialog" aria-labelledby="labelHint" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="labelHint">Information</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <label for="hint">
                                            Lorsqu'il vous est signalé que votre compte a été bloqué ou qu'il est inactif, veuillez s'il vous plaît vous rapprocher
                                            de l'administrateur supérieur pour d'amples informations.
                                        </label>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-dark" data-dismiss="modal">OK</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>

                            <!-- Session messages -->
                            <?php
                            if (isset($_SESSION['login'])) {
                                echo $_SESSION['login'];
                                unset($_SESSION['login']);
                            }
                            if (isset($_SESSION['login-fail'])) {
                                echo $_SESSION['login-fail'];
                                unset($_SESSION['login-fail']);
                            }
                            if (isset($_SESSION['account-blocked'])) {
                                echo $_SESSION['account-blocked'];
                                unset($_SESSION['account-blocked']);
                            }
                            ?>

                            <form action="" class="signin-form" method="POST">
                                <div class="form-group mt-3">
                                    <input type="text" class="form-control" name="username" required>
                                    <label class="form-control-placeholder">Nom d'utilisateur </label>
                                </div>
                                <div class="form-group">
                                  <input id="password-field" type="password" class="form-control" name="password" required>
                                  <label class="form-control-placeholder" for="password">Mot de passe</label>
                                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3" value="Se connecter">
                                </div>
                                <!-- <div class="form-group d-md-flex">
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Se souvenir de moi
                                            <input type="checkbox">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="#">Mot de passe oublié?</a>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="login-tools/js/jquery.min.js"></script>
    <script src="login-tools/js/popper.js"></script>
    <script src="login-tools/js/bootstrap.min.js"></script>
    <script src="login-tools/js/main.js"></script>
    <script src="assets/js/success.js"></script>
    <script src="assets/js/error.js"></script>

    </body>
</html>


<?php

    // Check whether the submit button is clicked or not
    if (isset($_POST['submit'])) {
        // Process for login
        // Get the data from the login form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = md5($_POST['password']);

        // Check whether the user is the manager or not
        $sql = "SELECT * FROM compte,gestionnaire
        WHERE username='$username' AND mot_de_passe='$password'
        AND compte.id = gestionnaire.idCompte";

        $result =mysqli_query($conn,$sql);

        if ($result == TRUE) {
          $count = mysqli_num_rows($result);

          if ($count == 1) {
              $row = mysqli_fetch_assoc($result);
              $compte = $row['id'];
              $gestionnaire = $row['id_gest'];
              $role = $row['role'];
              $statut = $row['statut'];
              $nom = $row['nom'];
              $profil = $row['profil'];
              $contact = $row['contact'];
              $adresse = $row['adresse'];
              $email = $row['email'];
              if ($statut == "Compte bloqué") {
                  // Account was disabled
                  $_SESSION['account-blocked'] = "<div id='message_error'>Échec de connexion: Votre compte est inactif ou a été bloqué.</div>";
                  header("Location:".HOME_URL."manager/login.php");
              }
              else {
                  // User found
                  $_SESSION['compte'] = $compte;
                  $_SESSION['gestionnaire'] = $gestionnaire;
                  $_SESSION['user'] = $username;
                  $_SESSION['nom'] = $nom;
                  $_SESSION['role'] = $role;
                  $_SESSION['profil'] = $profil;
                  $_SESSION['contact'] = $contact;
                  $_SESSION['adresse'] = $adresse;
                  $_SESSION['email'] = $email;
                  $_SESSION['login'] = "<div id='message_success'>Bienvenue sur Pristy Délices, ".$nom."</div>";
                  header("Location:".HOME_URL."manager/index.php");
              }
          }
      } else {
          $_SESSION['login'] = "<div id='message_error'>Nom d'utilisateur ou mot de passe incorrect. <br>Veuillez réessayer.</div>";
          header("Location:".HOME_URL."manager/login.php");
      }
    }

?>

