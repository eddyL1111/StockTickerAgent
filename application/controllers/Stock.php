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
    public function index()
    {
        $this->load->model('stocks');
        $this->load->model('players');
        $this->data['pagebody'] = 'stocks';
        $this->data['title'] = 'Stocks';
        $this->data['page_title'] = 'Stock Ticker Agent';
        $this->data['active_tab'] = 'Stocks';

        $this->convert_db_data();
                
        //Assemble the page and spit back to user!  See MY_Controller for render().
        $this->render();
    }

    public function movement()
    {
        $this->data['pagebody'] = 'justone';


        $this->render();
    }

    public function transactions() 
    {

    }

    /* Converts database data into an array for the view.
     * 
     */
    public function convert_db_data() 
    {
        $stock_data = $this->stocks->all();
        $stocks = array();

        foreach($stock_data as $item) {
            $stocks[] = array(
                'code' => $item['Code'],
                'name' => $item['Name'],
                'category' => $item['Category'],
                'value' => $item['Value']
                );
        }
        $this->data['stocks'] = $stocks;
    }

}