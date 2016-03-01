<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Players extends MY_Model {
    function __construct() {
        parent::__construct("players", "Player");
    }
    
    /**
     * Checks for the existance of a given username in the player table.
     * @param type $name
     * @return boolean True if the name exists in the database
     */
    function hasName($name) {
        //mysql database sql injection prevention
        return exists(mysql_real_escape_string($name));
    }
}