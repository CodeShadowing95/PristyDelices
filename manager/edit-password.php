<div class="container-scroller">
    <!-- partial:partials/navbar.php -->
    <?php
        include('partials/navbar.php');
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/sidebar.php -->
        <?php
            include('partials/sidebar.php');
        ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                            <i class="mdi mdi-account-settings"></i>
                        </span> Modifier mot de passe
                    </h3>
                </div>

                <?php
                    // Hide errors from users
                    error_reporting(0);
                    // Display errors only in apache log
                    // ini_set('display_errors', 0);

                    // Get the id of the selected account
                    if (isset($_GET['account_id'])) {
                        $id = $_GET['account_id'];
                        // $username = $_GET['username'];
                    }
                ?>
                
                <?php

                    if (isset($_SESSION['pwd-not-match'])) {
                        echo $_SESSION['pwd-not-match']; #Displaying Session message
                        unset($_SESSION['pwd-not-match']); #Removing Session message
                        // session_unset($_SESSION['add']);
                        // session_destroy($_SESSION['add']);
                    }

                    if (isset($_SESSION['empty'])) {
                        echo $_SESSION['empty']; #Displaying Session message
                        unset($_SESSION['empty']); #Removing Session message
                        // session_unset($_SESSION['add']);
                        // session_destroy($_SESSION['add']);
                    }

                ?>

                

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample">
                                    <!-- <div class="form-group">
                                        <label>Compte</label>
                                        <input type="text" name="username" class="form-control" value="<?php echo $username ?>" disabled>
                                    </div> -->
                                    <div class="form-group">
                                        <label>Ancien mot de passe</label>
                                        <input type="password" name="old_pwd" class="form-control" placeholder="Mot de passe courant">
                                    </div>
                                    <div class="form-group">
                                        <label>Nouveau mot de passe</label>
                                        <input type="password" name="new_pwd" class="form-control" placeholder="Nouveau mot de passe">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirmer le mot de passe</label>
                                        <input type="password" name="confirm_pwd" class="form-control" placeholder="Confirmer le mot de passe">
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <button type="submit" name="submit" class="btn btn-success mr-2">Confirmer les changements</button>
                                    <button class="btn btn-danger" name="cancel">Annuler</button>
                                </form>

                                <?php
                                    // If the user clicked on the cancel button, redirection to manage-account page
                                    if (isset($_POST['cancel'])) {
                                        header("Location:".HOME_URL."manager/manage-account.php");
                                    }

                                    // If the user clicked on the submit button, get the values from the form
                                    if (isset($_POST['submit'])) {

                                        // Get the data from the form
                                        $id = $_POST['id'];
                                        $old_pwd = md5($_POST['old_pwd']);
                                        $new_pwd = $_POST['new_pwd'];
                                        $confirm_pwd = $_POST['confirm_pwd'];

                                        // Check whether the fields are empty or not
                                        if ($new_pwd == "" || $confirm_pwd == "") {
                                            $_SESSION['empty'] = "<div id='message_error'>Veuillez remplir tous les champs</div>";
                                            header("Location:".HOME_URL."manager/edit-password.php");
                                            die();
                                        } else {
                                            $new_password = md5($new_pwd);
                                            $confirm_password = md5($_POST['confirm_pwd']);


                                            // Check whether the user with the current password exists or not
                                            $query = "SELECT * FROM compte WHERE id = $id AND mot_de_passe = '$old_pwd'";

                                            // Execute the query
                                            $result = mysqli_query($conn, $query);

                                            if ($result == TRUE) {
                                                $count = mysqli_num_rows($result);

                                                if ($count == 1) {
                                                    // User exists and password can be changed
                                                    // Check whether the new password and confirmation password match or not
                                                    if ($new_password == $confirm_password) {
                                                        // Update the password
                                                        $query2 = "UPDATE compte SET mot_de_passe = '$new_password' WHERE id = $id";

                                                        // Execute the query
                                                        $result2 = mysqli_query($conn, $query2);

                                                        if ($result2 == TRUE) {
                                                            $_SESSION['edit-password'] = "<div id='message_success'>Modification effectuée avec succès</div>";
                                                            header("Location:".HOME_URL."manager/manage-account.php");
                                                        } else {
                                                            $_SESSION['edit-password'] = "<div id='message_error'>Échec: Mot de passe courant invalide. Réessayer.</div>";
                                                            header("Location:".HOME_URL."manager/manage-account.php");
                                                        }
                                                    } else {
                                                        $_SESSION['pwd-not-match'] = "<div id='message_error'>Échec: Les mots de passe ne correspondent pas</div>";
                                                        header("Location:".HOME_URL."manager/edit-password.php");
                                                    }
                                                } else {
                                                    $_SESSION['user-not-found'] = "<div id='message_error'>Échec. Veuillez réessayer.</div>";
                                                    header("Location:".HOME_URL."manager/manage-account.php");
                                                }
                                            }
                                        }
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- partial:partials/_footer.html -->
            <?php
                include('partials/footer.php');
            ?>
            <!-- partial -->
        </div>
    </div>
</div>


<script src="assets/js/error.js"></script>
