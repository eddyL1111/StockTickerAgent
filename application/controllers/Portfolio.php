<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Portfolio extends MY_Controller {
    function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->load->model('stocks');
        $this->load->model('players');
        $this->data['pagebody'] = 'portfolio';
        $this->data['title'] = 'Portfolio';
        $this->data['page_title'] = 'Stock Ticker Agent';
        $this->data['active_tab'] = 'Portfolio';

        //Assemble the page and spit back to user!  See MY_Controller for render().
        $this->render();
    }
}