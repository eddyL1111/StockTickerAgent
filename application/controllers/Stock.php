<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stock extends MY_Controller {
    private $stock_code;
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }
    /*
     * Initializes the stock view.
     */
    public function index($code = 'recent')
    {
        $this->stock_code = $code;
        $this->init_setup(); // e.g Loading data and models
        $this->stock_list(); // List data of stocks for view
        $this->movement(); // Data for movement table
        $this->transactions(); // Data for transactions table
        
        //Assemble the page and spit back to user!  See MY_Controller for render().
        $this->render();
    }
    /*
     * Sets movement data according to the type of stock from the most recent 
     * data. Default data is the most recent stock.
     */
    public function movement()
    {
        $movement_data = $this->movements->find_recent_by_stock();
        if (count($movement_data) > 20) {
            $movement_data_short = array_slice($movement_data, 0, 20);
        } else if (count($movement_data) == 0) {
            $movement_data_short = array();
            //Could add dummy entry
            //"seq","datetime","code","action","amount"
            /*
            $movement_data_short = array(
                'seq' => 'no data',
                'datetime' => 0,
                'code' => 'no data',
                'action' => 'no data',
                'amount' => 'no data'
            );
            */
        } else {
            $movement_data_short = $movement_data;
        }
        
        //change format of datetime field
        foreach($movement_data_short as $key=>$value) {
            $dt = new DateTime();
            $dt->setTimestamp($value['datetime']);
            $movement_data_short[$key]['datetime'] = $dt->format('Y-m-d H:i:s');
        }
        
        $this->data['movements'] = $movement_data_short;
    }
    /*
     * Sets transaction data according to the type of stock from the most recent 
     * data. Default data is the most recent stock.
     */
    public function transactions() 
    {
        $transaction_data = $this->transactions->find_recent_by_stock();
        if (count($transaction_data) > 20) {
            $transaction_data_short = array_slice($transaction_data, 0, 20);
        } else if (count($transaction_data) == 0) {
            $transaction_data_short = array();
            //could add dummy entry...
            //"seq","datetime","agent","player","stock","trans","quantity"
            /*
            $transaction_data_short[] = array(
                'seq' => ' ',
                'datetime' => 0,
                'agent' => ' ',
                'player' => ' ',
                'stock' => ' ',
                'trans' => ' ',
                'quantity' => ' '
            );
            */
        } else {
            $transaction_data_short = $transaction_data;
        }
        
        //change format of datetime field
        foreach($transaction_data_short as $key=>$value) {
            $dt = new DateTime();
            $dt->setTimestamp($value['datetime']);
            $transaction_data_short[$key]['datetime'] = $dt->format('Y-m-d H:i:s');
        }
        
        $this->data['transactions'] = $transaction_data_short;
    }
    /*
     *  Converts database data into an array for the view.
     */
    public function stock_list() 
    {
        $this->data['stocks'] = $this->stocks->all('desc');
    }
    /*
     * Loads all necessary models and data for the layout.
     */
    private function init_setup() {
        $this->load->model('stocks');
        $this->load->model('movements');
        $this->load->model('transactions');
        $this->data['pagebody'] = 'stocks'; //load the stocks page fragment
        $this->data['active_tab'] = 'Stocks'; //which menu tab to have highlighted
        
        if (strcmp($this->stock_code, 'recent') == 0) {
            $this->data['page_title'] = 'Stock History';  //The title for the specific page
            $this->data['title'] = 'Stocks'; //Use "Stocks" for the tab/window name
        } else {
            $this->data['page_title'] = 'Stock History - '.$this->stock_code;  //The title for the specific page
            $this->data['title'] = 'Stocks ('.$this->stock_code.')'; //Use "Stocks" for the tab/window name
        }
        $this->session->set_flashdata('redirectToCurrent', current_url());
    }
}
