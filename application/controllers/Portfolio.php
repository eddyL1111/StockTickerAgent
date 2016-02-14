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
        $this->holdings2();
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
    }
    
    public function holdings()
    {
        $holding_data = $this->transactions->all();
        $holding = array(
                            'stock'     => null,
                            'amount'  => null
                        );
        
        $selectedPlayer = 'recent';
        
        if(isset($_POST['player_info']))
        {
            $selectedPlayer = $_POST['player_info'];
        }
        
        if($selectedPlayer == 'recent') 
        {
            
        }
        else
        {
            foreach($holding_data as $data)
            {
                if($data['Player'] == $selectedPlayer)
                {
                    if(array_key_exists($data['Stock'], $holding['stock'])){
                        $stock_index = array_search($data['Stock'], $holding_data[sto]);
                        $holding['Quantity'][$stock_index] += $data['Quantity'];
                    } else {
                        $holding[] = array(
                            'stock'     => $data['Stock'],
                            'amount'  => $data['Quantity']
                        );
                    }
                }
            }
        }
        $this->data['holdings'] = $holding;
    }
    
    public function holdings2()
    {
        $holding_data = $this->transactions->all();
        $holding = array();
        $curHolding = array();
        
        $selectedPlayer = 'recent';
        
        if(isset($_POST['player_info']))
        {
            $selectedPlayer = $_POST['player_info'];
        }
        
        if($selectedPlayer == 'recent') 
        {
            
        }
        else
        {
            foreach($holding_data as $data)
            {
                if($data['Player'] == $selectedPlayer)
                {
                    if($data['Trans'] == "buy") 
                    {
                        if(array_key_exists($data['Stock'], $holding))
                        {
                            $holding[$data['Stock']]->amount += $data['Stock'];
                        }
                        else
                        {
                            $holding[] = array(
                            'stock'     => $data['Stock'],
                            'amount'  => 0 + $data['Quantity']
                            );
                        }
                    }else
                    {
                        if(array_key_exists($data['Stock'], $holding))
                        {
                            $holding[$data['Stock']]->amount -= $data['Stock'];
                        }
                        else
                        {
                            $holding[] = array(
                            'stock'     => $data['Stock'],
                            'amount'  => 0 - $data['Quantity']
                            );
                        }
                    }
                }
            }
        }
        $this->data['holdings'] = $holding;
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
        
        if($selectedPlayer == 'recent') 
        {
            foreach($activity_data as $data)
            {
                $activity[] = array(
                 'datetime'      => $data['DateTime'],
                 'stock'         => $data['Stock'],
                 'transaction'   => $data['Trans'],
                 'quantity'      => $data['Quantity']
                );
            }
        }
        else
        {
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
        }
        $this->data['transactions'] = $activity;
    }
}