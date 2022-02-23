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
                            <i class="mdi mdi-account"></i>
                        </span> Gestion des Comptes
                    </h3>

                    <!-- Session messages -->

                    <!-- Actions -->
                    <?php
                        // Get the id of the selected account
                        $id = $_GET['account_id'];

                        // SQL query to get the details of the selected account
                        $sql = "SELECT * FROM compte WHERE id = $id";

                        // Execute the query
                        $result = mysqli_query($conn, $sql);

                        // Check whether the query succeeded or not
                        if ($result == TRUE) {
                            // Count rows
                            $count = mysqli_num_rows($result);
                            // Check whether the data is unique in the database
                            if ($count == 1) {
                                // Get the row from the database
                                $row = mysqli_fetch_assoc($result);
                                // Get the values from the row
                                $username = $row['username'];
                                $statut = $row['statut'];
                                $role = $row['role'];
                            } else {
                                // Redirection to manage-account page with session message
                                $_SESSION['many-values'] = "<div id='message_error'>Erreur: Plusieurs utilisateurs trouvés</div>";
                                header("Location:".HOME_URL."manager/access-account.php");
                            }
                        } else {
                            // Redirection to manage-account page with session message
                            $_SESSION['no-user'] = "<div id='message_error'>Erreur: Utilisateur introuvable</div>";
                            header("Location:".HOME_URL."manager/access-account.php");
                        }
                    ?>

                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <label class="font-italic text-danger">
                                    <?php
                                        if ($statut == "Actif") {
                                            if ($role == "Administrateur") {
                                                echo "Attention: L'utilisateur associé à ce compte 
                                                ne pourra plus se connecter au site en tant 
                                                qu'Administrateur pour y effectuer des opérations";
                                            } else {
                                                echo "Attention: L'utilisateur associé à ce compte 
                                                ne pourra plus se connecter au site en tant 
                                                que Gestionnaire pour y effectuer des opérations";
                                            }
                                            
                                        } else if ($statut == "Compte bloqué") {
                                            echo "L'utilisateur associé à ce compte pourra 
                                            désormais se connecter à l'application et y 
                                            effectuer des opérations";
                                        }
                                    ?>
                                </label><br>
                                <label>Voulez-vous vraiment <?php echo ($statut == "Actif") ? "bloquer" : "débloquer"; ?> le compte <span class="font-weight-bold"><?php echo $username?></span> ?</label>
                            </div>
                            <div class="card-footer">
                                <form action="" method="post">
                                    <button type="submit" name="submit" class="btn btn-success">Oui</button>
                                    <button class="btn btn-danger" name="cancel">Non</button>
                                </form>
                            </div>

                            <?php
                                if (isset($_POST['cancel'])) {
                                    header("Location:".HOME_URL."manager/manage-account.php");
                                }


                                if (isset($_POST['submit'])) {
                                    // echo "Cool";
                                    
                                    // Check whether the current statut is "Actif" or "Compte bloqué"
                                    if ($statut == "Actif") {
                                        // SQL query to change the status of the account to "Compte bloqué"
                                        $sql2 = "UPDATE compte SET statut = 'Compte bloqué' WHERE id = $id";

                                        // Execute the query
                                        $result2 = mysqli_query($conn, $sql2);

                                        // Check whether the query is executed successfully or not
                                        if ($result2 == TRUE) {
                                            // Redirection and session message
                                            $_SESSION['lock'] = "<div id='message_success'>Le compte a été bloqué</div>";
                                            header("Location:".HOME_URL."manager/manage-account.php");
                                        } else {
                                            // Message
                                            $_SESSION['lock'] = "<div id='message_error'>Une erreur est survenue</div>";
                                            header("Location:".HOME_URL."manager/manage-account.php");
                                        }
                                    } else if ($statut = "Compte bloqué") {
                                        $sql3 = "UPDATE compte SET statut = 'Actif' WHERE id = $id";

                                        // Execute the query
                                        $result3 = mysqli_query($conn, $sql3);

                                        // Check whether the query is executed or not
                                        if ($result3 == TRUE) {
                                            // Message
                                            $_SESSION['unlock'] = "<div id='message_success'>Le compte a été débloqué</div>";
                                            header("Location:".HOME_URL."manager/manage-account.php");
                                        } else {
                                            // Message
                                            $_SESSION['unlock'] = "<div id='message_error'>Une erreur est survenue</div>";
                                            header("Location:".HOME_URL."manager/manage-account.php");
                                        }
                                    } else {
                                        header("Location:".HOME_URL."manager/manage-account.php");
                                    }
                                }
                            ?>

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