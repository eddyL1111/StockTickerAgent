<?php

class Movements extends MY_Model {
    function __construct() {
        parent::__construct("movements", "Datetime");
    }
    
    function find_recent_by_stock() 
    {
        $this->db->order_by("Datetime", "desc"); 
        $query = $this->db->get($this->_tableName); 
        return $query->result();
    }
    
}
