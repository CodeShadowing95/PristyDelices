<?php

class Panier {
    public $bd = null;

    // Dependencies injection
    // Initialize the connection to the database
    public function __construct(DBController $bd) {
        // If the connection to the database is not established, return nothing
        if(!isset($bd->conn)) {
            return null;
        }
        $this->bd = $bd;
    }

    // Insert into panier table
    public function insertIntoCart($params = null, $table = 'panier') {
        // If the connection to the database is established
        if($this->bd->conn != null) {
            if($params != null) {
                $columns = implode(', ', array_keys($params));
                $values = implode(', ', array_values($params));

                // SQL query
                $query_string = sprintf('INSERT INTO %s (%s) VALUES (%s)',$table, $columns, $values);

                // Execute the query
                $result = $this->bd->conn->query($query_string);

                return $result;
            }
        }
    }

    // Get the userID and itemID and insert into panier table
    public function addToCart($id_client, $id_produit) {
        if(isset($id_client) && isset($id_produit)) {
            $params = array(
                'id_client' => $id_client,
                'id_produit' => $id_produit
            );

            // add in the panier table
            $result = $this->insertIntoCart($params);
            if($result) {
                $_SESSION['added'] = '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Super!</strong> Le produit a été ajouté dans votre panier. <a href="panier.php" class="alert-link">Vérifiez</a>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
                $formAction = $_SERVER['PHP_SELF'];
                // $_SERVER['QUERY_STRING] represents all the values after an URL like url(?var=value&var2=value)"
                if(isset($_SERVER['QUERY_STRING'])) {
                    header("Location:".$formAction."?".$_SERVER['QUERY_STRING']);
                } else {
                    header("Location:".$formAction);
                }
            }
        }
    }

    // Get all the ids from panier table
    public function getCart_product_ids($cartArray = null, $key = "id_produit") {
        // If the array of cart is set
        if($cartArray != null) {
            $cart_product_ids = array_map(function($item) use ($key) {
                return $item[$key];
            }, $cartArray);
            return $cart_product_ids;
        }
    }

    // Calculate the total price of all products in the cart
    public function getSum($arr_prices) {
        if (isset($arr_prices)) {
            $sum = 0;
            foreach ($arr_prices as $item) {
                $sum += intval($item[0]);
            }

            // it will display the price with 2 digits after the decimal point
            // return sprintf('%.2f', $sum);
            return sprintf('%.0f', $sum);
        }
    }

    // Delete a product from the cart
    public function deleteProduct($id_product = null, $table = 'panier') {
        if($id_product != null) {
            $result = $this->bd->conn->query("DELETE FROM {$table} WHERE id_produit = {$id_product}");
            if($result) {
                header("Location:".$_SERVER['PHP_SELF']);
            }

            return $result;
        }
    }

    // Get the category of the product from the cart
    public function getCategoryByProduct($id_produit = null, $table = 'panier') {
        if(isset($id_produit)) {
            // Get the category of the product through the cart
            $result = $this->bd->conn->query("SELECT * FROM produit,categorie,{$table} WHERE categorie.id=produit.idCategorie AND produit.idProduit={$table}.id_produit AND id_produit={$id_produit}");

            $resultArray = array();

            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $row;
            }

            return $resultArray;
        }
    }

    // Insert into envies table
    public function insertIntoWishlist($params = null, $table = 'envies') {
        // If the connection to the database is established
        if($this->bd->conn != null) {
            if($params != null) {
                $columns = implode(', ', array_keys($params));
                $values = implode(', ', array_values($params));

                // SQL query
                $query_string = sprintf('INSERT INTO %s (%s) VALUES (%s)',$table, $columns, $values);

                // Execute the query
                $result = $this->bd->conn->query($query_string);

                return $result;
            }
        }
    }

    // Get the userID and itemID and insert into envies table
    public function addToWishlist($id_client, $id_produit) {
        if(isset($id_client) && isset($id_produit)) {
            $params = array(
                'id_client' => $id_client,
                'id_produit' => $id_produit
            );

            // add in the panier table
            $result = $this->insertIntoWishlist($params);
            if($result) {
                return '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Super!</strong> Le produit a été ajouté dans vos envies. <a href="panier.php#wishlist" class="alert-link">Vérifiez</a>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
                // Reload the page
                // header("Location: index.php");
                // header("Location:".$_SERVER['PHP_SELF']);
            }
        }
    }

    // Add to wishlist and delete from cart(if exist)
    public function moveToWishlist($id_produit = null, $toTable = 'envies', $fromTable = 'panier') {
        if($id_produit != null) {
            $query = "INSERT INTO {$toTable} SELECT * FROM {$fromTable} WHERE id_produit = {$id_produit};";
            $query .= "DELETE FROM {$fromTable} WHERE id_produit = {$id_produit};";

            // Execute multiple queries
            $result = $this->bd->conn->multi_query($query);
            if($result) {
                header("Location:".$_SERVER['PHP_SELF']);
            }

            return $result;
        }
    }

    // Get all the ids from the table 'envies'
    public function getWishlist_product_ids($wishlists = null, $key = "id_produit") {
        // If the array of wishlists is set
        if($wishlists != null) {
            $wishlist_product_ids = array_map(function ($item) use ($key) {
                return $item[$key];
            }, $wishlists);
            
            return $wishlist_product_ids;
        }
    }
}