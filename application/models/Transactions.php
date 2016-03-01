<?php

class Transactions extends MY_Model {
    function __construct() {
        parent::__construct("transactions", "DateTime");
    }
    
    /**
     * Retrieve transaction table data from database.
     * @return type Associative array of transaction data from the database. 
     * Attributes: DateTime, Player, Stock, Trans, Quantity
     */
    function find_recent_by_stock() {
        $this->db->order_by("datetime", "desc"); 
        $query = $this->db->get("transactions"); 
        return $query->result();
    }
}
