<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <?php
          if ($_SESSION['profil'] != "") {
            ?>
            <img src="<?php echo HOME_URL; ?>images/admin_gest_profiles/<?php echo $_SESSION['profil']; ?>" alt="profil">
            <?php
          } else {
            ?>
            <img src="../images/default.png" alt="Default-image">
            <?php
          }
          ?>
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2" id="session-user"><?php echo $_SESSION['nom']; ?></span>
          <span class="text-secondary text-small"><?php echo $_SESSION['role']; ?></span>
        </div>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <span class="menu-title">Tableau de bord</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <!-- ***************** Section Manage accounts starts ***************** -->
    <li <?php if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" href="manage-account.php?page=1">
        <span class="menu-title">Comptes utilisateurs</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>
    <li <?php if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" href="manage-gest.php?page=1">
        <span class="menu-title">Gestionnaires</span>
        <i class="mdi mdi-account-multiple menu-icon"></i>
      </a>
    </li>
    <!-- <li <?php // if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <span class="menu-title">Gestion des comptes</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-account-multiple menu-icon"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li <?php // if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item"> <a class="nav-link" href="manage-gest.php?page=1">Gestionnaires</a></li>
        </ul>
      </div>
    </li> -->
    <!-- ***************** Section Manage accounts ends ***************** -->
    <!-- ***************** Section Manage products starts ***************** -->
    <li class="nav-item">
      <a class="nav-link" href="manage-category.php?page=1">
        <span class="menu-title">Catégories</span>
        <i class="mdi mdi-folder-multiple menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
        <span class="menu-title">Produits par catégorie</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-food menu-icon"></i>
      </a>
      <div class="collapse" id="general-pages">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="manage-products.php?page=1">Tous les produits</a></li>
          <?php
            $sql = "SELECT * FROM categorie WHERE statut='Actif'";
            $res = mysqli_query($conn,$sql);
            $count = mysqli_num_rows($res);
            if ($count > 0) {
              while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $nom = $row['nom'];
                ?>
                <li class="nav-item"> <a class="nav-link" href="PD-ByCategory.php?category_id=<?php echo $id; ?>&category_name=<?php echo $nom; ?>"><?php echo $nom; ?></a></li>
                <?php
              }
            }
          ?>
          <!-- <li class="nav-item"> <a class="nav-link" href="PD-simple-cakes.php">Gâteaux simples</a></li>
          <li class="nav-item"> <a class="nav-link" href="PD-events-cakes.php">Gâteaux pour occasions</a></li>
          <li class="nav-item"> <a class="nav-link" href="PD-snacks.php">Grignoteries</a></li>
          <li class="nav-item"> <a class="nav-link" href="PD-pizzas.php">Pizza</a></li>
          <li class="nav-item"> <a class="nav-link" href="PD-drinks.php">Boissons</a></li> -->
          <!-- <li class="nav-item"> <a class="nav-link" href="#">Crèmes glacées</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Téléphones</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Coiffure</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Habillement</a></li> -->
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="manage-orders.php">
        <span class="menu-title">Commandes</span>
        <?php
          // Get the number of orders saved
          $sql2 = "SELECT * FROM commande WHERE statutCommande='En cours...'";
          $res2 = mysqli_query($conn, $sql2);
          $count2 = mysqli_num_rows($res2);
          if ($count2 > 0) {
            ?>
            <span class="badge badge-danger"><?php echo $count2; ?></span>
            <?php
          }
        ?>
        <i class="mdi mdi-cart menu-icon"></i>
      </a>
    </li>
    <!-- ***************** Section Manage accounts ends ***************** -->
    <li class="nav-item" id="notification">
      <a class="nav-link" href="messages.php?lu=Non">
        <span class="menu-title">Messages</span>
        <?php
          // Get the number of messages
          $sql3 = "SELECT count(*) AS msgs FROM messages WHERE lu='Non'";
          $res3 = mysqli_query($conn, $sql3);
          $row = mysqli_fetch_assoc($res3);
          $countMsg = $row['msgs'];
          if ($countMsg > 0) {
            ?>
            <span id="newMsg" class="badge badge-danger"><?php echo $countMsg; ?></span>
            <?php
          }
        ?>
        <i class="mdi mdi-message-text menu-icon"></i>
      </a>
    </li>
    <li <?php if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Privilèges (Bientôt)</span>
        <i class="mdi mdi-folder-lock-open menu-icon"></i>
      </a>
    </li>
    <li <?php if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Formations (Bientôt)</span>
        <i class="mdi mdi-view-list menu-icon"></i>
      </a>
    </li>
    <li <?php if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Nouveautés (Bientôt)</span>
        <i class="mdi mdi-star menu-icon"></i>
      </a>
    </li>
    <!-- <li <?php //if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item sidebar-actions">
      <span class="nav-link">
        <div class="border-bottom">
          <h6 class="font-weight-normal">Paramètres</h6>
        </div>
      </span>
    </li> -->
    <!-- <li <?php //if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" href="activity-log.php">
        <span class="menu-title">Rapport d'activités</span>
        <i class="mdi mdi-wrench menu-icon"></i>
      </a>
    </li> -->
    <!-- <li <?php //if ($_SESSION['role'] == "Gestionnaire") {echo "style=display:none;";} ?> class="nav-item">
      <a class="nav-link" href="#">
        <span class="menu-title">Contrôle d'accès</span>
        <i class="mdi mdi-folder-lock menu-icon"></i>
      </a>
    </li> -->
  </ul>
</nav>


<!-- plugins:js -->
<script src="assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="assets/vendors/chart.js/Chart.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="assets/js/off-canvas.js"></script>
<script src="assets/js/hoverable-collapse.js"></script>
<script src="assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="assets/js/dashboard.js"></script>
<script src="assets/js/todolist.js"></script>
<script src="assets/js/file-upload.js"></script>
<script src="assets/js/search.js"></script>
<!-- End custom js for this page -->
<script>

    // $("#selector").change(function(){
    //   // Switch mode Dark/Light mode
    //   if ($("#switch-mode").text() == "Mode sombre") {
    //     $("#switch-mode").text("Mode clair");
    //   } else {
    //     $("#switch-mode").text("Mode sombre");
    //   }

      // Navbar
      // $(".navbar-menu-wrapper").toggleClass("bg-dark");
      // $(".nav-profile-text p").toggleClass("text-secondary");
      // $(".dropdown-menu").toggleClass("bg-dark");
      // $(".dropdown-item").toggleClass("text-secondary");
      // $(".dropdown-menu h6").toggleClass("text-secondary");
      // $(".dropdown-menu p").toggleClass("text-secondary");

      // Sidebar
      // $(".navbar-brand-wrapper").toggleClass("bg-dark");
      // $(".sidebar").toggleClass("bg-dark");
      // $(".sidebar .nav").toggleClass("bg-dark");
      // $(".nav-profile-text #session-user").toggleClass("text-secondary");
      // $(".nav-item .nav-link h6").toggleClass("text-secondary");
      // $(".nav-item .nav-link").toggleClass("text-secondary");
  //   });
  // });
</script>
