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
                        // Check whether the id and image_name are set or not
                        // 'sn' is to get to the table compte in order to modify
                        // the status into 'Inactif'
                        if (isset($_GET['id']) AND isset($_GET['image']) AND isset($_GET['sn'])) {
                            // echo "Cool";
                            // Get the value and delete the user
                            $id = $_GET['id'];
                            $image_name = $_GET['image'];
                            $id_compte = $_GET['sn'];
                            
                            $query = "SELECT nom FROM gestionnaire WHERE id_gest = $id";
                            $res = mysqli_query($conn, $query);
                            $count = mysqli_num_rows($res);
                            if ($count == 1) {
                                $data = mysqli_fetch_assoc($res);
                                $nom = $data['nom'];
                            }
                        } else {
                            header("Location:".HOME_URL."manager/manage-gest.php");
                        }
                    ?>
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                            <i class="mdi mdi-account"></i>
                        </span> Suppression du gestionnaire "<?php echo $nom; ?>"
                    </h3>

                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <label class="font-italic text-danger">
                                    <?php
                                        echo "Attention: Cette action est irréversible. Le/la gestionnaire sera supprimé(e) 
                                        définitivement.";
                                    ?>
                                </label><br>
                                <label>Êtes-vous sûr(e) de vouloir continuer?</label>
                            </div>
                            <div class="card-footer">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <button type="submit" name="submit" class="btn btn-success">Oui</button>
                                    <button class="btn btn-danger" name="cancel">Non</button>
                                    <?php
                                        if (isset($_POST['cancel'])) {
                                            header("Location:".HOME_URL."manager/manage-gest.php");
                                        }


                                        if (isset($_POST['submit'])) {

                                            // Remove the image if found
                                            if ($image_name != "") {
                                                // Image found and can be removed
                                                // Get the path
                                                $path = "../images/admin_gest_profiles/". $image_name;

                                                // Remove the image
                                                $remove = unlink($path);

                                                // If failed to remove the image, redirection to manage-gest page
                                                // with error message and stop the process
                                                if ($remove === false) {
                                                    $_SESSION['remove_img'] = "<div id='message_error'>Une erreur est survenue</div>";
                                                    header("Location:".HOME_URL."manager/manage-gest.php");
                                                    // Stop the process of deleting the category
                                                    die();
                                                }
                                            }

                                            // Delete data from the database
                                            $sql = "DELETE FROM gestionnaire WHERE id_gest = $id";

                                            // Execute the query
                                            $result = mysqli_query($conn, $sql);

                                            // Check whether the data is deleted or not
                                            if ($result == TRUE) {
                                                $sql2 = "UPDATE compte SET statut = 'Inactif' WHERE id = $id_compte";
                                                $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
                                                if ($result2 == TRUE) {
                                                    $_SESSION['delete'] = "<div id='message_success'>Suppression effectuée avec succès</div>";
                                                    header("Location:".HOME_URL."manager/manage-gest.php");
                                                } else {
                                                    $_SESSION['delete'] = "<div id='message_error'>Échec: Problème avec le statut du compte associé</div>";
                                                    header("Location:".HOME_URL."manager/manage-gest.php");
                                                }
                                            } else {
                                                $_SESSION['delete'] = "<div id='message_error'>Erreur lors de la suppression</div>";
                                                header("Location:".HOME_URL."manager/manage-gest.php");
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





<?php
    // Include constants.php file
    // include('../config/constants.php');

    // // Check whether the id and image_name are set or not
    // // 'sn' is to get to the table compte in order to modify
    // // the status into 'Inactif'
    // if (isset($_GET['id']) AND isset($_GET['image']) AND isset($_GET['sn'])) {
    //     // echo "Cool";
    //     // Get the value and delete the user
    //     $id = $_GET['id'];
    //     $image_name = $_GET['image'];
    //     $id_compte = $_GET['sn'];

    //     // Remove the image if found
    //     if ($image_name != "") {
    //         // Image found and can be removed
    //         // Get the path
    //         $path = "../images/admin_gest_profiles/". $image_name;

    //         // Remove the image
    //         $remove = unlink($path);

    //         // If failed to remove the image, redirection to manage-gest page
    //         // with error message and stop the process
    //         if ($remove === false) {
    //             $_SESSION['remove_img'] = "<div id='message_error'>Une erreur est survenue</div>";
    //             header("Location:".HOME_URL."manager/manage-gest.php");
    //             // Stop the process of deleting the category
    //             die();
    //         }
    //     }

    //     // Delete data from the database
    //     $sql = "DELETE FROM gestionnaire WHERE id_gest = $id";

    //     // Execute the query
    //     $result = mysqli_query($conn, $sql);

    //     // Check whether the data is deleted or not
    //     if ($result == TRUE) {
    //         $sql2 = "UPDATE compte SET statut = 'Inactif' WHERE id = $id_compte";
    //         $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
    //         if ($result2 == TRUE) {
    //             $_SESSION['delete'] = "<div id='message_success'>Suppression effectuée avec succès</div>";
    //             header("Location:".HOME_URL."manager/manage-gest.php");
    //         } else {
    //             $_SESSION['delete'] = "<div id='message_error'>Échec: Problème avec le statut du compte associé</div>";
    //             header("Location:".HOME_URL."manager/manage-gest.php");
    //         }
    //     } else {
    //         $_SESSION['delete'] = "<div id='message_error'>Erreur lors de la suppression</div>";
    //         header("Location:".HOME_URL."manager/manage-gest.php");
    //     }

    // } else {
    //     header("Location:".HOME_URL."manager/manage-gest.php");
    // }
?>