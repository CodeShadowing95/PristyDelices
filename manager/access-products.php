<?php
    include('../config/constants.php');

    $id = $_GET['id'];
    
    $sql = "SELECT * FROM produit WHERE idProduit = $id";

    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);

        $id = $row['idProduit'];
        $fonctionnel = $row['fonctionnelProduit'];
        if ($fonctionnel == "Oui") {
            $sql2 = "UPDATE produit SET fonctionnelProduit = 'Non' WHERE idProduit = $id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == TRUE) {
                $_SESSION['access'] = "<div id='message_success'>Produit désactivé</div>";
                header("Location:".HOME_URL."manager/manage-products.php");
            } else {
                $_SESSION['access'] = "<div id='message_error'>Échec de l'opération</div>";
                header("Location:".HOME_URL."manager/manage-products.php");
            }
        } else {
            $sql3 = "UPDATE produit SET fonctionnelProduit = 'Oui' WHERE idProduit = $id";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3 == TRUE) {
                $_SESSION['access'] = "<div id='message_success'>Produit fonctionnel</div>";
                header("Location:".HOME_URL."manager/manage-products.php");
            } else {
                $_SESSION['access'] = "<div id='message_error'>Échec de l'opération</div>";
                header("Location:".HOME_URL."manager/manage-products.php");
            }
        }
    }
?>

