<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stocks extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Retrieve all elements from the stock database.
     * @return type Associative array of stocks from the database. 
     * Columns include Code, Name, Category, Value.
     */
    function all() {
        $this->db->order_by("value", "desc"); //order by value, descending
        $query = $this->db->get("stocks"); //get the stocks table
        return $query->result_array();
    }
}