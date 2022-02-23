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
                            <i class="mdi mdi-folder-multiple"></i>
                        </span> Catégories
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
                        $query = "SELECT count(*) AS Total FROM categorie";
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
                        $sql_query = "SELECT * FROM categorie LIMIT $firstItem, $eachPage";
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
                        
                        if (isset($_SESSION['edit'])) {
                            echo $_SESSION['edit']; #Displaying Session message
                            unset($_SESSION['edit']); #Removing Session message
                        }
                        
                        if (isset($_SESSION['remove'])) {
                            echo $_SESSION['remove']; #Displaying Session message
                            unset($_SESSION['remove']); #Removing Session message
                        }
                        
                        if (isset($_SESSION['delete'])) {
                            echo $_SESSION['delete']; #Displaying Session message
                            unset($_SESSION['delete']); #Removing Session message
                        }

                        if (isset($_SESSION['doublon'])) {
                            echo $_SESSION['doublon'];
                            unset($_SESSION['doublon']);
                        }
                    ?>

                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                            <a href="add-category.php" type="button" class="btn btn-info btn-icon-text">
                                <i class="mdi mdi-folder-plus btn-icon-prepend"></i> Nouvelle catégorie </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                      <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <input class="form-control" id="myInput" type="search" placeholder="Rechercher une catégorie..."><br>
                                    <table class="table table-hover" id="countColTab">
                                        <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Image </th>
                                            <th> Nom </th>
                                            <th> Description </th>
                                            <th> Statut </th>
                                            <th> Actions </th>
                                            <!-- <th> Fonctionnel </th> -->
                                        </tr>
                                        </thead>
                                        <tbody id="myTable">

                                            <?php
                                                $count = mysqli_num_rows($result_query);

                                                if ($count > 0) {
                                                    while ($row = mysqli_fetch_assoc($result_query)) {
                                                        $id = $row['id'];
                                                        $nom = $row['nom'];
                                                        $image = $row['image'];
                                                        $description = $row['description'];
                                                        $statut = $row['statut'];
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $sn++; ?></td>
                                                            <td>
                                                                <?php
                                                                    if ($image != "") {
                                                                        // Display the image
                                                                        ?>
                                                                        <img src="<?php echo HOME_URL;?>/images/category/<?php echo $image; ?>" alt="Catégorie">
                                                                        <?php
                                                                    } else {
                                                                        echo "<p style='color: #ff4757;'>Aucune image</p>";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $nom; ?></td>
                                                            <td><?php echo substr($description, 0, 50)."..."; ?></td>
                                                            <td>
                                                                <?php
                                                                    if ($statut == "Actif") {
                                                                        echo "<label class='badge badge-info'>$statut</label>";
                                                                    } else if ($statut == "Inactif") {
                                                                        echo "<label class='badge badge-primary'>$statut</label>";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?php echo HOME_URL; ?>manager/edit-category.php?id=<?php echo $id; ?>" role="button" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a>
                                                                <a href="<?php echo HOME_URL; ?>manager/delete-category.php?id=<?php echo $id; ?>&image=<?php echo $image; ?>" role="button" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i></a>
                                                                <a href="#" role="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#category-<?php echo $id; ?>"><i class="mdi mdi-eye"></i></a>
                                                                <a href="<?php echo HOME_URL; ?>manager/status-category.php?id=<?php echo $id; ?>" role="button" class="btn btn-sm <?php echo ($statut == "Actif") ? "btn-dark" : "btn-light"; ?>"><?php echo ($statut == "Actif") ? "<i class='mdi mdi-lock'></i>" : "<i class='mdi mdi-lock-open'></i>"; ?></a>
                                                            </td>
                                                        </tr>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="category-<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="category-<?php echo $id; ?>" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <h5 class="modal-title" id="category-<?php echo $id; ?>">Détails sur la catégorie <span class="font-weight-bold">"<?php echo $nom; ?>"</span></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <img src="<?php echo HOME_URL; ?>images/category/<?php echo $image; ?>" alt="" width="100%">
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
                                                }
                                            ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <nav aria-label="Page navigation example">
                              <ul class="pagination justify-content-center">
                                <li class="page-item <?php if($currentPage == 1) {echo "disabled";} ?>">
                                  <a href="<?php echo HOME_URL; ?>manager/manage-category.php?page=<?php echo $currentPage - 1; ?>" class="page-link">Précédent</a>
                                </li>
                                <?php
                                    for ($page=1; $page <= $pages; $page++) { 
                                        ?>
                                        <li class="page-item <?php if ($currentPage == $page) {echo "active";} ?>">
                                            <a class="page-link" href="<?php echo HOME_URL; ?>manager/manage-category.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                        </li>
                                        <?php
                                    }
                                ?>
                                <li class="page-item <?php if($currentPage == $pages) {echo "disabled";} ?>">
                                  <a href="<?php echo HOME_URL; ?>manager/manage-category.php?page=<?php echo $currentPage + 1; ?>" class="page-link">Suivant</a>
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