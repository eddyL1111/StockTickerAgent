<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller, rendering the website template
 *
 * @author		JoePelz
 * @copyright           2016, Joe Pelz
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
            $this->data['main_navbar'] = $this->_render_navbar();
            $this->data['main_content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
            
            // finally, build the browser page!
            $this->data['data'] = &$this->data;
            
            $this->parser->parse('_template', $this->data);
	}
        
        /**
         * Render the html of the navbar for the given webpage.
         * @return html The navbar for the website including menu and login/out options
         */
        function _render_navbar() 
        {
            //Nav bar
            $menu = $this->config->item('menu_choices');
            foreach ($menu['menudata'] as &$value)
            {
                if (strcmp($value['name'], $this->data['active_tab']) == 0)
                {
                    $value['active'] = 'active';
                }
            }
            
            $menu['login'] = $this->_render_login();
            return $this->parser->parse('navbar', $menu, true);
        }
        
        /**
         * Render the login elements of the screen, including a login or 
         * logout button and message depeding on session information.
         * @return html login button or message, with modal dialog attached
         */
        function _render_login() 
        {
            //Login state
            if ($this->session->userdata('name'))
            {
                //If logged in currently
                $info = array(
                    'name' => $this->session->userdata('name'), 
                    'url' => current_url() == '/' ? '' : current_url()
                    );
                $result = $this->parser->parse('_logged_in', $info, true);
            } else
            {
                //If logged out currently
                $info = array(
                    'url' => current_url() == '/' ? '' : current_url(),
                    'login_active' => $this->session->flashdata('login_active'),
                    'login_name' => $this->session->flashdata('login_name'),
                    'login_errors' => $this->session->flashdata('login_errors') == FALSE ? '' : $this->parser->parse('_error_message', array('error_array' => $this->session->flashdata('login_errors')), true),
                    'login_errors_visible' => $this->session->flashdata('login_errors') == FALSE ? '' : 'visible'
                    );
                $result = $this->parser->parse('_logged_out', $info, true);
            }
            return $result;
        }
        
        /**
         * Attempts to log the player in via post data "username" and "password"
         * redirects to previous page on success and failure
         */
        function login()
        {
            $this->load->model('players');
            $this->session->set_flashdata('errors', array());
            $this->data['errors'] = array();
            $name = $this->input->post('username');
            $pass = $this->input->post('password');
            
            //sanitize input of XSS attacks
            $name = $this->security->xss_clean($name);
            $pass = $this->security->xss_clean($pass);
            
            //empty data is invalid
            if ($name == NULL || $pass == NULL || strlen($name) == 0 || strlen($pass) == 0) 
            {
                if ($name == NULL || strlen($name) == 0)
                {
                    array_push($this->data['errors'], array('message' => "Username must have a value"));
                } else
                {
                    $this->session->set_flashdata('login_name', $name);
                }
                if ($pass == NULL || strlen($pass) == 0)
                {
                    array_push($this->data['errors'], array('message' => "Password must have a value"));
                }
                $this->session->set_flashdata('login_active', '<script>showlogin();</script>');
                $this->session->set_flashdata('login_errors', $this->data['errors']);
                redirect($this->session->flashdata('redirectToCurrent'));
            }
            
            //Validate login credentials database of player names
            if ($this->_isValidCredentials($name, $pass))
            {
                $this->session->set_userdata('pass', $this->input->post('password'));
                $this->session->set_userdata('name', $this->input->post('username'));
            } else
            {
                $this->session->set_flashdata('login_name', $name);
                $this->session->set_flashdata('login_active', '<script>showlogin();</script>');
                $this->session->set_flashdata('login_errors', $this->data['errors']);
            }
            
            //send back to previous page
            redirect($this->session->flashdata('redirectToCurrent'));
        }
        
        /**
         * Test the given credentials against the 
         * database of valid login information
         * @param type $name The username of the user logging in
         * @param type $pass The password of the user logging in
         * @return boolean TRUE if credentials are valid
         */
        function _isValidCredentials($name, $pass)
        {
            $errors = $this->data['errors'];
            array_push($errors, array('message' => "Incorrect password or username"));
            $this->data['errors'] = $errors;
            
            return $this->players->hasName($name);
        }
        
        /**
         * Log the user out by unsetting session data and redirecting to previous page.
         */
        function logout()
        {
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('pass');
            redirect($this->session->flashdata('redirectToCurrent'));
        }
}
