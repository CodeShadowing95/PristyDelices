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
                        </span> Éditer gestionnaire
                    </h3>
                </div>

                <?php
                    if (isset($_SESSION['remove-failed'])) {
                        echo $_SESSION['remove-failed']; #Displaying Session message
                        unset($_SESSION['remove-failed']); #Removing Session message
                        
                    }

                    if (isset($_SESSION['upload'])) {
                        echo $_SESSION['upload']; #Displaying Session message
                        unset($_SESSION['upload']); #Removing Session message
                        
                    }

                    if (isset($_SESSION['change-password'])) {
                        echo $_SESSION['change-password']; #Displaying Session message
                        unset($_SESSION['change-password']); #Removing Session message
                        
                    }
                ?>

                <?php
                    // Check whether the id is set or not
                    if (isset($_GET['id'])) {
                        // Get the id of the selected user
                        $id = $_GET['id'];

                        // Get all the details related to this user
                        $sql = "SELECT * FROM gestionnaire LEFT JOIN compte ON gestionnaire.idCompte = compte.id WHERE id_gest = $id";

                        // Execute the query
                        $res = mysqli_query($conn, $sql);

                        // Check whether the data is available in the database or not
                        $row_data = mysqli_fetch_assoc($res);

                        // Get the values
                        $account_id = $_SESSION['compte'];
                        $id = $row_data['id_gest'];
                        $nom = $row_data['nom'];
                        $profil_courant = $row_data['profil'];
                        $contact = $row_data['contact'];
                        $adresse = $row_data['adresse'];
                        $email = $row_data['email'];
                        $role = $row_data['role'];
                    } else {
                        // Redirection to manage-gest page
                        header("Location:".HOME_URL."manager/manage-gest.php");
                    }

                ?>

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
                                    <?php
                                        if ($role != "Gestionnaire") {
                                            ?>
                                            <h4 class="card-title mb-4" style="color:#ff7800">Informations du compte</h4>
                                            <div class="form-group">
                                                <label>Nom d'utilisateur</label>
                                                <input type="text" name="username" class="form-control" value="<?php echo $_SESSION['user']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Nouveau mot de passe</label>
                                                <input type="password" name="newPassword" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Confirmer le nouveau mot de passe</label>
                                                <input type="password" name="confirmPassword" class="form-control">
                                            </div>
                                            <?php
                                        }
                                    ?>
                                    <h4 class="card-title mb-4" style="color:#ff7800">Données personnelles</h4>
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" name="nom" class="form-control" value="<?php echo $nom ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input type="text" name="contact" class="form-control" value="<?php echo $contact ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <input type="text" name="adresse" class="form-control" value="<?php echo $adresse ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" value="<?php echo $email ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Photo de profil courante: </label>
                                        <?php
                                        if ($profil_courant == "") {
                                            // Image not available
                                            echo "<span style='color: #ff4757;'>Aucune image</span>";
                                        } else {
                                            // Image available
                                            ?>
                                            <p><img src="<?php echo HOME_URL; ?>images/admin_gest_profiles/<?php echo $profil_courant; ?>" alt="Profil" width="150px"></p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-danger font-weight-bold">*** Attention: La capacité de la nouvelle image doit être inférieure à 2 Mo ***</label>
                                    </div>
                                    <div class="form-group">
                                        <label>Modifier la photo de profil</label>
                                        <input type="file" name="new_img_profile" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" name="profil" class="form-control file-upload-info" disabled placeholder="Sélectionnez une nouvelle photo de profil">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button">Parcourir</button>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="profil_courant" value="<?php echo $profil_courant; ?>">
                                    <button type="submit" name="submit" class="btn btn-success mr-2">Confirmer les changements</button>
                                    <button class="btn btn-danger" name="cancel">Annuler</button>
                                </form>

                                <?php
                                    // If the button cancel is clicked, redirection to manage-gest page
                                    if (isset($_POST['cancel'])) {
                                        if ($role == "Super-administrateur") {
                                            // Redirect to profile page
                                            header("Location:".HOME_URL."manager/profile.php");
                                        } else {
                                            header("Location:".HOME_URL."manager/manage-gest.php");
                                        }
                                    }
                                    if (isset($_POST['submit'])) {
                                        // Details from the account
                                        $username = addslashes($_POST['username']);
                                        $newPassword = $_POST['newPassword'];
                                        $confirmPassword = $_POST['confirmPassword'];
                                        // Get all the details from the form
                                        $id = $_POST['id'];
                                        $nom = $_POST['nom'];
                                        $profil_courant = $_POST['profil_courant'];
                                        $contact = $_POST['contact'];
                                        $adresse = $_POST['adresse'];
                                        $email = $_POST['email'];

                                        // Check whether the passwords are equal
                                        if ($newPassword == $confirmPassword) {
                                            $newPassword = md5($newPassword);
                                        } else {
                                            $_SESSION['change-password'] = "<div id='message_error'>Erreur: les mots de passe ne concordent pas</div>";
                                            // Redirect to profile page
                                            header("Location:".HOME_URL."manager/edit-gest.php.php");
                                            die();
                                        }

                                        if (isset($_FILES['new_img_profile']['name'])) {
                                            // echo "Cool";
                                            $new_image_name = $_FILES['new_img_profile']['name'];

                                            // Check whether the file is available or not
                                            if ($new_image_name != "") {
                                                // Image available
                                                // Rename the image
                                                $extension = end(explode('.', $new_image_name)); //Get the extension of the image
                                                $new_image_name = "Profile-Manager-".rand(0000, 9999).".".$extension;

                                                // Get the source path and destination path
                                                $source_path = $_FILES['new_img_profile']['tmp_name'];
                                                $destination_path = "../images/admin_gest_profiles/".$new_image_name;

                                                // Upload the new image
                                                $upload = move_uploaded_file($source_path, $destination_path);

                                                // Check whether the image is uploaded or not
                                                if ($upload == false) {
                                                    // Fail to upload the new image
                                                    $_SESSION['upload'] = "<div id='message_error'>Échec: L'image n'a pas être uploadé.</div>";
                                                    // Redirect to edit-gest page with error message
                                                    header("Location:".HOME_URL."manager/edit-gest.php");
                                                    // Stop the process
                                                    die();
                                                }

                                                // If the current_image exists, we remove it and replace by the new image
                                                if ($profil_courant != "") {
                                                    $remove_path = "../images/admin_gest_profiles/".$profil_courant;

                                                    // Remove the current profile image
                                                    $remove = unlink($remove_path);

                                                    // Check whether the image is removed or not
                                                    if ($remove == false) {
                                                        // Fail to remove the current profile image
                                                        $_SESSION['remove-failed'] = "<div id='message_error'>Échec: Problèmes rencontrés avec l'image</div>";
                                                        header("Location:".HOME_URL."manager/edit-gest.php");
                                                        // Stop the process
                                                        die();
                                                    }
                                                }
                                            } else {
                                                // Default image when no image is selected
                                                $new_image_name = $profil_courant;
                                            }
                                        } else {
                                            // Default image when button type=file is not clicked
                                            $new_image_name = $profil_courant;
                                        }


                                        // Update the user in the database
                                        $sql2 = "UPDATE gestionnaire SET
                                            nom = '$nom',
                                            profil = '$new_image_name',
                                            contact = $contact,
                                            adresse = '$adresse',
                                            email = '$email'
                                            WHERE id_gest = $id;
                                        ";

                                        // Execute the query
                                        $res2 = mysqli_query($conn, $sql2);

                                        // Check whether the query is executed or not
                                        if ($res2 == TRUE) {
                                            // Query executed successfully
                                            $_SESSION['update'] = "<div id='message_success'>Modification effectuée avec succès</div>";
                                            if ($role == "Super-administrateur") {
                                                $sql3 = "UPDATE compte SET
                                                    username = '$username',
                                                    mot_de_passe = '$newPassword'
                                                    WHERE id = $account_id
                                                ";

                                                // var_dump($sql3);

                                                $res3 = mysqli_query($conn, $sql3);

                                                $_SESSION['user'] = $username;
                                                $_SESSION['nom'] = $nom;
                                                $_SESSION['profil'] = $new_image_name;
                                                $_SESSION['contact'] = $contact;
                                                $_SESSION['adresse'] = $adresse;
                                                $_SESSION['email'] = $email;
                                                // Redirect to profile page
                                                header("Location:".HOME_URL."manager/profile.php");
                                            } else {
                                                // Redirect to manage-account page
                                                header("Location:".HOME_URL."manager/manage-gest.php");
                                            }
                                        } else {
                                            // Redirection to manage-account page with session message
                                            $_SESSION['update'] = "<div id='message_error'>Échec de l'opération</div>";
                                            header("Location:".HOME_URL."manager/manage-gest.php");
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