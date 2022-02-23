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
                            <i class="mdi mdi-pencil"></i>
                        </span> Éditer le compte
                    </h3>
                </div>

                <?php

                    if (isset($_SESSION['unique'])) {
                        echo $_SESSION['unique']; #Displaying Session message
                        unset($_SESSION['unique']); #Removing Session message
                        // session_unset($_SESSION['add']);
                        // session_destroy($_SESSION['add']);
                    }

                ?>

                <?php

                    // Get the id of the selected account
                    $id = $_GET["account_id"];

                    // SQL query to get details related to the selected account
                    $query = "SELECT * FROM compte WHERE id = $id";

                    // Execute the query
                    $result = mysqli_query($conn, $query);

                    // Check whether the query is executed successfully or not
                    if ($result == TRUE) {
                        // Count rows
                        $count = mysqli_num_rows($result);
                        // Check whether the data is available in the database or not
                        if ($count == 1) {
                            // Get the row
                            $row = mysqli_fetch_assoc($result);
                            // Get individual values
                            $login = $row['username'];
                            $role = $row['role'];
                            $statut = $row['statut'];
                        } else {
                            // Redirection to manage-account with session message
                            $_SESSION['fail'] = "<div id='message_error'>Échec lors de la création du compte</div>";
                            header("Location:".HOME_URL."manager/manage-account.php");
                        }
                                        
                    } else {
                        // Redirection to manage-account with session message
                        $_SESSION['no-account-found'] = "<div id='message_error'>Account not found</div>";
                        header("Location:".HOME_URL."manager/manage-account.php");
                    }
                ?>

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample">
                                    <div class="form-group">
                                        <label>Nom d'utilisateur</label>
                                        <input type="text" name="username" class="form-control" value="<?php echo $login; ?>">
                                    </div>
                                    <div class="form-group" <?php echo ($statut == "Actif") ? "style='display: none;'" : ""; ?>>
                                        <label>Rôle</label>
                                        <select class="form-control" name="role">
                                            <option <?php if ($role == "Gestionnaire") { echo "selected"; } ?> value="Gestionnaire">Gestionnaire</option>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label>Statut</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?php //if($statut == "Actif") {echo "checked";} ?> type="radio" class="form-check-input" name="statut" value="Actif"> Actif </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input <?php //if($statut == "Inactif") {echo "checked";} ?> type="radio" class="form-check-input" name="statut" value="Inactif"> Inactif </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
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
                                        $id = $_POST['id'];
                                        $username = $_POST['username'];
                                        $role = $_POST['role'];

                                        // Verify if the username already exists in the database or not
                                        $query4 = "SELECT * FROM compte WHERE username NOT LIKE '$login'";
                                        $result4 = mysqli_query($conn, $query4);
                                        $count4 = mysqli_num_rows($result4);
                                        while ($getData = mysqli_fetch_assoc($result4)) {
                                            $user_name = $getData['username'];
                                            if ($user_name == $username) {
                                                $_SESSION['unique'] = "<div id='message_error'>Modification impossible. Compte déjà existant</div>";
                                                header("Location:".HOME_URL."manager/edit-account.php?account_id=".$id);
                                                die();
                                            }
                                        }

                                        // Check whether the fields of username or password are empty or not
                                        if ($username != "" && $statut == "Inactif") {
                                            // SQL query to update the account parameters
                                            $query2 = "UPDATE compte SET
                                                username = '$username',
                                                role = '$role'
                                                WHERE id = '$id'
                                            ";

                                            // Execute the query
                                            $result2 = mysqli_query($conn, $query2);

                                            // Check whether the update was successful or not
                                            if ($result2 == TRUE) {
                                                // Query executed successfully
                                                $_SESSION['update'] = "<div id='message_success'>Modification effectuée avec succès</div>";
                                                // Redirect to manage-account page
                                                header("Location:".HOME_URL."manager/manage-account.php");
                                            } else {
                                                // Redirection to manage-account page with session message
                                                $_SESSION['update'] = "<div id='message_error'>Échec de la modification</div>";
                                                header("Location:".HOME_URL."manager/manage-account.php");
                                            }
                                        } else if ($username != "" && $statut == "Actif") {
                                            $query3 = "UPDATE compte SET
                                                username = '$username'
                                                WHERE id = '$id'
                                            ";
                                            $result3 = mysqli_query($conn, $query3);
                                            if ($result3 == TRUE) {
                                                // Query executed successfully
                                                $_SESSION['update'] = "<div id='message_success'>Modification effectuée avec succès</div>";
                                                // Redirect to manage-account page
                                                header("Location:".HOME_URL."manager/manage-account.php");
                                            } else {
                                                // Redirection to manage-account page with session message
                                                $_SESSION['update'] = "<div id='message_error'>Échec de la modification</div>";
                                                header("Location:".HOME_URL."manager/manage-account.php");
                                            }
                                        } else {
                                            // Redirection to manage-account page with session message
                                            $_SESSION['update'] = "<div id='message_error'>Échec de la modification</div>";
                                            header("Location:".HOME_URL."manager/manage-account.php");
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