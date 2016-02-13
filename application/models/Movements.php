<?php

class Movements extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Retrieve movement table data from database.
     * @return type Associative array of movement from the database. 
     * Attributes: Datetime, Code, Action, Amount
     */
    function all() 
    {
        $query = $this->db->get("movements"); //get the stocks table
        return $query->result_array();
    }
    
    function find_recent_by_stock() 
    {
        $this->db->order_by("datetime", "desc"); 
        $query = $this->db->get("movements"); 
        return $query->result_array();
    }
    
}
