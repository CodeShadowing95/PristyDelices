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

        <?php
            if (isset($_GET['category_id']) && isset($_GET['category_name'])) {
                $id = $_GET['category_id'];
                $nom = $_GET['category_name'];
            }
        ?>

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white mr-2">
                            <i class="mdi mdi-food"></i>
                        </span> Produits de la catégorie <?php echo '"'.$nom.'"'; ?>
                    </h3>

                    <!-- Session messages here -->

                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <input class="form-control" id="myInput" type="search" placeholder="Rechercher..."><br>
                                    <table class="table table-hover" id="countColTab">
                                        <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Image </th>
                                            <th> Nom </th>
                                            <th> Prix Unitaire </th>
                                            <th> Fonctionnel </th>
                                            <th> Actions </th>
                                        </tr>
                                        </thead>
                                        <tbody id="myTable">

                                            <?php
                                                $sql = "SELECT * FROM produit,categorie WHERE produit.idCategorie=categorie.id AND id = $id";
                                                $res = mysqli_query($conn, $sql);
                                                $count = mysqli_num_rows($res);
                                                if ($count > 0) {
                                                    $sn = 1;
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                        $id = $row['idProduit'];
                                                        $image = $row['imageProduit'];
                                                        $nomProduit = $row['nomProduit'];
                                                        $description = $row['descriptionProduit'];
                                                        $prix = $row['prix'];
                                                        $fonctionnel = $row['fonctionnelProduit'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $sn++; ?></td>
                                                            <td>
                                                                <?php
                                                                    if ($image != "") {
                                                                        // Display image
                                                                        ?>
                                                                        <img src="<?php echo HOME_URL; ?>images/products/<?php echo $image; ?>" alt="">
                                                                        <?php
                                                                    } else {
                                                                        echo "<p style='color: #ff4757;'>Aucune image</p>";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $nomProduit; ?></td>
                                                            <td>XAF <?php echo $prix; ?></td>
                                                            <!-- <td>
                                                                <?php
                                                                    // if ($statut == "Actif") {
                                                                    //     echo "<label class='badge badge-info'>$statut</label>";
                                                                    // } else if ($statut == "Inactif") {
                                                                    //     echo "<label class='badge badge-primary'>$statut</label>";
                                                                    // }
                                                                ?>
                                                            </td> -->
                                                            <td>
                                                                <?php
                                                                    if ($fonctionnel == "Oui") {
                                                                        echo "<label class='badge badge-info'>$fonctionnel</label>";
                                                                    } else if ($fonctionnel == "Non") {
                                                                        echo "<label class='badge badge-primary'>$fonctionnel</label>";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?php echo HOME_URL; ?>manager/edit-product.php?id=<?php echo $id; ?>" role="button" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a>
                                                                <a href="<?php echo HOME_URL; ?>manager/delete-product.php?id=<?php echo $id; ?>&image=<?php echo $image; ?>" role="button" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i></a>
                                                                <a href="<?php echo HOME_URL; ?>manager/access-products.php?id=<?php echo $id; ?>" role="button" class="btn btn-sm <?php echo ($fonctionnel == "Oui") ? "btn-primary" : "btn-warning"; ?>"><i class="<?php echo ($fonctionnel == "Oui") ? "mdi mdi-lock" : "mdi mdi-lock-open"; ?>"></i></a>
                                                                <a href="#" data-toggle="modal" data-target="#product-<?php echo $id; ?>" role="button" class="btn btn-sm btn-dark"><i class="mdi mdi-eye"></i></a>
                                                            </td>
                                                        </tr>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="product-<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="product-<?php echo $id; ?>" aria-hidden="true">
                                                          <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <h5 class="modal-title" id="product-<?php echo $id; ?>">Détails sur le produit <span class="font-weight-bold">"<?php echo $nomProduit; ?>"</span></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                                </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <img src="<?php echo HOME_URL; ?>images/products/<?php echo $image; ?>" alt="" width="100%">
                                                                    </div>
                                                                </div><br>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <?php echo $description; ?>
                                                                    </div>
                                                                </div>
                                                              </div>
                                                              <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                                              </div>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="6">Aucun produit enregistré dans cette catégorie</td>
                                                    </tr>
                                                    <?php
                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
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


<script src="assets/js/success.js"></script>
<script src="assets/js/error.js"></script>