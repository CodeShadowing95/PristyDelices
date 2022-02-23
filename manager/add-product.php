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
                            <i class="mdi mdi-plus-circle"></i>
                        </span> Ajouter un nouveau produit
                    </h3>
                </div>

                <!-- Session messages here -->
                <?php
                    if (isset($_SESSION['add'])) {
                        echo $_SESSION['add']; #Displaying Session message
                        unset($_SESSION['add']); #Removing Session message
                    }

                    if (isset($_SESSION['upload_error'])) {
                        echo $_SESSION['upload_error']; #Displaying Session message
                        unset($_SESSION['upload_error']); #Removing Session message
                    }

                    if (isset($_SESSION['unique'])) {
                        echo $_SESSION['unique']; #Displaying Session message
                        unset($_SESSION['unique']); #Removing Session message
                    }

                    if (isset($_SESSION['doublon'])) {
                        echo $_SESSION['doublon']; #Displaying Session message
                        unset($_SESSION['doublon']); #Removing Session message
                    }
                ?>

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Libellé du produit</label>
                                        <input type="text" name="nom" class="form-control" placeholder="Libellé du produit">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" placeholder="Détails concernant le produit" rows="4"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Prix unitaire</label>
                                        <input type="number" name="prix" class="form-control" placeholder="Prix du produit" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="food-image" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" name="food-img" class="form-control file-upload-info" disabled placeholder="Sélectionnez une image du produit">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-gradient-primary" type="button">Parcourir</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Catégorie</label>
                                        <select class="form-control form-control-lg" name="category" id="category_name">

                                            <?php
                                                $sql = "SELECT * FROM categorie";

                                                $result = mysqli_query($conn, $sql);

                                                $count = mysqli_num_rows($result);

                                                if ($count > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = $row['id'];
                                                        $nom = $row['nom'];
                                                        $image = $row['image'];
                                                        ?>
                                                        <option value="<?php echo $id; ?>"> <?php echo $nom; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option value="0">--Pas de catégories disponibles--</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- Statut Actif: le produit s'affiche dans le site web -->
                                    <!-- Statut Inactif: le produit ne s'affiche pas dans le site web -->
                                    <!-- <div class="form-group">
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
                                    </div> -->
                                    <!-- Fonctionnel Oui: On accède à la catégorie -->
                                    <!-- Fonctionnel Non: On n'accède pas à la catégorie -->
                                    <div class="form-group">
                                        <label>Fonctionnel</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="fonctionnel" value="Oui"> Oui </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="fonctionnel" value="Non"> Non </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-gradient-primary mr-2">Ajouter</button>
                                    <button class="btn btn-light" name="cancel">Annuler</button>
                                </form>

                                <?php
                                    // Check whether button "Cancel" is clicked
                                    if (isset($_POST['cancel'])) {
                                        header("Location:".HOME_URL."manager/manage-products.php");
                                    }

                                    // Check whether button "Submit" is clicked
                                    if (isset($_POST['submit'])) {
                                        // echo "Cool!";
                                        $category = $_POST['category'];
                                        $nom = addslashes($_POST['nom']);
                                        $description = addslashes($_POST['description']);
                                        $prix = $_POST['prix'];
                                        // $statut = $_POST['statut'];
                                        $fonctionnel = $_POST['fonctionnel'];

                                        // Verify if the name of the new product already exists in the database or not
                                        $test = "SELECT * FROM produit WHERE nomProduit='$nom'";
                                        $result_data = mysqli_query($conn, $test);
                                        $count_data = mysqli_num_rows($result_data);
                                        if ($count_data == 1) {
                                            $_SESSION['unique'] = "<div id='message_error'>Erreur: le produit existe déjà</div>";
                                            header("Location:".HOME_URL."manager/add-product.php");
                                        } else {
                                            // Get the image
                                            // A. Check whether the image is uploaded or not
                                            if (isset($_FILES['food-image']['name'])) {
                                                // Get the name of the selected image
                                                $food_name = $_FILES['food-image']['name'];
                                                // Check whether the image name is empty or not
                                                if ($food_name != "") {
                                                    // B. Rename the selected image
                                                    // Get the extension
                                                    $extension = end(explode('.', $food_name));

                                                    // Generate a new name for the selected image
                                                    $food_name = "PD-Product-".rand(0000, 9999).".".$extension;

                                                    // C. Save the image in a folder(already created)
                                                    // Get the source path of the image and destination path
                                                    // to save the image in the folder
                                                    $source_path = $_FILES['food-image']['tmp_name'];
                                                    $destination_path = "../images/products/".$food_name;

                                                    // D. Upload the image
                                                    // Action to save the image in the destination folder
                                                    $upload = move_uploaded_file($source_path, $destination_path);

                                                    // Check whether the image has been saved or not
                                                    if ($upload == false) {
                                                        $_SESSION['upload_error'] ="<div id='message_error'>Échec: La sauvegarde n'a pas réussi</div>";
                                                        header("Location:".HOME_URL."manager/manage-products.php");
                                                        // Stop the process
                                                        die();
                                                    }
                                                }   
                                            } else {
                                                // Image not uploaded, no value is returned
                                                $food_name = "";
                                            }

                                            // SQL query to add a product
                                            $sql2 = "INSERT INTO produit SET
                                                idCategorie = $category,
                                                nomProduit = '$nom',
                                                descriptionProduit = '$description',
                                                prix = $prix,
                                                imageProduit = '$food_name',
                                                -- statutProduit = '$statut',
                                                fonctionnelProduit = '$fonctionnel'
                                            ";

                                            // var_dump($sql2);

                                            $result2 = mysqli_query($conn, $sql2);

                                            if ($result2 == TRUE) {
                                                $sql3 = "UPDATE categorie SET statut = 'Actif' WHERE id = $category";
                                                $result3 = mysqli_query($conn, $sql3);
                                                if ($result3 == TRUE) {
                                                    $_SESSION['add'] = "<div id='message_success'>Produit ajouté avec succès</div>";
                                                    header("Location:".HOME_URL."manager/manage-products.php");
                                                } else {
                                                    $_SESSION['add'] = "<div id='message_error'>Erreur survenue. Veuillez réessayer.</div>";
                                                    header("Location:".HOME_URL."manager/add-product.php");
                                                }
                                            } else {
                                                $_SESSION['add'] = "<div id='message_error'>Échec de l'opération</div>";
                                                header("Location:".HOME_URL."manager/manage-products.php");
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
