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
                            <i class="mdi mdi-account-card-details"></i>
                        </span> Mon profil
                    </h3>

                    <!-- Session messages here -->
                    <?php
                        if (isset($_SESSION['update'])) {
                            echo $_SESSION['update']; #Displaying Session message
                            unset($_SESSION['update']); #Removing Session message
                            
                        }
                    ?>

                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <?php
                                    if ($_SESSION['profil'] != "") {
                                        ?>
                                        <img src="<?php echo HOME_URL; ?>images/admin_gest_profiles/<?php echo $_SESSION['profil']; ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo HOME_URL; ?>images/default.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                        <?php
                                    }
                                ?>
                                <h5 class="my-3"><?php echo $_SESSION['nom']; ?></h5>
                                <p class="text-muted mb-1"><?php echo $_SESSION['role']; ?></p>
                                <p class="text-muted mb-4"><?php echo $_SESSION['adresse']; ?></p>
                                <div class="d-flex justify-content-center mb-2">
                                    <a href="<?php echo HOME_URL; ?>manager/edit-gest.php?id=<?php echo $_SESSION['gestionnaire']; ?>" role="button" class="btn btn-info"><i class="mdi mdi-pencil btn-icon-prepend"></i> Modifier</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nom(s)</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $_SESSION['nom']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $_SESSION['email']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Téléphone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $_SESSION['contact']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Mobile</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $_SESSION['contact']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Adresse</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $_SESSION['adresse']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Liens</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <a href="https://www.facebook.com/Pristy-delices-109809061446170/?business_id=10152592499697447" type="button" class="btn btn-social-icon-text btn-facebook"><i class="mdi mdi-facebook"></i>Facebook</a>
                                    </div>
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