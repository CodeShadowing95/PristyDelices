<?php

class Commande {
    public $bd = null;

    public function __construct(DBController $bd) {
        // If the connection is not established, return nothing
        if(!isset($bd->conn)) return null;
        // else
        $this->bd = $bd;
    }

    public function getOrders($table = 'commande') {
        $result = $this->bd->conn->query("SELECT * FROM {$table}");

        $resultArray = array();

        while($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $item;
        }

        return $resultArray;
    }

    public function insertNewOrder($params = null, $table = 'commande') {
        if ($this->bd->conn != null) {
            if($params != null) {
                $columns = implode(', ', array_keys($params));
                $values = implode(', ', array_values($params));

                $query_string = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $columns, $values);

                $result = $this->bd->conn->query($query_string);

                return $result;
            }
        }
    }

    public function addOrder($idProduit, $prix, $qty, $total, $orderDate, $nom, $contact, $email, $adresse, $details) {
        // Code
    }
}