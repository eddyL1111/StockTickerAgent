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
    protected $description = null;
    protected $current = null;
    protected $duration = null;
    protected $upcoming = null;
    protected $alarm = null;
    protected $now = null;
    
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH.'bsx.xml');
        
        $this->round = $this->xml->round;
        $this->state = $this->xml->state;
        $this->countdown = $this->xml->countdown;
        $this->description = $this->xml->desc;
        $this->current = $this->xml->current;
        $this->duration = $this->xml->duration;
        $this->upcoming = $this->xml->upcoming;
        $this->alarm = $this->xml->alarm;
        $this->now = $this->xml->now;
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
    
    public function getDesc() {
        return $this->description;
    }
    
    public function getCurrent() {
        return $this->current;
    }
    
    public function getDuration() {
        return $this->duration;
    }
    
    public function getUpcoming() {
        return $this->upcoming;
    }
    
    public function getAlarm() {
        return $this->alarm;
    }
    
    public function getNow() {
        return $this->now;
    }
}