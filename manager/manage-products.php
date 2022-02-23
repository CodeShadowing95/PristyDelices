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
                            <i class="mdi mdi-view-list"></i>
                        </span> Tous les produits (Toutes catégories confondues)
                    </h3>

                    <!-- Pagination -->
                    <?php
                        // Determine on which page we are
                        if (isset($_GET['page']) && !empty($_GET['page'])) {
                            // strip_tags(paramters)) function tht strips a string from HTML, XML, and PHP tags
                            $currentPage = (int) strip_tags($_GET['page']);
                        } else {
                            $currentPage = 1;
                        }

                        // Get the number of articles in the database
                        $query = "SELECT count(*) AS Total FROM produit";
                        $result = mysqli_query($conn, $query);
                        $data = mysqli_fetch_assoc($result);
                        $count = $data['Total'];

                        // Calculate the number of pages
                        // 1. Set the number of articles per page
                        $eachPage = 20;

                        // 2. Get the total number of pages
                        $pages = ceil($count / $eachPage);

                        // Listing each 20 products from the first product
                        $firstItem = ($currentPage * $eachPage) - $eachPage;

                        // New SQL query with LIMIT parameters
                        $sql_query = "SELECT * FROM produit LEFT JOIN categorie ON produit.idCategorie=categorie.id LIMIT $firstItem, $eachPage";
                        $result_query = mysqli_query($conn, $sql_query);

                        // The serial number of the list of items
                        $sn = (($currentPage * $eachPage) - $eachPage) + 1;
                    ?>

                    <!-- Session messages here -->
                    <?php

                        if (isset($_SESSION['add'])) {
                            echo $_SESSION['add']; #Displaying Session message
                            unset($_SESSION['add']); #Removing Session message
                        }

                        if (isset($_SESSION['update'])) {
                            echo $_SESSION['update']; #Displaying Session message
                            unset($_SESSION['update']); #Removing Session message
                        }

                        if (isset($_SESSION['delete'])) {
                            echo $_SESSION['delete']; #Displaying Session message
                            unset($_SESSION['delete']); #Removing Session message
                        }

                        if (isset($_SESSION['upload'])) {
                            echo $_SESSION['upload']; #Displaying Session message
                            unset($_SESSION['upload']); #Removing Session message
                        }

                        if (isset($_SESSION['remove-error'])) {
                            echo $_SESSION['remove-error']; #Displaying Session message
                            unset($_SESSION['remove-error']); #Removing Session message
                        }

                        if (isset($_SESSION['remove'])) {
                            echo $_SESSION['remove']; #Displaying Session message
                            unset($_SESSION['remove']); #Removing Session message
                        }

                        if (isset($_SESSION['access'])) {
                            echo $_SESSION['access']; #Displaying Session message
                            unset($_SESSION['access']); #Removing Session message
                        }

                        if (isset($_SESSION['unique'])) {
                            echo $_SESSION['unique']; #Displaying Session message
                            unset($_SESSION['unique']); #Removing Session message
                        }

                    ?>

                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                            <a href="add-product.php" type="button" class="btn btn-info btn-icon-text">
                                <i class="mdi mdi-plus-circle btn-icon-prepend"></i> Nouveau produit </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item <?php if($currentPage == 1) {echo "disabled";} ?>">
                                                <a href="<?php echo HOME_URL; ?>manager/manage-products.php?page=<?php echo $currentPage - 1; ?>" class="page-link">Précédent</a>
                                            </li>
                                            <?php
                                                for ($page=1; $page <= $pages; $page++) { 
                                                    ?>
                                                    <li class="page-item <?php if ($currentPage == $page) {echo "active";} ?>">
                                                        <a class="page-link" href="<?php echo HOME_URL; ?>manager/manage-products.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                                    </li>
                                                    <?php
                                                }
                                            ?>
                                            <li class="page-item <?php if($currentPage == $pages) {echo "disabled";} ?>">
                                                <a href="<?php echo HOME_URL; ?>manager/manage-products.php?page=<?php echo $currentPage + 1; ?>" class="page-link">Suivant</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <input class="form-control mb-3" id="myInput" type="search" placeholder="Rechercher un produit...">
                                    <table class="table table-hover" id="countColTab">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th> Catégorie </th>
                                                <th> Image </th>
                                                <th> Nom </th>
                                                <th> Prix Unitaire </th>
                                                <!-- <th> Statut </th> -->
                                                <th> Fonctionnel </th>
                                                <th> Actions </th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">

                                            <?php
                                                // Get all the products from the database

                                                while ($row = mysqli_fetch_assoc($result_query)) {
                                                    // var_dump($row);
                                                    $id = $row['idProduit'];
                                                    $category = $row['nom'];
                                                    $image = $row['imageProduit'];
                                                    $nom = $row['nomProduit'];
                                                    $description = $row['descriptionProduit'];
                                                    $prix = $row['prix'];
                                                    // $statut = $row['statutProduit'];
                                                    $fonctionnel = $row['fonctionnelProduit'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sn++; ?></td>
                                                        <td><?php echo $category; ?></td>
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
                                                        <td><?php echo $nom; ?></td>
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
                                                            <h5 class="modal-title" id="product-<?php echo $id; ?>">Détails sur le produit <span class="font-weight-bold">"<?php echo $nom; ?>"</span></h5>
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
                                            ?>

                                            <?php
                                                
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center">
                                <li class="page-item <?php if($currentPage == 1) {echo "disabled";} ?>">
                                  <a href="<?php echo HOME_URL; ?>manager/manage-products.php?page=<?php echo $currentPage - 1; ?>" class="page-link">Précédent</a>
                                </li>
                                <?php
                                    for ($page=1; $page <= $pages; $page++) { 
                                        ?>
                                        <li class="page-item <?php if ($currentPage == $page) {echo "active";} ?>">
                                            <a class="page-link" href="<?php echo HOME_URL; ?>manager/manage-products.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                        </li>
                                        <?php
                                    }
                                ?>
                                <li class="page-item <?php if($currentPage == $pages) {echo "disabled";} ?>">
                                  <a href="<?php echo HOME_URL; ?>manager/manage-products.php?page=<?php echo $currentPage + 1; ?>" class="page-link">Suivant</a>
                                </li>
                              </ul>
                            </nav>
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