<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BSX extends CI_Model {
    
    protected $xml = null;
    protected $round = null;
    protected $state = null;
    protected $countdown = null;
    
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH.'bsx.xml');
        
        $this->round = $this->xml->round;
        $this->state = $this->xml->state;
        $this->countdown = $this->xml->countdown;
    }
    
    public function getRound() {
        return $this->round;
    }
    
    public function getState() {
        return $this->state;
    }
    
    public function getCountdown() {
        return $this->countdown;
    }
}