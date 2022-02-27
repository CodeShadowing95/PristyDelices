<?php

class Produit {
    public $bd = null;

    // Dependencies injection
    // Initialize the connection to the database
    public function __construct(DBController $bd) {
        // If the connection is not established, return nothing
        if (!isset($bd->conn)) return null;
        $this->bd = $bd;
    }

    // Fetch all the products from the database
    public function getProducts($table = 'produit', $user = null) {
        if(isset($user) && $user != null) {
            // Store the datas in a variable
            $result = $this->bd->conn->query("SELECT * FROM {$table} WHERE id_client = {$user}");

            $resultArray = array();

            // Fetch all the datas in $result one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }

            return $resultArray;
        } else {
            // Store the datas in a variable
            $result = $this->bd->conn->query("SELECT * FROM {$table}");

            $resultArray = array();

            // Fetch all the datas in $result one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }

            return $resultArray;
        }
    }

    // Fetch all the active products from the database
    public function getActiveProducts($table = 'produit') {
        // Store the datas in a variable
        $result = $this->bd->conn->query("SELECT * FROM {$table} WHERE fonctionnelProduit='Oui'");

        $resultArray = array();

        // Fetch all the datas in $result one by one
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $item;
        }

        return $resultArray;
    }

    // Get products using id_produit
    public function getProduct($id_produit = null, $table = 'produit') {
        if(isset($id_produit)) {
            // Get the product through id_produit
            $result = $this->bd->conn->query("SELECT * FROM {$table} WHERE idProduit = {$id_produit}");

            $resultArray = array();

            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }

            return $resultArray;
        }
    }

    // Get products by category
    public function getProductCategory($id_categorie = null, $table = 'produit') {
        if(isset($id_categorie)) {
            $result = $this->bd->conn->query("SELECT * FROM {$table} WHERE idCategorie = {$id_categorie}");

            $resultArray = array();

            while($cat_produit = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $cat_produit;
            }

            return $resultArray;
        }
    }

    // Parameters of an insertion into jaime
    public function insertIntoJaime($params = null, $table='jaime') {
        // Check whether the connection to the database is established or not
        if($this->bd->conn != null) {
            if($params != null) {
                $columns = implode(', ', array_keys($params));
                $values = implode(', ', array_values($params));
            }

            // SQL query
            $query_string = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $columns, $values);

            // Execute the SQL query
            $result = $this->bd->conn->query($query_string);

            return $result;
        }
    }

    // Add a like on a product
    public function addLike($id_client, $id_produit) {
        // Check whether id_client and id_produit are set or not
        if(isset($id_client) && isset($id_produit)) {
            // Create an associative table that'll store the parameters
            $params = array(
                'id_client' => $id_client,
                'id_produit' => $id_produit
            );

            // Add in the table jaime
            $result = $this->insertIntoJaime($params);

            if ($result) {
                return '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Cool!</strong> Merci pour votre appréciation.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                ';
                // header("Location:".$_SERVER['PHP_SELF']);
            }
        }
    }

    // Get all the likes
    public function getAllLikes($id_produit = null, $table = 'jaime') {
        $result = $this->bd->conn->query("SELECT * FROM {$table} WHERE id_produit = {$id_produit}");

        $resultArray = array();

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $row;
        }

        return $resultArray;
    }

    public function getLikesUser($likeArray = null, $key = "id_produit") {
        // if the array is not empty
        if($likeArray != null) {
            $like_product_ids = array_map(function($item) use ($key) {
                return $item[$key];
            }, $likeArray);
            return $like_product_ids;
        }
    }

}