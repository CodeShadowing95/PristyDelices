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
                            <i class="mdi mdi-message-text"></i>
                        </span> Messages
                    </h3>

                    <!-- Session messages here -->
                    <?php
                        if (isset($_SESSION['delete-msg'])) {
                            echo $_SESSION['delete-msg'];
                            unset($_SESSION['delete-msg']);
                        }
                    ?>

                    <?php
                        if (isset($_GET['lu'])) {
                            $lu = $_GET['lu'];
                            $query = "SELECT * FROM messages WHERE lu='$lu'";
                            $result = mysqli_query($conn, $query);
                            $count = mysqli_num_rows($result);
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    // Update all the messages that are unreaded to readed
                                    $sql3 = "UPDATE messages SET
                                        lu = 'Oui'
                                        WHERE id=$id
                                    ";
                                    $res3 = mysqli_query($conn, $sql3);
                                }
                            }
                        }
                    ?>

                </div>
                <div class="row">

                    <?php
                        // Get all the messages
                        $sql = "SELECT * FROM messages ORDER BY date_edition DESC";

                        $res = mysqli_query($conn, $sql);

                        if ($res == TRUE) {
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($row_data = mysqli_fetch_assoc($res)) {
                                    $message_id = $row_data['id'];
                                    $nom = $row_data['nom_visiteur'];
                                    $email = $row_data ['email_visiteur'];
                                    $telephone = $row_data ['contact_visiteur'];
                                    $message = $row_data ['contenu'];
                                    $date = $row_data ['date_edition'];
                                    ?>
                                    <div class="col-12 grid-margin stretch-card">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title"><?php echo $nom; ?></h4>
                                                <div class="d-flex">
                                                    <?php
                                                        if ($email != "") {
                                                            ?>
                                                            <div class="d-flex align-items-center mr-4 text-muted font-weight-light">
                                                                <i class="mdi mdi-at icon-sm mr-2"></i>
                                                                <span><?php echo $email; ?></span>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                    <?php
                                                        if (!empty($telephone) or $telephone != 0) {
                                                            ?>
                                                            <div class="d-flex align-items-center mr-4 text-muted font-weight-light">
                                                                <i class="mdi mdi-cellphone icon-sm mr-2"></i>
                                                                <span>+237 <?php echo $telephone; ?></span>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                    <div class="d-flex align-items-center text-muted font-weight-light">
                                                        <i class="mdi mdi-clock icon-sm mr-2"></i>
                                                        <span>
                                                            <?php
                                                                date_default_timezone_set('Africa/Douala');
                                                                echo date("M d, Y à H:i", strtotime($date));
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <p> <?php echo $message; ?> </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="id_msg" value="<?php echo $message_id; ?>" />
                                                            <button type="submit" class="btn btn-danger" name="msg-delete"><i class="mdi mdi-delete-forever"></i> Supprimer le message</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- <p class="card-description"> Write text in <code>&lt;p&gt;</code> tag </p> -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="text-center">Pas de nouveaux messages</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>

                <?php
                    if (isset($_POST['msg-delete'])) {
                        $msgID = $_POST['id_msg'];
                        $sql2 = "DELETE FROM messages WHERE id=$msgID";

                        // var_dump($sql2);

                        $res2 = mysqli_query($conn, $sql2);

                        if ($res2 == TRUE) {
                            $_SESSION['delete-msg'] = "<div id='message_success'>Message supprimé</div>";
                            header("Location:".HOME_URL."manager/messages.php");
                        }
                    }
                ?>

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