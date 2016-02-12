<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class MY_Controller extends CI_Controller {

	protected $data = array();	  // parameters for view components
	protected $id;				  // identifier for our content

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->data['title'] = 'Stock Ticker Agent';	// our default title
		$this->errors = array();
		$this->data['page_title'] = 'Stock Ticker Agent';   // our default page
                $this->data['active_tab'] = 'Overview';
	}

	/**
	 * Render this page by pulling different elements together 
         * and parsing/replacing {tags} with content from $this->data.
	 */
	function render()
	{
            $this->data['main_head'] = $this->parser->parse('css_js_view', $this->data, true);
            
            //Login state
            if ($this->session->userdata('name'))
            {
                //If logged in currently
                $info = array(
                    'name' => $this->session->userdata('name'), 
                    'url' => current_url() == '/' ? '' : current_url()
                    );
                $login = $this->parser->parse('_logged_in', $info, true);
            } else
            {
                //If logged out currently
                $info = array(
                    'url' => current_url() == '/' ? '' : current_url(),
                    'login_active' => $this->session->flashdata('login_active'),
                    'login_name' => $this->session->flashdata('login_name')
                    );
                $login = $this->parser->parse('_logged_out', $info, true);
            }
            
            
            //Nav bar
            $menu = $this->config->item('menu_choices');
            foreach ($menu['menudata'] as &$value)
            {
                if (strcmp($value['name'], $this->data['active_tab']) == 0)
                {
                    $value['active'] = 'active';
                }
            }
            $menu['login'] = $login;
            $this->data['main_navbar'] = $this->parser->parse('navbar', $menu, true);
            
            
            
            $this->data['main_content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
            
            // finally, build the browser page!
            $this->data['data'] = &$this->data;
            
            $this->parser->parse('_template', $this->data);
	}
        
        function login()
        {
            $this->load->model('players');
            
            $name = "";
            $pass = "";
            if ($this->input->post('password') != NULL && $this->input->post('username') != NULL) 
            {
                $name = $this->input->post('username');
                $pass = $this->input->post('password');
                //sanitize user input
                //$this->load->library('security');
                //$name = $this->security->xss_clean($name);
                //$pass = $this->security->xss_clean($pass);
            }
            //TODO: validate login information against players names
            //if valid information:
            if ($this->_isValidCredentials($name, $pass))
            {
                $this->session->set_userdata('pass', $this->input->post('password'));
                $this->session->set_userdata('name', $this->input->post('username'));
            } else
            {
                $this->session->set_flashdata('login_name', $name);
                $this->session->set_flashdata('login_active', '<script>showlogin();</script>');
                $this->session->set_flashdata('login_error', 'Invalid Credentials');
            }
            //else if invalid information:
            // save username in flashdata
            redirect($this->session->flashdata('redirectToCurrent'));
        }
        
        function _isValidCredentials($name, $pass)
        {
            return $this->players->hasName($name);
        }
        
        function logout()
        {
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('pass');
            redirect($this->session->flashdata('redirectToCurrent'));
        }
}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */