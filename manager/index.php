<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pristy Délices | Administration</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <!-- <link rel="shortcut icon" href="assets/images/favicon.ico" /> -->
    <link rel="shortcut icon" href="assets/images/pristy_delice.png" type="image/x-icon">
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php
        include('partials/navbar.php');
      ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php
          include('partials/sidebar.php');
        ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>
                </span> Tableau de bord
              </h3>
            </div>

            <!-- Session messages -->
            <?php
            if (isset($_SESSION['login'])) {
              echo $_SESSION['login'];
              unset($_SESSION['login']);
            }
            ?>
            
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Produits disponibles <i class="mdi mdi-food mdi-24px float-right"></i>
                    </h4>
                    <?php
                      // Get all the products from the database
                      $sql = "SELECT * FROM produit";
                      $res = mysqli_query($conn, $sql);
                      if ($res == TRUE) {
                        $count = mysqli_num_rows($res);
                      }
                    ?>
                    <h2 class="mb-5"><?php echo $count; ?></h2>
                    <!-- <h6 class="card-text">Increased by 60%</h6> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Commandes effectuées <i class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                    </h4>
                    <?php
                      $sql2 = "SELECT * FROM commande WHERE statutCommande='Livrée'";
                      $res2 = mysqli_query($conn, $sql2);
                      $count2 = mysqli_num_rows($res2);
                    ?>
                    <h2 class="mb-5"><?php echo $count2; ?></h2>
                    <!-- <h6 class="card-text">Decreased by 10%</h6> -->
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Revenus générés <i class="mdi mdi-cash-multiple mdi-24px float-right"></i>
                    </h4>
                    <?php
                    $sql3 = "SELECT SUM(total) AS Total FROM commande WHERE statutCommande='Livrée'";
                    $res3 = mysqli_query($conn, $sql3);
                    $data = mysqli_fetch_assoc($res3);
                    $revenu_total = $data['Total'];
                    ?>
                    <h2 class="mb-5">XAF <?php echo $revenu_total; ?></h2>
                    <!-- <h6 class="card-text">Increased by 5%</h6> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Commandes livrées</h4><br>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Produit </th>
                            <th> Quantité </th>
                            <th> Prix </th>
                            <th> Client </th>
                            <th> Contact </th>
                            <th> Email </th>
                            <th> Date de commande </th>
                            <th> Statut </th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          $sql4 = "SELECT * FROM commande WHERE statutCommande='Livrée'";
                          $res4 = mysqli_query($conn, $sql4);
                          $count3 = mysqli_num_rows($res4);
                          if ($count3 > 0) {
                            while ($row_data = mysqli_fetch_assoc($res4)) {
                              // Get details about order
                              $nom_client = $row_data['nom_client'];
                              $contact_client = $row_data['contact_client'];
                              $email_client = $row_data['email_client'];
                              $quantite = $row_data['quantite'];
                              $total = $row_data['total'];
                              $date_commande = $row_data['date_commande'];
                              $statut_commande = $row_data['statutCommande'];
                              // Get details about products related to the order
                              $idProduit = $row_data['idProduit'];
                              ?>
                              <tr>
                                <?php
                                  // Get the product related to the order
                                  $query = "SELECT * FROM produit WHERE idProduit=$idProduit";
                                  $result = mysqli_query($conn, $query);
                                  $count4 = mysqli_num_rows($result);
                                  if ($count4 == 1) {
                                    $food_row = mysqli_fetch_assoc($result);
                                    $nomProduit = $food_row['nomProduit'];
                                    $imageProduit = $food_row['imageProduit'];
                                    ?>
                                    <td> <img src="<?php echo HOME_URL; ?>images/products/<?php echo $imageProduit; ?>" alt=""> <?php echo $nomProduit; ?> </td>
                                    <?php
                                  }
                                ?>
                                <td> <?php echo $quantite; ?> </td>
                                <td> <?php echo $total; ?> </td>
                                <td> <?php echo $nom_client; ?> </td>
                                <td> <?php echo $contact_client; ?> </td>
                                <td> <?php echo $email_client; ?> </td>
                                <td> <?php echo $date_commande; ?> </td>
                                <td>
                                  <label class="badge badge-success"><?php echo $statut_commande; ?></label>
                                </td>
                              </tr>
                              <?php
                            }
                          } else {
                            ?>
                            <tr>
                              <td colspan="8">Aucune commande livrée</td>
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
            <div class="row">
              <div class="col-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Catégories inactives</h4><br>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <!-- <th> # </th> -->
                            <th> Nom de la catégorie </th>
                            <th> Image </th>
                            <!-- <th> Description </th> -->
                            <th> Statut </th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                            // Get all the inactive categories
                            $sql5 = "SELECT * FROM categorie WHERE statut='Inactif'";
                            $res5 = mysqli_query($conn, $sql5);
                            $count5 = mysqli_num_rows($res5);
                            if ($count5 > 0) {
                              $sn = 1;
                              while ($row_cat_inactive = mysqli_fetch_assoc($res5)) {
                                $nom = $row_cat_inactive['nom'];
                                $image = $row_cat_inactive['image'];
                                // $description = $row_cat_inactive['description'];
                                $statut = $row_cat_inactive['statut'];
                                ?>
                                <tr>
                                  <!-- <td> <?php //echo $sn++; ?> </td> -->
                                  <td> <?php echo $nom; ?> </td>
                                  <td>
                                    <?php
                                      if ($image != "") {
                                        // Image available
                                        ?>
                                        <img src="<?php echo HOME_URL; ?>images/category/<?php echo $image; ?>" class="mr-2" alt="image">
                                        <?php
                                      } else {
                                        ?>
                                        <img src="images/default.png" class="mr-2" alt="image">
                                        <?php
                                      }
                                    ?>
                                  </td>
                                  <!-- <td> <?php //echo $description; ?> </td> -->
                                  <td>
                                    <label class="badge badge-primary">Non fonctionnel</label>
                                  </td>
                                </tr>
                                <?php
                              }
                            } else {
                              ?>
                              <tr>
                                <td colspan="3" class="text-center font-weight-bold">Aucune catégorie inactive trouvée</td>
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
              <div class="col-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Catégories actives</h4><br>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <!-- <th> # </th> -->
                            <th> Nom de la catégorie </th>
                            <th> Image </th>
                            <!-- <th> Description </th> -->
                            <th> Statut </th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                            // Get all the inactive categories
                            $sql7 = "SELECT * FROM categorie WHERE statut='Actif'";
                            $res7 = mysqli_query($conn, $sql7);
                            $count7 = mysqli_num_rows($res7);
                            if ($count7 > 0) {
                              $sn = 1;
                              while ($row_cat_active = mysqli_fetch_assoc($res7)) {
                                $nom = $row_cat_active['nom'];
                                $image = $row_cat_active['image'];
                                // $description = $row_cat_active['description'];
                                $statut = $row_cat_active['statut'];
                                ?>
                                <tr>
                                  <!-- <td> <?php //echo $sn++; ?> </td> -->
                                  <td> <?php echo $nom; ?> </td>
                                  <td>
                                    <?php
                                      if ($image != "") {
                                        // Image available
                                        ?>
                                        <img src="<?php echo HOME_URL; ?>images/category/<?php echo $image; ?>" class="mr-2" alt="image">
                                        <?php
                                      } else {
                                        ?>
                                        <img src="images/default.png" class="mr-2" alt="image">
                                        <?php
                                      }
                                    ?>
                                  </td>
                                  <!-- <td> <?php //echo $description; ?> </td> -->
                                  <td>
                                    <label class="badge badge-info">fonctionnel</label>
                                  </td>
                                </tr>
                                <?php
                              }
                            } else {
                              ?>
                              <tr>
                                <td colspan="3" class="text-center font-weight-bold">Aucune catégorie active trouvée</td>
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
              <div class="col-6 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Produits inactifs</h4><br>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <!-- <th> # </th> -->
                            <th> Nom du produit </th>
                            <th> Image </th>
                            <!-- <th> Description </th> -->
                            <th> Actif </th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                            // Get all the inactive products
                            $sql6 = "SELECT * FROM produit WHERE fonctionnelProduit='Non'";
                            $res6 = mysqli_query($conn, $sql6);
                            $count6 = mysqli_num_rows($res6);
                            if ($count6 > 0) {
                              $sn = 1;
                              while ($row_prod_inactive = mysqli_fetch_assoc($res6)) {
                                $nom = $row_prod_inactive['nomProduit'];
                                $image = $row_prod_inactive['imageProduit'];
                                // $description = $row_prod_inactive['description'];
                                $statut = $row_prod_inactive['fonctionnelProduit'];
                                ?>
                                <tr>
                                  <!-- <td> <?php //echo $sn++; ?> </td> -->
                                  <td> <?php echo $nom; ?> </td>
                                  <td>
                                    <?php
                                      if ($image != "") {
                                        // Image available
                                        ?>
                                        <img src="<?php echo HOME_URL; ?>images/products/<?php echo $image; ?>" class="mr-2" alt="image">
                                        <?php
                                      } else {
                                        ?>
                                        <img src="images/default.png" class="mr-2" alt="image">
                                        <?php
                                      }
                                    ?>
                                  </td>
                                  <!-- <td> <?php //echo $description; ?> </td> -->
                                  <td>
                                    <label class="badge badge-primary">Non</label>
                                  </td>
                                </tr>
                                <?php
                              }
                            } else {
                              ?>
                              <tr>
                                <td colspan="3" class="text-center font-weight-bold">Aucun produit inactif trouvé</td>
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
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php
            include('partials/footer.php');
          ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="assets/js/success.js"></script>
    <script src="assets/js/error.js"></script>
  </body>
</html>