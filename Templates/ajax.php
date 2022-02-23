<?php

// Require MySQL Connection
require("../database/DBController.php");

// Require Product class
require("../database/Produit.php");

// DBController object
$bd = new DBController();

// Product object
$product = new Produit($bd);

if(isset($_POST['itemid'])) {
    $result = $product->getProduct($_POST['itemid']);
    echo json_encode($result);
}

if(isset($_POST['productid'])) {
    $result = $product->getProduct($_POST['productid']);
    echo json_encode($result);
}
?>