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
                    <!-- Actions -->
                    <?php
                        // Get the id and the image of the selected category
                        if (isset($_GET['account_id'])) {
                            $id = $_GET['account_id'];
                            
                            $sql = "SELECT * FROM compte WHERE id = $id";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);
                            if ($count == 1) {
                                $data = mysqli_fetch_assoc($res);
                                $username = $data['username'];
                                $statut = $data['statut'];
                            }
                        }
                    ?>
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                            <i class="mdi mdi-account"></i>
                        </span> Suppression du compte "<?php echo $username; ?>"
                    </h3>

                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <label class="font-italic text-danger">
                                    <?php
                                        if ($statut="Actif" or $statut="Compte bloqué") {
                                            echo "Attention: Cette action est irréversible. Le compte sera définitivement 
                                            supprimé, ainsi que l'utilisateur qui y est associé.";
                                        } else {
                                            echo "Attention: Cette action est irréversible. Le compte sera définitivement 
                                            supprimé.";
                                        }
                                    ?>
                                </label><br>
                                <label>Êtes-vous sûr(e) de vouloir continuer?</label>
                            </div>
                            <div class="card-footer">
                                <form action="" method="POST">
                                    <button type="submit" name="submit" class="btn btn-success">Oui</button>
                                    <button class="btn btn-danger" name="cancel">Non</button>
                                    <?php
                                        if (isset($_POST['cancel'])) {
                                            header("Location:".HOME_URL."manager/manage-account.php");
                                        }

                                        if (isset($_POST['submit'])) {
                                            // SQL query to delete the account
                                            $query = "DELETE FROM compte WHERE id = $id";

                                            // Execute the query
                                            $result = mysqli_query($conn, $query);

                                            // Check whether the query executed successfully or not
                                            if ($result == TRUE) {
                                                // Query executed successfully and account deleted
                                                // Create session variable to display the message and redirection
                                                $_SESSION['delete'] = "<div id='message_success'>Compte supprimé avec succès</div>";
                                                header("Location:".HOME_URL."manager/manage-account.php");
                                            } else {
                                                // Query not executed successfully
                                                $_SESSION['delete'] = "<div id='message_error'>Échec de suppression</div>";
                                                header('Location:' .HOME_URL. 'manager/manage-account.php');
                                            }
                                        }
                                    ?>
                                </form>
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

<!-- Without redirection to a  page to confirm the deletion -->
<?php

    // Include constants.php file for the connection to the database
    // include('../config/constants.php');

    // // Get the account_id to be deleted
    // $id = $_GET['account_id'];

    // // SQL query to delete the account
    // $query = "DELETE FROM compte WHERE id = $id";

    // // Execute the query
    // $result = mysqli_query($conn, $query);

    // // Check whether the query executed successfully or not
    // if ($result == TRUE) {
    //     // Query executed successfully and account deleted
    //     // Create session variable to display the message and redirection
    //     $_SESSION['delete'] = "<div id='message_success'>Compte supprimé avec succès</div>";
    //     header("Location:".HOME_URL."manager/manage-account.php");
    // } else {
    //     // Query not executed successfully
    //     $_SESSION['delete'] = "<div id='message_error'>Échec de suppression</div>";
    //     header('Location:' .HOME_URL. 'manager/manage-account.php');
    // }

?>