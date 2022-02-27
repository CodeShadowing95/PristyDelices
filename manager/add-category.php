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
                            <i class="mdi mdi-folder-plus"></i>
                        </span> Ajouter une nouvelle catégorie
                    </h3>

                    <!-- Session messages here -->
                    <?php
                    
                        if (isset($_SESSION['upload'])) {
                            echo $_SESSION['upload'];
                            unset($_SESSION['upload']);
                        }

                        if (isset($_SESSION['add'])) {
                            echo $_SESSION['add'];
                            unset($_SESSION['add']);
                        }

                        if (isset($_SESSION['unique'])) {
                            echo $_SESSION['unique'];
                            unset($_SESSION['unique']);
                        }
                    ?>

                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Nom de la catégorie</label>
                                        <input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" placeholder="Détails concernant la catégorie" rows="4"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="img-category" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" name="cat-img" class="form-control file-upload-info" disabled placeholder="Sélectionnez une image de la catégorie">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-gradient-primary" type="button">Parcourir</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Statut</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="statut" value="Actif"> Actif </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="statut" value="Inactif"> Inactif </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-gradient-success mr-2">Créer</button>
                                    <button class="btn btn-danger" name="cancel">Annuler</button>
                                </form>

                                <?php
                                    // If the button "Cancel" is clicked, redirection to manage-category page
                                    if (isset($_POST['cancel'])) {
                                        header('Location:'.HOME_URL.'manager/manage-category.php');
                                    }

                                    // If the "Submit" button is clicked, get all the datas from the form
                                    if (isset($_POST['submit'])) {
                                        $nom = addslashes($_POST['nom']);
                                        $description = addslashes($_POST['description']);
                                        if (isset($_POST['statut'])) {
                                            $statut = $_POST['statut'];
                                        } else {
                                            $statut = "Inactif";
                                        }

                                        // Verify if the name of the new category already exists in the database or not
                                        $test = "SELECT * FROM categorie WHERE nom='$nom'";
                                        $result_data = mysqli_query($conn, $test);
                                        $count_data = mysqli_num_rows($result_data);
                                        if ($count_data == 1) {
                                            $_SESSION['unique'] = "<div id='message_error'>La catégorie existe déjà</div>";
                                            header("Location:".HOME_URL."manager/add-category.php");
                                        } else {
                                            // Check whether the image has been uploaded or not
                                            if (isset($_FILES['img-category']['name'])) {
                                                // Get the name of the selected image
                                                $img_category = $_FILES['img-category']['name'];

                                                // Check whether the image has been selected or not
                                                // and upload the image only if the image has been selected
                                                if ($img_category != "") {
                                                    // Image is selected
                                                    // Rename the selected image
                                                    // Get the extension of the selected image
                                                    $extension = end(explode('.', $img_category));

                                                    // Create new name for the image
                                                    $img_category = "PD-Category-".rand(0000, 9999).".".$extension;

                                                    // Save the image in the category folder
                                                    // Get the source path of the image and destination path
                                                    $source_path = $_FILES['img-category']['tmp_name'];
                                                    $destination_path = "../images/category/".$img_category;

                                                    // Upload the image
                                                    // Save the image in destination folder
                                                    $upload = move_uploaded_file($source_path, $destination_path);

                                                    // Check whether image has been saved in the destination folder
                                                    if ($upload == false) {
                                                        // Redirect to add-category withn session message
                                                        $_SESSION['upload'] = "<div id='message_error'>Échec: La sauvegarde n'a pas réussi</div>";
                                                        header("Location:".HOME_URL."manager/add-category.php");
                                                        // Stop the process
                                                        die();
                                                    }
                                                }
                                            } else {
                                                // Image not uploaded
                                                // Set the default value as blank
                                                $img_category = "";
                                            }

                                            // SQL query to add a new category
                                            $sql = "INSERT INTO categorie SET
                                                nom = '$nom',
                                                image = '$img_category',
                                                description = '$description',
                                                statut = '$statut'
                                            ";

                                            // Execute the query
                                            $result = mysqli_query($conn, $sql);

                                            // Check whether the data is inserted or not
                                            if ($result == TRUE) {
                                                // Data inserted successfully
                                                $_SESSION['add'] = "<div id='message_success'>Une nouvelle catégorie a été ajoutée</div>";
                                                header("Location:".HOME_URL."manager/manage-category.php");
                                            } else {
                                                // Data not inserted successfully
                                                $_SESSION['add'] = "<div id='message_error'>Échec de l'opération: Catégorie non ajoutée</div>";
                                                header("Location:".HOME_URL."manager/add-category.php");
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
