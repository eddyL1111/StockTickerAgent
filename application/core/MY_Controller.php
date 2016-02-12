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
            $this->session->set_flashdata('redirectToCurrent', current_url());
	}

	/**
	 * Render this page by pulling different elements together 
         * and parsing/replacing {tags} with content from $this->data.
	 */
	function render()
	{
            $this->data['main_head'] = $this->parser->parse('css_js_view', $this->data, true);
            $this->data['main_navbar'] = $this->parser->parse('navbar', $this->data, true);
            $this->data['main_content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
            
            //parser->parse(filename, associative array, true);
            //$this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'), true);
            //$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
            
            // finally, build the browser page!
            $this->data['data'] = &$this->data;
            
            $this->parser->parse('_template', $this->data);
	}
        
        function login()
        {
            //TODO: validate login information
            if ($this->input->post('password') != NULL && $this->input->post('username') != NULL) 
            {
                $this->session->set_userdata('pass', $this->input->post('password'));
                $this->session->set_userdata('name', $this->input->post('username'));
            }
            redirect($this->session->flashdata('redirectToCurrent'));
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