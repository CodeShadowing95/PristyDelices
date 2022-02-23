<?php

class Client {
    public $bd = null;

    // Initialize the connection to the database
    public function __construct(DBController $bd) {
        // Check whether the connection to the database is established or not
        if(!isset($bd->conn)) {
            return null;
        }
        $this->bd = $bd;
    }

    // Get all the customers
    public function getCustomers($table = 'client') {
        $result = $this->bd->conn->query("SELECT * FROM {$table}");

        $resultArray = array();

        // Store the results in the array
        while ($customer = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $customer;
        }

        return $resultArray;
    }

    // Add a new customer
    public function insertCustomer($params = null, $table = 'client') {
        // Check whether the connection to the database is established
        if($this->bd->conn != null) {
            if($params != null) {
                $columns = implode(', ', array_keys($params));
                $values = implode(', ', array_values($params));

                // SQL Query string
                $query_string = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $columns, $values);

                // Execute the query
                $result = $this->bd->conn->query($query_string);

                return $result;
            }
        }
    }
}