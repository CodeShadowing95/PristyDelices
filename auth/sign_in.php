<?php
    // include header
    include("./header_login.php");
    require("./helper.php");
?>

<?php
    // Session messages
    if(isset($_SESSION['new_user'])) {
        echo $_SESSION['new_user'];
        unset($_SESSION['new_user']);
    }

    if (isset($_SESSION['user_not_found'])) {
        echo $_SESSION['user_not_found'];
        unset($_SESSION['user_not_found']);
    }
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['backHome'])) {
            header("Location:".HOME_URL);
        }
    }
?>

<!-- Login  Form -->
<section class="sign-in">
    <div class="container">
        <div class="signin-content">
            <div class="signin-image">
                <figure><img src="../images/products/PD-Product-1615.jpg" alt="Login_image"></figure>
                <a href="sign_up.php" class="signup-image-link">Créer un compte</a>
            </div>

            <div class="signin-form">
                <!-- Session messages -->
                <?php
                    // if (isset($_SESSION['login_fail'])) {
                    //     echo $_SESSION['login_fail'];
                    //     unset($_SESSION['login_fail']);
                    // }
                ?>

                <?php

                    // Get all the errors from inputs
                    $error = array();

                    if (isset($_POST['connect'])) {
                        // echo 'Cool';
                        $login = validate_input_text($_POST['login']);
                        if(empty($login)) {
                            $error[] = 'No login';
                        }

                        $password = validate_input_text($_POST['pwd']);
                        if(empty($password)) {
                            $error[] = 'No password';
                        }

                        // Check whether all the fields have been filled
                        if(empty($error)) {
                            $query = "SELECT * FROM client WHERE (login = '$login' OR email = '$login') AND mot_de_passe = '".md5($password)."'";

                            $result = mysqli_query($conn, $query);

                            // print_r($result);

                            $count = mysqli_num_rows($result);

                            if($count == 1) {
                                $data = mysqli_fetch_assoc($result);

                                $_SESSION['user'] = $data['id_client'];
                                $_SESSION['nom'] = $data['nom_client'];
                                $_SESSION['prenom'] = $data['prenom'];
                                $_SESSION['login'] = $data['login'];
                                $_SESSION['email'] = $data['email'];
                                $_SESSION['telephone'] = $data['telephone'];
                                $_SESSION['conn_succeeded'] = '
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Bienvenue sur Pristy Délices, </strong>'.$_SESSION['nom'].'
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';

                                header("Location:".HOME_URL);
                            } else {
                                echo "<span style='color:red;font-weight:bold;font-size:15px;text-align:center;'>Login ou mot de passe incorrects</span>";
                                // header("Location:".$_SERVER['PHP_SELF']);
                                // echo $result;
                            }
                        }
                    }
                ?>
                <h2 class="form-title">Connexion</h2>
                <form action="" method="POST" class="register-form" id="login-form">
                    <div class="form-group">
                        <label for="login"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input type="text" name="login" id="login" placeholder="Votre login ou email" required/>
                    </div>
                    <div class="form-group">
                        <label for="pwd"><i class="zmdi zmdi-lock"></i></label>
                        <input type="password" name="pwd" id="pwd" placeholder="Mot de passe" required/>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                        <label for="remember-me" class="label-agree-term"><span><span></span></span>Se souvenir de moi</label>
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="connect" id="connect" class="form-submit" value="Se connecter"/>
                    </div>
                </form>
                <div class="social-login">
                    <!-- <span class="social-label">Or login with</span> -->
                    <ul class="socials">
                        <li>
                            <form action="" method="post">
                                <input type="submit" value="Page d'accueil" name="backHome">
                            </form>
                        </li>
                        <!-- <li><a href="../index.php">Retour à la page d'accueil</a></li> -->
                        <!-- <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                        <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                        <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>

<?php
    // include footer
    include("./footer_login.php");
?>