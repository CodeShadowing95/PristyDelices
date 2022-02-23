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
                        </span> Ajouter un gestionnaire
                    </h3>
                </div>

                <?php
                    if (isset($_SESSION['add'])) {
                        echo $_SESSION['add']; #Displaying Session message
                        unset($_SESSION['add']); #Removing Session message
                        
                    }

                    if (isset($_SESSION['upload'])) {
                        echo $_SESSION['upload']; #Displaying Session message
                        unset($_SESSION['upload']); #Removing Session message
                        
                    }
                ?>
                
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Compte <i class="mdi mdi-alert-circle-outline" data-toggle="modal" data-target="#hint"></i></label>
                                        <select class="form-control" name="compte">

                                            <?php
                                                // display all the accounts from the database
                                                // SQL query to get the username and role from the database
                                                $sql = "SELECT * FROM compte WHERE statut = 'Inactif' AND role = 'Gestionnaire'";

                                                // Execute the query
                                                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                                                // Count rows to check whether we have accounts or not
                                                $count = mysqli_num_rows($result);


                                                // If count > 0, we have accounts available, else there's nothing to display
                                                if ($count > 0) {
                                                    // We have categories
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        // Get the details from the account
                                                        $id = $row['id'];
                                                        $username = $row['username'];
                                                        $role = $row['role'];
                                                        ?>
                                                        <option value="<?php echo $id; ?>"><?php echo $username; ?> --- <?php echo $role; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    // We do not have accounts registered
                                                    ?>
                                                    <option value="0">Pas de comptes gestionnaire disponibles</option>
                                                    <?php
                                                }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" name="nom" class="form-control" placeholder="Nom complet">
                                    </div>
                                    <div class="form-group">
                                        <label>Téléphone</label>
                                        <input type="number" name="telephone" class="form-control" placeholder="Numéro de téléphone">
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <input type="text" name="adresse" class="form-control" placeholder="Adresse">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Profil</label>
                                        <input type="file" name="img_profile" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" name="profil" class="form-control file-upload-info" disabled placeholder="Sélectionnez une photo de profil">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">Parcourir</button>
                                            </span>
                                        </div>
                                    </div>
                                    <button name="submit" class="btn btn-success mr-2" <?php echo ($count == 0) ? "disabled" : ""; ?>>Créer</button>
                                    <button class="btn btn-danger" name="cancel">Annuler</button>
                                </form>

                                <?php
                                // If the button cancel is clicked, redirection to manage-admin page
                                if (isset($_POST['cancel'])) {
                                    header("Location:".HOME_URL."manager/manage-gest.php");
                                }

                                if (isset($_POST['submit'])) {
                                    $compte = $_POST['compte'];
                                    $nom = addslashes($_POST['nom']);
                                    $telephone = $_POST['telephone'];
                                    $adresse = $_POST['adresse'];
                                    $email = $_POST['email'];

                                    // Check whether the image is uploaded or not
                                    if (isset($_FILES['img_profile']['name'])) {
                                        // Get all the details of the selected image
                                        $img_profile = $_FILES['img_profile']['name'];

                                        // Check whether the selected image is clicked or not
                                        // and upload the image only if the image is selected
                                        if ($img_profile != "") {
                                            // Image is selected
                                            // A. Rename the selected image
                                            // Get the extension of the selected image (jpg, png, gif, ...)
                                            $extension = end(explode('.', $img_profile));

                                            // Create new name for the Image
                                            $img_profile = "Profile-Manager-".rand(0000, 9999).".".$extension;

                                            // Get the source path and destination path
                                            $source_path = $_FILES['img_profile']['tmp_name'];
                                            $destination_path = "../images/admin_gest_profiles/".$img_profile;

                                            // B. Upload the image
                                            $upload = move_uploaded_file($source_path, $destination_path);

                                            // Check whether image is uploaded or not
                                            if ($upload == false) {
                                                // Redirect to add-admin page with error message
                                                $_SESSION['upload'] = "<div id='message_error'>Échec: L'image n'a pas pu être uploadé.</div>";
                                                header("Location:".HOME_URL."manager/add-gest.php");
                                                // Stop the process
                                                die();
                                            }
                                        }
                                    } else {
                                        // No image uploaded
                                        $img_profile = ""; //Set the default value as blank
                                    }

                                    // Insert into the database

                                    // SQL query to add food
                                    $sql2 = "INSERT INTO gestionnaire SET
                                        idCompte = $compte,
                                        nom = '$nom',
                                        profil = '$img_profile',
                                        contact = $telephone,
                                        adresse = '$adresse',
                                        email = '$email'
                                        -- statut = 'Actif'
                                    ";

                                    // Execute the query
                                    $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

                                    // Check whether data is inserted or not
                                    // Redirect to manage-admin page with message
                                    if ($result2 == TRUE) {
                                            // Data inserted successfully and status changed
                                            $sql3 = "UPDATE compte SET statut = 'Actif' WHERE id=$compte";
                                            $result3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));
                                            if ($result3 == TRUE) {
                                                $_SESSION['add'] = "<div id='message_success'>Opération effectuée avec succès</div>";
                                                header("Location:".HOME_URL."manager/manage-gest.php");
                                            } else {
                                                $_SESSION['add'] = "<div id='message_error'>Erreur</div>";
                                                header("Location:".HOME_URL."manager/add-gest.php");
                                            }
                                        } else {
                                        // Fail to insert the data
                                        $_SESSION['fail-add'] = "<div id='message_error'>Échec de l'opération </div>";
                                        header("Location:".HOME_URL."manager/manage-gest.php");
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
                            <p class="text-height-2">Si les comptes disponibles ne s'affichent pas dans la liste déroulante, vous ne pourrez pas créer de gestionnaires.
                                Et ça affichera <span class="font-weight-bold">Pas de comptes gestionnaire disponibles</span>. Il vous faut donc au préalable créer un 
                                compte dans la section "<span class="font-weight-bold">Comptes utilisateurs</span>" et utiliser ce compte pour l'associer au nouveau 
                                gestionnaire que vous voulez créer.</p>
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
