<?php

    include('../config/constants.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $query = "SELECT statut FROM categorie WHERE id = $id";

    $res = mysqli_query($conn, $query);

    if ($res == TRUE) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);
            $statut = $row['statut'];

            if ($statut == "Actif") {
                $sql = "UPDATE categorie SET statut = 'Inactif' WHERE id = $id";

                $result = mysqli_query($conn, $sql);

                if ($result == TRUE) {
                    header("Location:".HOME_URL."manager/manage-category.php");
                } else {
                    $_SESSION['status'] = "<div id='message_error'>Échec de l'opération</div>";
                }
            } else if ($statut = 'Inactif') {
                $sql2 = "UPDATE categorie SET statut = 'Actif' WHERE id = $id";

                $result2 = mysqli_query($conn, $sql2);

                if ($result2 == TRUE) {
                    header("Location:".HOME_URL."manager/manage-category.php");
                } else {
                    $_SESSION['status'] = "<div id='message_error'>Échec de l'opération</div>";
                }
            }
        }
    }


?>