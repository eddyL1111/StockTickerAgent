<?php

class Transactions extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Retrieve movement table data from database.
     * @return type Associative array of movement from the database. 
     * Attributes: Datetime, Player, Stock, Trans, Quantity
     */
    function all() {
        $this->db->order_by("datetime", "desc"); //order by value, descending
        $query = $this->db->get("transactions"); //get the stocks table
        return $query->result_array();
    }
    
    function find_recent_by_stock() {
        $this->db->order_by("datetime", "desc"); 
        $query = $this->db->get("transactions"); 
        return $query->result_array();
    }
}
