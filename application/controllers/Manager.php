<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Agent/app management used only for admins
 */
class Manager extends MY_Controller {
    
    function __construct() 
    {
        parent::__construct();
        $this->restrict(array(ROLE_ADMIN));
    }
    
    public function index() 
    {
        $this->init_setup();        
        
        // Retrieving data to display server information
        $this->data['state'] = $this->bsx->getState();
        $this->data['round'] = $this->bsx->getRound();
        $this->data['countdown'] = $this->bsx->getCountdown();
        $this->data['desc'] = $this->bsx->getDesc();
        $this->data['current'] = $this->bsx->getCurrent();
        $this->data['duration'] = $this->bsx->getDuration();
        $this->data['upcoming'] = $this->bsx->getUpcoming();
        $this->data['alarm'] = $this->bsx->getAlarm();
        $this->data['now'] = $this->bsx->getNow();
        
        $this->render();
    }
    
    // Retrieving status in .csv and downloading it as .xml
    private function download_bsx_xml() {
        $source = file_get_contents(STATUSDATA_URL);
        file_put_contents(DATAPATH.'bsx.xml', $source);
    }
    
    // Downloads latest stock data as csv file from server
    public function download_stockdata_csv() {
        $source = file_get_contents(STOCKDATA_URL); 
        file_put_contents(DATAPATH.'stock.csv', $source);
        redirect('manager'); // Don't want the ugly function name in url
    }
    
    // Downloads latest movement data as csv file from server
    public function download_movement_csv() {
        $source = file_get_contents(MOVEMENTDATA_URL); 
        file_put_contents(DATAPATH.'movement.csv', $source);
        redirect('manager');// Don't want the ugly function name in url
    }
    
    // Downloads latest transactions data as csv file from server
    public function download_transactions_csv() {
        $source = file_get_contents(TRANSACTIONSDATA_URL); 
        file_put_contents(DATAPATH.'transactions.csv', $source);
        redirect('manager');// Don't want the ugly function name in url
    }
    
    // Initializes everything necessary for the rendering the view
    private function init_setup() 
    {
        $this->download_bsx_xml(); // download xml before loading the model
        $this->load->model('bsx');
        $this->data['pagebody'] = 'manager';
        $this->data['title'] = 'Manager';
        $this->data['page_title'] = 'Agent Management';
        $this->data['active_tab'] = 'Manager';
        $this->session->set_flashdata('redirectToCurrent', current_url());
    }
    
    
}