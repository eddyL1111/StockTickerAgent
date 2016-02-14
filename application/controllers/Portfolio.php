<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Portfolio extends MY_Controller {
    function __construct() 
    {
        parent::__construct();
        $this->load->helper('url');
    }
    public function index() 
    {
        $this->init_setup();
        
        $this->player_list();
        $this->activity();
        $this->holdings();
        $this->render();
    }
    
    public function player_list() 
    {
        $player = $this->players->all();
        $players = array();
        
        foreach($player as $data)
        {
            $players[] = array(
                'player'    => $data['Player'],
                'cash'      => $data['Cash']
            );
        }
        $this->data['players'] = $players;
    }
    
    private function init_setup() 
    {
        $this->load->model('players');
        $this->load->model('transactions');
        $this->data['pagebody'] = 'portfolio';
        $this->data['title'] = 'Portfolio';
        $this->data['page_title'] = 'Stock Ticker Agent';
        $this->data['active_tab'] = 'Portfolio';
        $this->data['name'] = $this->session->userdata('name');
    }
    
    public function holdings()
    {
        $holding_data = $this->transactions->all();
        //$holder = array();
        $stock = array();
        $amount = array();
        $trans = array();
            
        
        $selectedPlayer = 'recent';
        
        if(isset($_POST['player_info']))
        {
            $selectedPlayer = $_POST['player_info'];
        }

                
        if(is_null($selectedPlayer) || $selectedPlayer == 'recent') 
        {
            $selectedPlayer = $this->session->userdata('name');
        }
        
        foreach($holding_data as $data) { // $data is an array
            if($selectedPlayer != $data['Player']) {
                continue;
            }
            array_push($stock, $data['Stock']);
            array_push($amount, $data['Quantity']);
            array_push($trans, $data['Trans']);  
        }
        
        for($i=0; $i < sizeof($stock); $i++) {    
           if($trans[$i] == 'sell') {
               $amount[$i] *= (-1);
           }
        }
        
        $holder = array();
        $new_stock = array();
        $new_amount = array();
        for($i=1; $i < sizeof($stock); $i++) {  
            if($i-1 == 0) {
                array_push($new_stock, $stock[$i-1]);
                array_push($new_amount, $amount[$i-1]);
            }
            
            if(in_array($stock[$i], $new_stock)) {
                $index = array_search($stock[$i], $new_stock);
                $new_amount[$index] += $amount[$i];
            } else {
                array_push($new_stock, $stock[$i]);
                array_push($new_amount, $amount[$i]);
            }
        }
        
        for($i=0; $i < sizeof($new_stock); $i++) {
            
             $holder[] = array(
                'stock' => $new_stock[$i],
                'amount' => $new_amount[$i]
            );
        }
       
        $this->data['holdings'] = $holder;
    }
    
    
    public function activity() 
    {
        $activity_data = $this->transactions->all();
        $activity = array();
        
        $selectedPlayer = 'recent';
        
        if(isset($_POST['player_info']))
        {
            $selectedPlayer = $_POST['player_info'];
        }
        
        if(is_null($selectedPlayer) || $selectedPlayer == 'recent') 
        {
            $selectedPlayer = $this->session->userdata('name');
        }
        
        foreach($activity_data as $data)
        {
            if($data['Player'] == $selectedPlayer) // Filtering for type of stock
            { 
                $activity[] = array(
                 'datetime'      => $data['DateTime'],
                 'stock'         => $data['Stock'],
                 'transaction'   => $data['Trans'],
                 'quantity'      => $data['Quantity']
                );
            }
        }
        $this->data['transactions'] = $activity;
    }
}