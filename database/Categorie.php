<?php

class Categorie {
    public $bd = null;

    // Initialize the connection to the database
    public function __construct(DBController $bd) {
        // If the connection to the database is not established, return nothing
        if(!isset($bd->conn)) {
            return null;
        }
        $this->bd = $bd;
    }

    // Fetch all the active categories from the database
    public function getActiveCategories($table = 'categorie') {
        // Store the datas in a variable through a query
        $result = $this->bd->conn->query("SELECT * FROM {$table} WHERE statut='Actif'");

        $resultArray = array();

        // Fetch all the datas in $result and store it in $resultArray
        while($categorie = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $categorie;
        }

        return $resultArray;
    }
}