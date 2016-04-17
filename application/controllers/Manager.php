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
        $this->read_server_status();
        
        $this->render();
    }
    
    // Retrieving status in .csv and downloading it as .xml
    public function download_bsx_xml() {
        $source = file_get_contents(STATUSDATA_URL);
        file_put_contents(DATAPATH.'bsx.xml', $source);
        redirect('manager');
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
        $this->data['pagebody'] = 'manager';
        $this->data['title'] = 'Manager';
        $this->data['page_title'] = 'Agent Management';
        $this->data['active_tab'] = 'Manager';
        $this->session->set_flashdata('redirectToCurrent', current_url());
    }
    
    private function read_server_status() {
        $xml = file_get_contents(STATUSDATA_URL);
        $xml_str = simplexml_load_string($xml);
        
        $this->data['state'] = $xml_str->state;
        $this->data['round'] = $xml_str->round;
        $this->data['countdown'] = $xml_str->countdown;
        $this->data['desc'] = $xml_str->desc;
        $this->data['current'] = $xml_str->current;
        $this->data['duration'] = $xml_str->duration;
        $this->data['upcoming'] = $xml_str->upcoming;
        $this->data['alarm'] = $xml_str->alarm;
        $this->data['now'] = $xml_str->now;
    }
    
}