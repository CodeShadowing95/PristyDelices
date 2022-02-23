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
                            <i class="mdi mdi-account"></i>
                        </span> Gestion des Comptes
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
                        $query = "SELECT count(*) AS Total FROM compte";
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
                        $sql_query = "SELECT * FROM compte WHERE id NOT LIKE 1 ORDER BY username ASC LIMIT $firstItem, $eachPage";
                        $result_query = mysqli_query($conn, $sql_query);

                        // The serial number of the list of items
                        $sn = (($currentPage * $eachPage) - $eachPage) + 1;
                    ?>

                    <?php
                        if (isset($_SESSION['add'])) {
                            echo $_SESSION['add']; #Displaying Session message
                            unset($_SESSION['add']); #Removing Session message
                            // session_unset($_SESSION['add']);
                            // session_destroy($_SESSION['add']);
                        }
                    
                        if (isset($_SESSION['update'])) {
                            echo $_SESSION['update']; #Displaying Session message
                            unset($_SESSION['update']); #Removing Session message
                            // session_unset($_SESSION['add']);
                            // session_destroy($_SESSION['add']);
                        }
                    
                        if (isset($_SESSION['delete'])) {
                            echo $_SESSION['delete']; #Displaying Session message
                            unset($_SESSION['delete']); #Removing Session message
                            // session_unset($_SESSION['add']);
                            // session_destroy($_SESSION['add']);
                        }
                    
                        if (isset($_SESSION['edit-password'])) {
                            echo $_SESSION['edit-password']; #Displaying Session message
                            unset($_SESSION['edit-password']); #Removing Session message
                            // session_unset($_SESSION['add']);
                            // session_destroy($_SESSION['add']);
                        }
                    
                        if (isset($_SESSION['user-not-found'])) {
                            echo $_SESSION['user-not-found']; #Displaying Session message
                            unset($_SESSION['user-not-found']); #Removing Session message
                            // session_unset($_SESSION['user-not-found']);
                            // session_destroy($_SESSION['add']);
                        }
                    
                        if (isset($_SESSION['fail'])) {
                            echo $_SESSION['fail']; #Displaying Session message
                            unset($_SESSION['fail']); #Removing Session message
                            // session_unset($_SESSION['user-not-found']);
                            // session_destroy($_SESSION['add']);
                        }
                    
                        if (isset($_SESSION['lock'])) {
                            echo $_SESSION['lock']; #Displaying Session message
                            unset($_SESSION['lock']); #Removing Session message
                            // session_unset($_SESSION['user-not-found']);
                            // session_destroy($_SESSION['add']);
                        }
                    
                        if (isset($_SESSION['unlock'])) {
                            echo $_SESSION['unlock']; #Displaying Session message
                            unset($_SESSION['unlock']); #Removing Session message
                            // session_unset($_SESSION['user-not-found']);
                            // session_destroy($_SESSION['add']);
                        }
                    ?>

                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                            <a href="add-account.php" type="button" class="btn btn-info btn-icon-text">
                                <i class="mdi mdi-account-plus btn-icon-prepend"></i> Ajouter compte </a>
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
                            <input class="form-control" id="myInput" type="search" placeholder="Rechercher un compte..."><br>
                            <table class="table table-hover" id="countColTab">
                                <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Nom d'utilisateur </th>
                                    <th> Rôle </th>
                                    <th> Statut </th>
                                    <th> Actions </th>
                                </tr>
                                </thead>
                                <tbody id="myTable">

                                    <?php
                                        // Count the number of rows in the result set
                                        $count = mysqli_num_rows($result_query);

                                        if ($count > 0) {
                                            while ($row = mysqli_fetch_assoc($result_query)) {
                                                $id = $row['id'];
                                                $username = $row['username'];
                                                $role = $row['role'];
                                                $statut = $row['statut'];

                                                // Display the values in our table in HTML
                                                ?>

                                                <tr>
                                                    <td><?php echo $sn++; ?></td>
                                                    <td> <?php echo $username; ?> </td>
                                                    <td> <?php echo $role; ?> </td>
                                                    <td>
                                                        <?php
                                                            if ($statut == "Actif") {
                                                                echo "<label class='badge badge-info'>$statut</label>";
                                                            } else if ($statut == "Inactif") {
                                                                echo "<label class='badge badge-primary'>$statut</label>";
                                                            } else if ($statut == "Compte bloqué") {
                                                                echo "<label class='badge badge-danger'>$statut</label>";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo HOME_URL; ?>manager/edit-account.php?account_id=<?php echo $id; ?>" role="button" class="btn btn-sm btn-success"><i class="mdi mdi-pencil"></i></a>
                                                        <a href="<?php echo HOME_URL; ?>manager/delete-account.php?account_id=<?php echo $id; ?>" role="button" class="btn btn-sm btn-danger"><i class="mdi mdi-delete-forever"></i></a>
                                                        <a href="<?php echo HOME_URL; ?>manager/edit-password.php?account_id=<?php echo $id; ?>" role="button" class="btn btn-sm btn-warning"><i class="mdi mdi-account-settings"></i></a>
                                                        <!-- <a href="#" role="button" class="btn btn-sm btn-secondary"><i class="mdi mdi-account-card-details"></i></a> -->
                                                        <a href="<?php echo HOME_URL; ?>manager/access-account.php?account_id=<?php echo $id; ?>" class="btn btn-sm <?php echo ($statut == "Compte bloqué") ? "btn-light" : "btn-dark" ?> <?php echo ($statut == "Inactif") ? "disabled" : ""; ?>"><?php echo ($statut == "Compte bloqué") ? "<i class='mdi mdi-lock-open'></i>" : "<i class='mdi mdi-lock'></i>" ?></a>
                                                    </td>
                                                </tr>
                                                <!-- Modal -->
                                                <!-- <div class="modal fade" id="<?php //echo ($statut == "Actif") ? "block-$id" : "block1-$id"; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php //echo ($statut == "Actif") ? "block-$id" : "block1-$id"; ?>" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?php //echo ($statut == "Actif") ? "block-$id" : "block1-$id"; ?>"><?php //echo ($statut == "Actif") ? "Bloquer" : "Débloquer"; ?> le compte de <?php //echo $username?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label class="font-italic text-danger">
                                                                    <?php
                                                                        // if ($statut == "Actif") {
                                                                        //     echo "Attention: L'utilisateur associé à ce compte ne pourra 
                                                                        //     plus se connecter au site en tant qu'administrateur pour y effectuer des opérations";
                                                                        // } else {
                                                                        //     echo "L'utilisateur associé à ce compte pourra désormais se connecter
                                                                        //     à l'application et y effectuer des opérations";
                                                                        // }
                                                                    ?>
                                                                </label><br>
                                                                <label>Voulez-vous vraiment <?php //echo ($statut == "Actif") ? "bloquer" : "débloquer"; ?> le compte <span class="font-weight-bold"><?php //echo $username?></span> ?</label>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Non</button>
                                                                <form method="POST">
                                                                    <input type="hidden" name="id" value="<?php //echo $id; ?>">
                                                                    <input type="submit" name="submit" class="btn btn-info" value="Oui">
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <?php
                                            }

                                            // if (array_key_exists('submit', $_POST)) {
                                                // echo "Cool";
                                                // Set "Compte bloqué" to a selected account
                                                // if ($statut == "Actif") {
                                                //     $sql = "UPDATE compte SET statut = 'Compte bloqué' WHERE id = $id";

                                                    // Execute the query
                                                    // $result = mysqli_query($conn, $sql);

                                                    // Check whether the query is executed successfully or not
                                                    // if ($result == TRUE) {
                                                        // Message
                                                    //     $_SESSION['lock'] = "<div id='message_success'>Le compte a été bloqué</div>";
                                                    //     header("Location:".HOME_URL."manager/manage-account.php");
                                                    // } else {
                                                        // Message
                                                //         $_SESSION['lock'] = "<div id='message_error'>Une erreur est survenue</div>";
                                                //         header("Location:".HOME_URL."manager/manage-account.php");
                                                //     }
                                                // } else if ($statut = "Compte bloqué") {
                                                //     $sql3 = "UPDATE compte SET statut = 'Actif' WHERE id = $id";

                                                    // Execute the query
                                                    // $result2 = mysqli_query($conn, $sql3);

                                                    // Check whether the query is executed or not
                                                    // if ($result2 == TRUE) {
                                                        // Message
                                                    //     $_SESSION['unlock'] = "<div id='message_success'>Le compte a été débloqué</div>";
                                                    //     header("Location:".HOME_URL."manager/manage-account.php");
                                                    // } else {
                                                        // Message
                                            //             $_SESSION['unlock'] = "<div id='message_error'>Une erreur est survenue</div>";
                                            //             header("Location:".HOME_URL."manager/manage-account.php");
                                            //         }
                                            //     } else {
                                            //         header("Location:".HOME_URL."manager/manage-account.php");
                                            //     }             
                                            // }

                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="5">Aucun enregistrement disponible</td>
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
                                    <a href="<?php echo HOME_URL; ?>manager/manage-account.php?page=<?php echo $currentPage - 1; ?>" class="page-link">Précédent</a>
                                </li>
                                <?php
                                    for ($page=1; $page <= $pages; $page++) { 
                                        ?>
                                        <li class="page-item <?php if ($currentPage == $page) {echo "active";} ?>">
                                            <a class="page-link" href="<?php echo HOME_URL; ?>manager/manage-account.php?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                        </li>
                                        <?php
                                    }
                                ?>
                                <li class="page-item <?php if($currentPage == $pages) {echo "disabled";} ?>">
                                    <a href="<?php echo HOME_URL; ?>manager/manage-account.php?page=<?php echo $currentPage + 1; ?>" class="page-link">Suivant</a>
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