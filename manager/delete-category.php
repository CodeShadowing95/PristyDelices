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
                        if (isset($_GET['id']) && isset($_GET['image'])) {
                            $id = $_GET['id'];
                            $image = $_GET['image'];
                            
                            $query = "SELECT nom FROM categorie WHERE id = $id";
                            $res = mysqli_query($conn, $query);
                            $count = mysqli_num_rows($res);
                            if ($count == 1) {
                                $data = mysqli_fetch_assoc($res);
                                $nom = $data['nom'];
                            }
                        }
                    ?>
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                            <i class="mdi mdi-account"></i>
                        </span> Suppression de la catégorie "<?php echo $nom; ?>"
                    </h3>

                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <label class="font-italic text-danger">
                                    <?php
                                        echo "Attention: Cette action est irréversible. La catégorie sera supprimée 
                                        définitivement, ainsi que tous les produits qui y sont associés.";
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
                                            header("Location:".HOME_URL."manager/manage-category.php");
                                        }


                                        if (isset($_POST['submit'])) {

                                            // If the image exists, delete it
                                            if ($image != "") {
                                                $pathToImage = "../images/category/".$image;
                                                $remove = unlink($pathToImage);

                                                if ($remove == false) {
                                                    $_SESSION['remove'] = "<div id='message_error'>Erreur survenue lors de la suppression de l'image'</div>";
                                                    header("Location:".HOME_URL."manager/manage-category.php");
                                                    die();
                                                }
                                            }

                                            // Delete the data
                                            $sql = "DELETE FROM categorie WHERE id = $id";
                                            // var_dump($sql);

                                            $result = mysqli_query($conn, $sql);
                                            // var_dump($result);

                                            if ($result == TRUE) {
                                                $_SESSION['delete'] = "<div id='message_success'>Suppression effectuée avec succès</div>";
                                                header("Location:".HOME_URL."manager/manage-category.php");
                                            } else {
                                                $_SESSION['delete'] = "<div id='message_error'>Échec de l'opération</div>";
                                                header("Location:".HOME_URL."manager/manage-category.php");
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
    // // Include constants.php file
    // include('../config/constants.php');

    // // Get the id and the image of the selected category
    // if (isset($_GET['id']) && isset($_GET['image'])) {
    //     $id = $_GET['id'];
    //     $image = $_GET['image'];

    //     // If the image exists in the folder, remove it
    //     if ($image != "") {
    //         $path = "../images/category/".$image;
    //         $remove = unlink($path);

    //         if ($remove == false) {
    //             $_SESSION['remove'] = "<div id='message_error'>Echec de l'opération</div>";
    //             header("Location:".HOME_URL."manager/manage-category.php");
    //             die();
    //         }
    //     }

    //     // Delete the data
    //     $sql = "DELETE FROM categorie WHERE id = $id";

    //     $result = mysqli_query($conn, $sql);

    //     if ($result == TRUE) {
    //         $_SESSION['delete'] = "<div id='message_success'>Suppression effectuée avec succès</div>";
    //         header("Location:".HOME_URL."manager/manage-category.php");
    //     } else {
    //         $_SESSION['delete'] = "<div id='message_error'>Échec de l'opération</div>";
    //         header("Location:".HOME_URL."manager/manage-category.php");
    //     }
    // } else {
    //     header("Location:".HOME_URL."manager/manage-category.php");
    // }
?>