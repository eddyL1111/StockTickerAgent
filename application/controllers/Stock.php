<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stock extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }
    /*
     * Initializes the stock view.
     */
    public function index()
    {
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
        $movements_data = $this->movements->find_recent_by_stock();
        $movements = array();
        $stock_code = 'recent';
        
        /// Get selected value from dropdown list
        if(isset($_POST['stock_type'])) 
        {
            $stock_code = $_POST['stock_type']; 
        }       
        
        if($stock_code == 'recent') 
        {
            foreach($movements_data as $data) // Displays most active
            {
                $movements[] = $this->set_movement($data);
            }
        }
        else 
        {
            foreach($movements_data as $data)
            {
                if($data['Code'] == $stock_code) // Filtering for type of stock 
                {
                    $movements[] = $this->set_movement($data);
                }
            }
        }
        $this->data['movements'] = $movements;
    }
    /*
     * Sets transaction data according to the type of stock from the most recent 
     * data. Default data is the most recent stock.
     */
    public function transactions() 
    {
        $transactions_data = $this->transactions->find_recent_by_stock();
        $transactions = array();
        $stock_code = 'recent';
        
        /// Get selected value from dropdown list
        if(isset($_POST['stock_type'])) 
        {
            $stock_code = $_POST['stock_type'];
        } 
        
        if($stock_code == 'recent') {
            foreach($transactions_data as $data) // Displays most active 
            {
                $transactions[] = $this->set_transaction($data);
            }
        }
        else 
        {
            foreach($transactions_data as $data)
            {
                if($data['Stock'] == $stock_code) // Filtering for type of stock
                { 
                    $transactions[] = $this->set_transaction($data);
                }
            }
        }
        $this->data['transactions'] = $transactions;
    }
    /*
     *  Converts database data into an array for the view.
     */
    public function stock_list() 
    {
        $stocks_data = $this->stocks->all();
        $stocks = array();

        foreach($stocks_data as $data) 
        {
            $stocks[] = array(
                'code'      => $data['Code'],
                'name'      => $data['Name'],
                'category'  => $data['Category'],
                'value'     => $data['Value']
            );
        }
        $this->data['stocks'] = $stocks; 
    }
    /*
     * Sets the movement data from the databse.
     * @return Array with transaction attributes.
     */
    public function set_movement($data) {
        $result = array(
            'datetime'  => $data['Datetime'],
            'code'      => $data['Code'],
            'action'    => $data['Action'],
            'amount'    => $data['Amount']
        ); 
        return $result;
    }
    
    /*
     * Sets the transaction data from the databse.
     * @return Array with transaction attributes.
     */
    private function set_transaction($data) {
        $result = array(
            'datetime'  => $data['DateTime'],
            'player'    => $data['Player'],
            'stock'     => $data['Stock'],
            'trans'     => $data['Trans'],
            'quantity'  => $data['Quantity']
        ); 
        return $result;
    }
    /*
     * Loads all necessary models and data for the layout.
     */
    private function init_setup() {
        $this->load->model('stocks');
        $this->load->model('players');
        $this->load->model('movements');
        $this->load->model('transactions');
        $this->data['pagebody'] = 'stocks';
        $this->data['title'] = 'Stocks';
        $this->data['page_title'] = 'Stock Ticker Agent';
        $this->data['active_tab'] = 'Stocks'; 
    }
}
