<?php
    // include header
    include("./header_login.php");
    require("./helper.php");
?>

<!-- Registration form -->
<section class="signup">
    <div class="container">
        <div class="signup-content">
            <div class="signup-form">
                <?php
                    if (isset($_SESSION['confirm_pwd'])) {
                        echo $_SESSION['confirm_pwd'];
                        unset($_SESSION['confirm_pwd']);
                    }
                ?>
                <h2 class="form-title">Inscription</h2>
                <form method="POST" class="register-form" id="register-form">
                    <div class="form-group">
                        <label for="nom"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="nom" id="nom" placeholder="Nom(s)"/>
                    </div>
                    <div class="form-group">
                        <label for="prenom"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="prenom" id="prenom" placeholder="Prénom(s)"/>
                    </div>
                    <div class="form-group">
                        <label for="tel"><i class="zmdi zmdi-phone"></i></label>
                        <input type="number" name="tel" id="tel" placeholder="Téléphone" required />
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="zmdi zmdi-email"></i></label>
                        <input type="email" name="email" id="email" placeholder="Email" required />
                    </div>
                    <div class="form-group">
                        <label for="login"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="login" id="login" placeholder="Login" required />
                    </div>
                    <div class="form-group">
                        <label for="pwd"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="pwd" id="pwd" placeholder="Mot de passe" required />
                    </div>
                    <div class="form-group">
                        <label for="re-pwd"><i class="zmdi zmdi-lock-outline"></i></label>
                        <input type="password" name="re_pwd" id="re_pwd" placeholder="Confirmer le mot de passe" required />
                    </div>
                    <!-- <div class="form-group">
                        <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>J'accepte toutes les déclarations des  <a href="#" class="term-service">conditions d'utilisation</a></label>
                    </div> -->
                    <div class="form-group form-button">
                        <input type="submit" name="submit_btn" id="inscrire" class="form-submit" value="S'inscrire"/>
                    </div>
                </form>
            </div>
            <div class="signup-image">
                <figure><img src="../images/default.png" alt="Login_image"></figure>
                <a href="sign_in.php" class="signup-image-link">J(ai déjà un compte</a>
            </div>
        </div>
    </div>


    <?php

    // Get all the errors from inputs
    $error = array();

    if (isset($_POST['submit_btn'])) {

        $nom = validate_input_text($_POST['nom']);
        if (empty($nom)) {
            $error[] = 'Le nom est obligatoire';
        }

        $prenom = validate_input_text($_POST['prenom']);
        if (empty($prenom)) {
            $error[] = 'Le prénom est obligatoire';
        }

        $tel = $_POST['tel'];

        $email = validate_input_email($_POST['email']);
        if (empty($email)) {
            $error[] = 'Email est obligatoire';
        }

        $login = validate_input_text($_POST['login']);
        if (empty($login)) {
            $error[] = 'Le login est obligatoire';
        }

        $password = validate_input_text($_POST['pwd']);
        if (empty($password)) {
            $error[] = 'Le mot de passe est obligatoire';
        }

        $repeat_pwd = validate_input_text($_POST['re_pwd']);
        if (empty($repeat_pwd)) {
            $error[] = 'Le mot de passe doit être confirmé';
        }

        if (empty($error)) {
            if($password == $repeat_pwd) {
                $hashed_pwd = md5($password);

                $sql_query = "INSERT INTO client SET
                    nom_client = '$nom',
                    prenom = '$prenom',
                    email = '$email',
                    telephone = $tel,
                    login = '$login',
                    mot_de_passe = '$hashed_pwd'
                ";

                $result = mysqli_query($conn, $sql_query) or die(mysqli_error($conn));

                if($result == TRUE) {
                    $_SESSION['new_user'] = "<p style='color:green;font-weight:bold;text-align:center;'>Compte créé avec succès</p>";
                    header("Location:".HOME_URL."auth/sign_in.php");
                } else {
                    $_SESSION['new_user'] = "Échec de l'opération";
                    header("Location: sign_up.php");
                }
            } else {
                $_SESSION['confirm_pwd'] = "<span style='color:red;font-weight:bold;'>Erreur: Les mots de passe ne coïncident pas.</span>";
                header("Location: sign_up.php");
            }
        } else {
            $_SESSION['not_empty'] = "<span style='color:red;font-weight:bold;'>Erreur: Certains champs sont invalides.</span>";
            header("Location: sign_up.php");
        }
    }

    ?>


</section>

<?php
    // include footer
    include("./footer_login.php");
?>