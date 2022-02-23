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
                            <i class="mdi mdi-cart"></i>
                        </span> Commandes enregistrées
                    </h3>

                    <!-- Session messages here -->
                    <?php
                        if (isset($_SESSION['remove-order'])) {
                            echo $_SESSION['remove-order'];
                            unset($_SESSION['remove-order']);
                        }

                        if (isset($_SESSION['delivered'])) {
                            echo $_SESSION['delivered'];
                            unset($_SESSION['delivered']);
                        }
                    ?>

                </div>
                <div class="row">

                    <?php
                        // Get all the orders from the database
                        $sql = "SELECT * FROM commande,produit,categorie WHERE commande.idProduit=produit.idProduit AND produit.idCategorie=categorie.id AND commande.statutCommande='En cours...' ORDER BY date_commande DESC";

                        $res = mysqli_query($conn, $sql);

                        if ($res == TRUE) {
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($row_data = mysqli_fetch_assoc($res)) {
                                    // Order details
                                    $order_id = $row_data['idCommande'];
                                    $nom_client = $row_data['nom_client'];
                                    $contact_client = $row_data['contact_client'];
                                    $email_client = $row_data['email_client'];
                                    $date_commande = $row_data['date_commande'];
                                    $quantite = $row_data['quantite'];
                                    $adresse_client = $row_data['adresse_client'];
                                    $total = $row_data['total'];
                                    $details = $row_data['details'];
                                    $statut = $row_data['statutCommande'];
                                    // Product details
                                    $produit = $row_data['nomProduit'];
                                    $image = $row_data['imageProduit'];
                                    // Category details
                                    $categorie = $row_data['nom'];
                                    ?>
                                    <div class="col-12 grid-margin" <?php if ($statut == "Livrée") {echo "style='display:none'";} ?>>
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Client: <?php echo $nom_client; ?></h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p class="card-text">Numéro de téléphone: <span class="font-weight-bold" style="color:#ff7800"><?php echo $contact_client; ?></span></p>
                                                        <p class="card-text">Email: <?php echo $email_client; ?></p>
                                                        <p class="card-text">Commande enregistrée le <?php echo $date_commande; ?></p>
                                                        <p class="card-text">Produit commandé: <span class="font-weight-bold" style="color:#ff7800"><?php echo $categorie; ?> - <?php echo $produit; ?></span></p>
                                                        <p class="card-text">Quantité: <span class="font-weight-bold" style="color:#ff7800"><?php echo $quantite; ?></span></p>
                                                        <p class="card-text">Adresse de livraison: <span class="font-weight-bold" style="color:#ff7800"><?php echo $adresse_client; ?></span></p>
                                                        <p class="card-text">Prix total: <span class="font-weight-bold" style="color:#ff7800">XAF <?php echo $total; ?>/-</span></p>
                                                        <p class="card-text">Détails: <br><?php echo $details; ?></p>
                                                    </div>
                                                    <div class="col-sm-6 text-right">
                                                        <?php
                                                            if ($image != "") {
                                                                ?>
                                                                <img src="<?php echo HOME_URL; ?>images/products/<?php echo $image; ?>" alt="<?php echo $produit; ?>" width="300">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <img src="<?php echo HOME_URL; ?>images/unknown.png" alt="Aucune image" width="300">
                                                                <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="id_order" value="<?php echo $order_id; ?>">
                                                    <button type="submit" class="btn btn-info mr-3" name="validate"><i class="mdi mdi-check-circle"></i> Valider la commande</button>
                                                    <button type="submit" class="btn btn-danger" name="remove"><i class="mdi mdi-delete-forever"></i> Annuler la commande</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="text-center">Aucune commande enregistrée</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
                <?php
                    // If the button "Annuler la commande" is clicked
                    if (isset($_POST['remove'])) {
                        $orderID = $_POST['id_order'];
                        $sql2 = "DELETE FROM commande WHERE idCommande=$orderID";

                        // var_dump($sql2);

                        $res2 = mysqli_query($conn, $sql2);

                        if ($res2 == TRUE) {
                            $_SESSION['remove-order'] = "<div id='message_success'>Commande supprimée</div>";
                            header("Location:".HOME_URL."manager/manage-orders.php");
                        } else {
                            $_SESSION['remove-order'] = "<div id='message_error'>Échec de l'opération</div>";
                            header("Location:".HOME_URL."manager/manage-orders.php");
                        }
                    }

                    // If the button "Valider la commande" is clicked
                    if (isset($_POST['validate'])) {
                        $orderID = $_POST['id_order'];
                        $sql3 = "UPDATE commande SET
                            statutCommande = 'Livrée'
                            WHERE idCommande=$orderID
                        ";

                        // var_dump($sql3);

                        $res3 = mysqli_query($conn, $sql3);

                        if ($res3 == TRUE) {
                            $_SESSION['delivered'] = "<div id='message_success'>Commande livrée</div>";
                            header("Location:".HOME_URL."manager/manage-orders.php");
                        } else {
                            $_SESSION['delivered'] = "<div id='message_error'>Échec de l'opération</div>";
                            header("Location:".HOME_URL."manager/manage-orders.php");
                        }
                    }
                ?>
            </div>
            <!-- partial:partials/_footer.html -->
            <?php
                include('partials/footer.php');
            ?>
            <!-- partial -->
        </div>
    </div>
</div>


<script src="assets/js/success.js"></script>
<script src="assets/js/error.js"></script>