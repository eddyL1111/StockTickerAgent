<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    
        function __construct()
        {
            parent::__construct();
            //$this->restrict(array(ROLE_ADMIN, ROLE_PLAYER));
        }
    
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
            $this->load->model('stocks');
            $this->load->model('players');
            $this->data['pagebody'] = 'overview';
            $this->data['title'] = 'Overview';
            $this->data['page_title'] = 'Stock Ticker Agent';
            $this->data['active_tab'] = 'Overview';
            $this->session->set_flashdata('redirectToCurrent', current_url());
            
            //Load the stock information and save it in the 'stocks' $this->data index
            $source = $this->stocks->all();
            $this->data['stocks'] = $source;
            
            //Load the player information and save it in the 'players' $this->data index
            $source = $this->players->all();
            $players = array();
            foreach ($source as $row)
            {
                $players[] = array('name' => $row->Player, 'cash' => $row->Cash);
            }
            $this->data['players'] = $players;
            
            //Assemble the page and spit back to user!  See MY_Controller for render().
            $this->render();
        }
}
