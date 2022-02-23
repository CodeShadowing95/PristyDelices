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
                            <i class="mdi mdi-account-multiple"></i>
                        </span> Gestionnaires des produits
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
                        $query = "SELECT count(*) AS Total FROM gestionnaire";
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
                        $sql_query = "SELECT * FROM gestionnaire LEFT JOIN compte ON gestionnaire.idCompte = compte.id WHERE compte.id AND idCompte NOT LIKE 1 ORDER BY username ASC LIMIT $firstItem, $eachPage";
                        $result_query = mysqli_query($conn, $sql_query);

                        // The serial number of the list of items
                        $sn = (($currentPage * $eachPage) - $eachPage) + 1;
                    ?>

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

                      if (isset($_SESSION['fail-add'])) {
                          echo $_SESSION['fail-add']; #Displaying Session message
                          unset($_SESSION['fail-add']); #Removing Session message
                      }
                    ?>

                    <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                        <a href="add-gest.php" type="button" class="btn btn-info btn-icon-text">
                            <i class="mdi mdi-account-plus btn-icon-prepend"></i> Nouveau gestionnaire </a>
                        </li>
                    </ul>
                    </nav>
                </div>
                <div class="row">
                  <div class="col-12 grid-margin">
                    <div class="card">
                      <div class="card-body">
                        <!-- <h4 class="card-title">Administrateurs Actifs</h4> -->
                        
                        <div class="table-responsive">
                          <input class="form-control" id="myInput" type="search" placeholder="Rechercher un(e) gestionnaire...">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <!-- <th> # </th> -->
                                <th> Profil </th>
                                <th> Nom </th>
                                <th> Contact </th>
                                <th> Adresse </th>
                                <th> Email </th>
                                <th> Nom d'utilisateur </th>
                                <th> Actions </th>
                              </tr>
                            </thead>
                            <tbody id="myTable">

                              <?php
                                // Count rows
                                $count = mysqli_num_rows($result_query);

                                // Check the number of rows
                                if ($count > 0) {
                                  // The datas exist in the database
                                  // $sn = 1;
                                  while ($row = mysqli_fetch_assoc($result_query)) {
                                    $id = $row['id_gest'];
                                    $idCompte = $row['idCompte'];
                                    $profil = $row['profil'];
                                    $nom = $row['nom'];
                                    $contact = $row['contact'];
                                    $adresse = $row['adresse'];
                                    $email = $row['email'];
                                    $username = $row['username'];
                                    ?>

                                    <tr>
                                        <!-- <td><?php //echo $sn++; ?></td> -->
                                        <td>
                                          <?php
                                            if ($profil != "") {
                                              // Display the image profile
                                              ?>
                                              <img src="<?php echo HOME_URL; ?>images/admin_gest_profiles/<?php echo $profil; ?>" class="mr-2" alt="image">
                                              <?php
                                            } else {
                                              echo "<p style='color: #ff4757;'>Aucune image</p>";
                                            }
                                          ?>
                                        <td> <?php echo $nom; ?> </td>
                                        <td> <?php echo $contact; ?> </td>
                                        <td> <?php echo $adresse; ?> </td>
                                        <td> <?php echo $email; ?> </td>
                                        <td> <?php echo $username; ?> </td>
                                        <td>
                                            <a href="<?php echo HOME_URL; ?>manager/edit-gest.php?id=<?php echo $id; ?>" role="button" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a>
                                            <a href="<?php echo HOME_URL; ?>manager/delete-gest.php?id=<?php echo $id; ?>&image=<?php echo $profil; ?>&sn=<?php echo $idCompte; ?>" role="button" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i></a>
                                        </td>
                                    </tr>

                                    <?php
                                  }
                                } else {
                                  ?>
                                  <tr>
                                      <td colspan="7">Aucun enregistrement disponible</td>
                                  </tr>
                                  <?php
                                }
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