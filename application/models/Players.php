<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Players extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Retrieve all information on all stocks in the database.
     * @return type Associative array of stocks from the database. 
     * Columns include Code, Name, Category, Value.
     */
    function all() {
        $this->db->order_by("Player", "desc"); //order by player, descending
        $query = $this->db->get("players"); //get the players table
        return $query->result_array();
    }
}