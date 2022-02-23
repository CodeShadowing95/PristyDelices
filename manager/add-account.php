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
                            <i class="mdi mdi-account-plus"></i>
                        </span> Ajouter un compte
                    </h3>
                </div>

                <?php
                    if (isset($_SESSION['add'])) {
                        echo $_SESSION['add']; #Displaying Session message
                        unset($_SESSION['add']); #Removing Session message
                        // session_unset($_SESSION['add']);
                        // session_destroy($_SESSION['add']);
                    }

                    if (isset($_SESSION['unique'])) {
                        echo $_SESSION['unique']; #Displaying Session message
                        unset($_SESSION['unique']); #Removing Session message
                        // session_unset($_SESSION['add']);
                        // session_destroy($_SESSION['add']);
                    }
                ?>

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample">
                                    <div class="form-group">
                                        <label>Nom d'utilisateur</label>
                                        <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur">
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe <i class="mdi mdi-alert-circle-outline" data-toggle="modal" data-target="#hint"></i></label>
                                        <input type="password" name="mot_de_passe" class="form-control" placeholder="Mot de passe">
                                    </div>
                                    <div class="form-group">
                                        <label>Confirmer le mot de passe</label>
                                        <input type="password" name="confirm_mdp" class="form-control" placeholder="Confirmer le mot de passe">
                                    </div>
                                    <div class="form-group">
                                        <label>Rôle</label>
                                        <select class="form-control" name="role">
                                            <option value="Gestionnaire">Gestionnaire</option>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label>Statut</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="actif" value="Actif"> Actif </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="actif" value="Inactif"> Inactif </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <button type="submit" name="submit" class="btn btn-success mr-2">Créer</button>
                                    <button class="btn btn-danger" name="cancel">Annuler</button>
                                </form>

                                <?php
                                    // If the user clicked on the cancel button, redirection to manage-admin page
                                    if (isset($_POST['cancel'])) {
                                        header("Location:".HOME_URL."manager/manage-account.php");
                                    }

                                    // If the user clicked on the submit button, get the values from the form
                                    if (isset($_POST['submit'])) {
                                        $username = $_POST['username'];
                                        $password = md5($_POST['mot_de_passe']);
                                        $confirm_mdp = md5($_POST['confirm_mdp']);
                                        $role = $_POST['role'];

                                        // Check whether the radio button is selected or not
                                        if (isset($_POST['actif'])) {
                                            $statut = $_POST['actif'];
                                        } else {
                                            $statut = "Inactif";
                                        }


                                        // Check whether the fields of username or password are empty or not
                                        if ($username != "" AND $password != "") {
                                            // Verify if the username already exists in the database or not
                                            $sql = "SELECT * FROM compte WHERE username='$username'";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);
                                            if ($count == 1) {
                                                $_SESSION['unique'] = "<div id='message_error'>Erreur: Le compte existe déjà</div>";
                                                header("Location:".HOME_URL."manager/add-account.php");
                                                die();
                                            }
                                            
                                            if ($password === $confirm_mdp) {
                                                // SQL query to save data into the database
                                                $query = "INSERT INTO compte SET
                                                    username = '$username',
                                                    mot_de_passe = '$password',
                                                    role = '$role',
                                                    statut = 'Inactif'
                                                ";

                                                // Execute the query
                                                $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

                                                // Check whether the data is inserted into the database or not
                                                if ($res == TRUE) {
                                                    // Create a session variable to display the message
                                                    $_SESSION['add'] = "<div id='message_success'>Compte créé avec succès</div>";
                                                    // Redirection
                                                    header('Location:'.HOME_URL.'manager/manage-account.php');
                                                } else {
                                                    $_SESSION['add'] = "<div id='message_error'>Échec de la création du compte</div>";
                                                    header('Location:'.HOME_URL.'manager/add-account.php');
                                                }
                                            } else {
                                                $_SESSION['add'] = "<div id='message_error'>Les mots de passe ne correspondent pas</div>";
                                                header('Location:'.HOME_URL.'manager/add-account.php');
                                            }

                                        } else {
                                            $_SESSION['add'] = "<div id='message_error'>Échec de la création du compte</div>";
                                            header('Location:'.HOME_URL.'manager/add-account.php');
                                        }

                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="hint" tabindex="-1" role="dialog" aria-labelledby="labelHint" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="labelHint">Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <label for="hint">
                            <p class="text-height-2">
                                Le mot de passe doit contenir:
                                <ul>
                                    <li>Au moins 10 caractères</li>
                                    <li>Au moins 1 majuscule et 1 minuscule</li>
                                    <li>Au moins 1 nombre</li>
                                    <li>Au moins 1 caractère spécial (§,#,$,^,~,%,...)</li>
                                </ul>
                            </p>
                        </label>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">OK</button>
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
