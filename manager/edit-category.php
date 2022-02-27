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
                            <i class="mdi mdi-lead-pencil"></i>
                        </span> Modifier la catégorie
                    </h3>

                    <!-- Session messages here -->
                    <?php
                        if (isset($_SESSION['upload_error'])) {
                            echo $_SESSION['upload_error'];
                            unset($_SESSION['upload_error']);
                        }

                        if (isset($_SESSION['remove_error'])) {
                            echo $_SESSION['remove_error'];
                            unset($_SESSION['remove_error']);
                        }

                        if (isset($_SESSION['doublon'])) {
                            echo $_SESSION['doublon'];
                            unset($_SESSION['doublon']);
                        }
                    ?>

                    <?php
                    if (isset($_GET['id'])) {
                        // Get the id of the selected category
                        $id = $_GET['id'];
                        // SQL query to get the category
                        $sql_query = "SELECT * FROM categorie WHERE id = $id";
                        // Execute the query
                        $result = mysqli_query($conn, $sql_query);
                        // Count rows
                        $count = mysqli_num_rows($result);

                        if ($count == 1) {
                            // Check whether the category is available in the database
                            $data = mysqli_fetch_assoc($result);

                            // Get the values of the selected category
                            $nom = $data['nom'];
                            $image = $data['image'];
                            $description = $data['description'];
                            $statut = $data['statut'];
                        }
                    } else {
                        // Redirection
                        header("Location:".HOME_URL."manager/manage-category.php");
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
                                        <input type="text" name="nom" class="form-control" value="<?php echo $nom; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" rows="4"><?php echo $description; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image de la catégorie selectionnée: </label>
                                        <?php
                                        if ($image == "") {
                                            // Image not available
                                            echo "<span style='color: #ff4757;'>Aucune image</span>";
                                        } else {
                                            // Image available
                                            ?>
                                            <p><img src="<?php echo HOME_URL; ?>images/category/<?php echo $image; ?>" alt="Catégorie-Produit" width="150px"></p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-danger font-weight-bold">*** Attention: La capacité de la nouvelle image doit être inférieure à 2 Mo ***</label>
                                    </div>
                                    <div class="form-group">
                                        <label>Nouvelle image de la catégorie</label>
                                        <input type="file" name="new-img-category" class="file-upload-default">
                                        <div class="input-group col-xs-12">
                                            <input type="text" name="cat-img" class="form-control file-upload-info" disabled placeholder="Sélectionnez la nouvelle image de la catégorie">
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
                                                    <input type="radio" class="form-check-input" name="statut" value="Actif" <?php if($statut == 'Actif') {echo 'checked';} ?>> Actif </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="statut" value="Inactif" <?php if($statut == 'Inactif') {echo 'checked';} ?>> Inactif </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    <input type="hidden" name="img_category_name" value="<?php echo $image; ?>">
                                    <button type="submit" name="submit" class="btn btn-gradient-success mr-2">Confirmer les changements</button>
                                    <button class="btn btn-danger" name="cancel">Annuler</button>
                                </form>

                                <?php
                                    if (isset($_POST['cancel'])) {
                                        header("Location:".HOME_URL."manager/manage-category.php");
                                    }

                                    if (isset($_POST['submit'])) {
                                        // Get all the details from the form
                                        $nom_category = addslashes($_POST['nom']);
                                        $img_category = $_POST['img_category_name'];
                                        $desc_category = addslashes($_POST['description']);
                                        $status_category = $_POST['statut'];

                                        // Verify if the other name of the category, is unique in the database or not
                                        $test = "SELECT * FROM categorie WHERE nom NOT LIKE '$nom'";
                                        $result_test = mysqli_query($conn, $test);
                                        $count_data = mysqli_num_rows($result_test);
                                        while ($get_data = mysqli_fetch_assoc($result_test)) {
                                            $cat_name = $get_data['nom'];
                                            if ($cat_name == $nom_category) {
                                                $_SESSION['doublon'] = "<div id='message_error'>Erreur: Le nom de la catégorie existe déjà</div>";
                                                header("Location:".HOME_URL."manager/edit-category.php?id=".$id);
                                                die();
                                            }
                                        }
                                        
                                        if (isset($_FILES['new-img-category']['name'])) {
                                            $new_image_name = $_FILES['new-img-category']['name'];

                                            if ($new_image_name != "") {
                                                $extension = end(explode('.', $new_image_name));

                                                $new_image_name = "PD-Category-".rand(0000, 9999).".".$extension;

                                                $source_path = $_FILES['new-img-category']['tmp_name'];

                                                $destination_path = "../images/category/".$new_image_name;

                                                $upload = move_uploaded_file($source_path, $destination_path);

                                                if ($upload == false) {
                                                    $_SESSION['upload_error'] = "<div id='message_error'>Erreur: L'image n'a pas pu être uploadé</div>";
                                                    header("Location:".HOME_URL."manager/edit-category.php");
                                                    die();
                                                }

                                                if ($img_category != "") {
                                                    $remove_img_category_path = "../images/category/".$img_category;

                                                    $remove_img = unlink($remove_img_category_path);

                                                    if ($remove_img == false) {
                                                        $_SESSION['remove_error'] = "<div id='message_error'>Échec de suppression de l'image</div>";
                                                        header("Location:".HOME_URL."manager/edit-category.php");
                                                        die();
                                                    }
                                                }
                                            } else {
                                                $new_image_name = $img_category;
                                            }
                                        } else {
                                            $new_image_name = $img_category;
                                        }

                                        // Update the category
                                        $sql = "UPDATE categorie SET
                                            nom = '$nom_category',
                                            image = '$new_image_name',
                                            description = '$desc_category',
                                            statut = '$status_category'
                                            WHERE id = $id;
                                        ";

                                        // var_dump($sql);

                                        $get_result = mysqli_query($conn, $sql);

                                        if ($get_result == TRUE) {
                                            $_SESSION['edit'] = "<div id='message_success'>Catégorie modifiée avec succès</div>";
                                            header("Location:".HOME_URL."manager/manage-category.php");
                                        } else {
                                            $_SESSION['edit'] = "<div id='message_error'>Erreur survenue lors de la modification</div>";
                                            header("Location:".HOME_URL."manager/manage-category.php");
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