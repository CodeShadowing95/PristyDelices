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
                        </span> Modifications sur le produit
                    </h3>
                </div>

                <!-- Session messages here -->
                <?php
                    if (isset($_SESSION['doublon'])) {
                        echo $_SESSION['doublon']; #Displaying Session message
                        unset($_SESSION['doublon']); #Removing Session message
                    }
                ?>

                <?php
                if (isset($_GET['id'])) {
                    // Get the id of th product
                    $id = $_GET['id'];

                    $sql = "SELECT * FROM produit WHERE idProduit = $id";

                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);

                    if ($count == 1) {
                        $row = mysqli_fetch_assoc($res);

                        $id_food = $row['idProduit'];
                        $categorie = $row['idCategorie'];
                        $imageProduit = $row['imageProduit'];
                        $nomProduit = $row['nomProduit'];
                        $descriptionProduit = $row['descriptionProduit'];
                        $prix = $row['prix'];
                        $fonctionnel = $row['fonctionnelProduit'];
                    } else {
                        header("Location:".HOME_URL."manager/manage-products.php");
                    }
                }
                ?>

                <!-- Code for the redirection to the page of the selected category -->
                <?php
                    // $query = "SELECT * FROM categorie,produit WHERE categorie.id=produit.idCategorie AND nomProduit='$nomProduit'";
                    // $data_res = mysqli_query($conn, $query);
                    // $data_count = mysqli_num_rows($data_res);
                    // if ($data_count == 1) {
                    //     $data_row = mysqli_fetch_assoc($data_res);
                    //     $idCategory = $data_row['id'];
                    //     $nameCategory = $data_row['nom'];
                    // }
                ?>

                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Libellé du produit</label>
                                        <input type="text" name="nom" class="form-control" value="<?php echo $nomProduit; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" rows="4"><?php echo $descriptionProduit; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Prix unitaire</label>
                                        <input type="number" name="prix" class="form-control" value="<?php echo $prix; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Image actuelle</label>
                                        <?php
                                        if ($imageProduit != "") {
                                            // Image available
                                            ?>
                                            <p><img src="<?php echo HOME_URL; ?>images/products/<?php echo $imageProduit; ?>" alt="" width="150px"></p>
                                            <?php
                                        } else {
                                            // Image not available
                                            echo "<span style='color: #ff4757;'>Aucune image</span>";
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-danger font-weight-bold">*** Attention: La capacité de la nouvelle image doit être inférieure à 2 Mo ***</label>
                                    </div>
                                    <div class="form-group">
                                        <label>Nouvelle image du produit</label>
                                        <input type="file" name="new-food-image" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" name="food-img" class="form-control file-upload-info" disabled placeholder="Sélectionnez une nouvelle image du produit">
                                            <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-gradient-primary" type="button">Parcourir</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Catégorie</label>
                                        <select class="form-control form-control-lg" name="categorie" id="category_name">

                                            <?php
                                                $sql2 = "SELECT * FROM categorie";

                                                $result2 = mysqli_query($conn, $sql2);

                                                $count2 = mysqli_num_rows($result2);

                                                if ($count2 > 0) {
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                        $categoryID = $row2['id'];
                                                        $nom = $row2['nom'];
                                                        ?>
                                                        <option <?php if($categorie == $categoryID) { echo 'selected'; }?> value="<?php echo $categoryID; ?>"> <?php echo $nom; ?></option>
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
                                    <!-- Fonctionnel Oui: On accède à la catégorie -->
                                    <!-- Fonctionnel Non: On n'accède pas à la catégorie -->
                                    <div class="form-group">
                                        <label>Fonctionnel</label>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                <label class="form-check-label">
                                                    <input <?php if($fonctionnel == "Oui") { echo "checked";} ?> type="radio" class="form-check-input" name="fonctionnel" value="Oui"> Oui </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input <?php if($fonctionnel == "Non") { echo "checked";} ?> type="radio" class="form-check-input" name="fonctionnel" value="Non"> Non </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                    <button type="submit" name="submit" class="btn btn-gradient-primary mr-2">Confirmer les changements</button>
                                    <button class="btn btn-light" name="cancel">Annuler</button>
                                </form>

                                <?php
                                    if (isset($_POST['cancel'])) {
                                        header("Location:".HOME_URL."manager/manage-products.php");
                                    }

                                    if (isset($_POST['submit'])) {
                                        // echo "Cool!";
                                        // Get the datas from the form
                                        $nom = addslashes($_POST['nom']);
                                        $description = addslashes($_POST['description']);
                                        $prix = $_POST['prix'];
                                        $categorie = $_POST['categorie'];
                                        $fonctionnel = $_POST['fonctionnel'];

                                        // Verify if the other name of the category, is unique in the database or not
                                        $test = "SELECT * FROM produit WHERE nomProduit NOT LIKE '$nomProduit'";
                                        $result_test = mysqli_query($conn, $test);
                                        $count_data = mysqli_num_rows($result_test);
                                        while ($get_data = mysqli_fetch_assoc($result_test)) {
                                            $prod_name = $get_data['nomProduit'];
                                            if ($prod_name == $nom) {
                                                $_SESSION['doublon'] = "<div id='message_error'>Erreur: Le nom du produit existe déjà</div>";
                                                header("Location:".HOME_URL."manager/edit-product.php?id=".$id);
                                                die();
                                            }
                                        }

                                        // Image
                                        // Check whether the input type file got the name of the image or not
                                        if (isset($_FILES['new-food-image']['name'])) {
                                            $newImageName = $_FILES['new-food-image']['name'];

                                            if ($newImageName != "") {
                                                // Image available
                                                // Get the extension of the current image
                                                $extension = end(explode(".", $newImageName));
                                                // Rename it
                                                $newImageName = "PD-Product-".rand(0000, 9999).".".$extension;
                                                // Get the source path and destination path
                                                $source_path = $_FILES['new-food-image']['tmp_name'];
                                                $destination_path = "../images/products/".$newImageName;
                                                // Upload the image
                                                $upload = move_uploaded_file($source_path, $destination_path);
                                                // Check whether the image has been uploaded successfully or not
                                                if ($upload == false) {
                                                    $_SESSION['upload'] = "<div id='message_error'>Erreur: La nouvelle image n'a pu être uploadé</div>";
                                                    header("Location:".HOME_URL."manager/edit-product.php");
                                                    die();
                                                }

                                                // Remove the current image
                                                if ($imageProduit != "") {
                                                    // Get the path of the current image
                                                    $pathCurrentImage = "../images/products/".$imageProduit;

                                                    // Remove the image
                                                    $removeImage = unlink($pathCurrentImage);

                                                    // Check whether the image has been removed successfully or not
                                                    if ($removeImage == false) {
                                                        $_SESSION['remove-error'] = "<div id='message_error'>Problèmes rencontrés avec l'image</div>";
                                                        header("Location:".HOME_URL."manager/edit-product.php");
                                                        die();
                                                    }
                                                }
                                            } else {
                                                // When no image is selected, keep the current image
                                                $newImageName = $imageProduit;
                                            }
                                        } else {
                                            $newImageName = $imageProduit;
                                        }


                                        // Update product
                                        $sql3 = "UPDATE produit SET
                                            idCategorie = $categorie,
                                            nomProduit = '$nom',
                                            descriptionProduit = '$description',
                                            prix = $prix,
                                            imageProduit = '$newImageName',
                                            fonctionnelproduit = '$fonctionnel'
                                            WHERE idProduit = $id
                                        ";

                                        // var_dump($sql3);

                                        $result3 = mysqli_query($conn, $sql3);

                                        // var_dump($result3);

                                        if ($result3 == TRUE) {
                                            $_SESSION['update'] = "<div id='message_success'>Modification effectuée</div>";
                                            // header("Location:".HOME_URL."manager/PD-ByCategory.php?category_id=".$idCategory."&category_name=".$nameCategory);
                                            header("Location:".HOME_URL."manager/manage-products.php");
                                        } else {
                                            $_SESSION['update'] = "<div id='message_error'>Erreur lors de la modification</div>";
                                            // header("Location:".HOME_URL."manager/PD-ByCategory.php?category_id=".$idCategory."&category_name=".$nameCategory);
                                            header("Location:".HOME_URL."manager/manage-products.php");
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
