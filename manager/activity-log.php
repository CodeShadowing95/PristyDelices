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
                            <i class="mdi mdi-wrench"></i>
                        </span> Rapport d'activités
                    </h3>

                    <!-- Session messages here -->

                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                            <a href="#" type="button" class="btn btn-danger btn-icon-text">
                                <i class="mdi mdi-delete-forever btn-icon-prepend"></i> Effacer tout </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="template-demo">
                                        <button type="button" class="btn btn-info btn-rounded btn-fw">Tout</button>
                                        <button type="button" class="btn btn-info btn-rounded btn-fw">Dernières heures</button>
                                        <button type="button" class="btn btn-info btn-rounded btn-fw">Dernières 24 heures</button>
                                        <button type="button" class="btn btn-info btn-rounded btn-fw">Cette semaine</button>
                                        <button type="button" class="btn btn-info btn-rounded btn-fw">4 dernières semaines</button>
                                    </div>
                                    <input class="form-control mt-4" id="myInput" type="search" placeholder="Rechercher..."><br>
                                    <table class="table table-hover" id="countColTab">
                                        <thead>
                                        <tr>
                                            <th> Utilisateur </th>
                                            <th> Profil </th>
                                            <th> Téléphone </th>
                                            <th> Activité </th>
                                            <th> Date et heure </th>
                                            <th> Actions </th>
                                        </tr>
                                        </thead>
                                        <tbody id="myTable">

                                            <?php
                                                
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