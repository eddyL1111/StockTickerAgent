<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stocks extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
    }
    public function index() {
        
        $this->load->view('welcome_message');
        $this->load->view('css_js_view');
        $this->load->view('navbar');
        $this->load->view('stocks');
    }
}