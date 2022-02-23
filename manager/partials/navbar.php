<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Pristy Délices | Administration</title>
<!-- plugins:css -->
<link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
<!-- Layout styles -->
<link rel="stylesheet" href="assets/css/style.css">

<link rel="shortcut icon" href="../assets/images/pristy_delice.png" type="image/x-icon">

<!-- JQuery cdn link -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->




<!-- Include constants.php file to make connection with te database -->
<?php
  include('../config/constants.php');
  include('login-check.php');
?>

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="navbar-brand brand-logo" href="index.php"><img src="assets/images/logo.svg" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
    <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="assets/images/pristy_delice1.png" alt="logo" /></a> -->
    <!-- <a class="navbar-brand brand-logo-mini" href="index.html">PRISTY DELICES</a> -->
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <!-- <div class="custom-control custom-switch d-flex align-items-stretch ml-3">
        <input type="checkbox" class="custom-control-input" id="selector">
        <label class="custom-control-label align-self-center" for="selector"><span id="switch-mode">Mode sombre</span></label>
    </div> -->
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <div class="nav-profile-img">
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
            <span class="availability-status online"></span>
          </div>
          <div class="nav-profile-text">
            <p class="mb-1 text-black"><?php echo $_SESSION['nom']; ?></p>
          </div>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
          <?php
            if ($_SESSION['role'] != 'Gestionnaire') {
              ?>
              <a class="dropdown-item" href="profile.php">
              <i class="mdi mdi-account-card-details mr-2" style="color: #ff6348;"></i> Mon profil </a>
              <?php
            }
          ?>
          <a class="dropdown-item" href="#">
            <i class="mdi mdi-settings mr-2" style="color: #ff6348;"></i> Paramètres </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">
            <i class="mdi mdi-logout mr-2" style="color: #ff6348;"></i> Déconnexion </a>
        </div>
      </li>
      <li class="nav-item d-none d-lg-block full-screen-link" title="Plein écran">
        <a class="nav-link">
          <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" onclick="document.getElementById('incoming').style.visibility='hidden'" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-email-outline"></i>
          <?php
            // Count all the unreaded messages
            $query3 = "SELECT count(*) AS NonLus FROM messages WHERE lu='Non'";
            $result3 = mysqli_query($conn, $query3);
            $row_data = mysqli_fetch_assoc($result3);
            $count2 = $row_data['NonLus'];
            if ($count2 > 0) {
              ?>
              <span class="count-symbol bg-warning" id="incoming"></span>
              <?php
            }
          ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <h6 class="p-3 mb-0">Messages</h6>
          <div class="dropdown-divider"></div>

          <?php
            $sql = "SELECT * FROM messages ORDER BY date_edition ASC LIMIT 3";

            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
              $count = mysqli_num_rows($res);
              if ($count > 0) {
                while ($row_msg = mysqli_fetch_assoc($res)) {
                  $firstname = $row_msg['nom_visiteur'];
                  $senddate = $row_msg['date_edition'];
                  ?>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="assets/images/pristy_delice.png" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal"> Message de <?php echo $firstname; ?> </h6>
                      <p class="text-gray mb-0">
                        <?php
                          date_default_timezone_set('Africa/Douala');
                          // Convert string in datetime
                          $to_time = strtotime(date('Y-m-d H:i:s'));
                          $from_time = strtotime($senddate);
                          $minutes = round(abs($to_time - $from_time) / 60);
                          // If minutes greater than 60 seconds
                          if ($minutes <= 59) {
                            echo "Il y a ".$minutes." minute(s)";
                          } else {
                            $hours = round(abs($minutes) / 60);
                            if ($hours <= 23) {
                              echo "Il y a ".$hours." heure(s)";
                            } else {
                              $days = round(abs($hours) / 24);
                              if ($days <= 7) {
                                echo "Il y a ".$days." jour(s)";
                              } else {
                                $weeks = round(abs($days) / 7);
                                echo "Il y a ".$weeks." semaine(s)";
                              }
                            }
                          }
                        ?>
                      </p>
                    </div>
                  </a>
                  <?php
                }
              } else {
                ?>
                <p class="p-3 mb-0 text-center">Aucun nouveau message</p>
                <?php
              }
            }
          ?>
          <div class="dropdown-divider"></div>
          <?php
            $query = "SELECT * FROM messages";
            $result = mysqli_query($conn, $query);
            $numRows = mysqli_num_rows($result);
            if ($numRows > 3) {
                $query2 = "SELECT * FROM messages LIMIT 3,$numRows";
                $result2 = mysqli_query($conn, $query2);
                if ($result2 == TRUE) {
                  $countRows = mysqli_num_rows($result2);
                  ?>
                  <h6 class="p-3 mb-0 text-center">+<?php echo $countRows; ?> nouveau(x) message(s)</h6>
                  <?php
                }
            }
          ?>
        </div>
      </li>
      <li class="nav-item nav-logout d-none d-lg-block">
        <a class="nav-link" href="logout.php">
          <i class="mdi mdi-power"></i>
        </a>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>



