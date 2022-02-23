<?php

// Require MySQL Connection
require("database/DBController.php");

// Require Categorie class
require("database/Categorie.php");

// Require Produit class
require("database/Produit.php");

// Require Panier class
require("database/Panier.php");

// Create a new object from DBController class to initialize the connection
$bd = new DBController();

// Create an object from Categorie class
$category = new Categorie($bd);
// Get all the categories
$activeCategories = $category->getActiveCategories();

// Create an object from Produit class
$product = new Produit($bd);
// Get all the products
$products = $product->getProducts();

// Create an object from Panier class
$cart = new Panier($bd);