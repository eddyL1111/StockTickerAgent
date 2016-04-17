<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->init_setup();
        
        // Posts the data to connect to the server if there 
        // was no prveious session.
        if(!isset( $this->session->userdata['team'])
        && !isset( $this->session->userdata['token'])
        &&  isset( $_POST['userid']))
        {
            // Sends post data and retrieves the token
            $xml_str = $this->get_token(); 
            $token = $this->security->xss_clean($xml_str->token);
            $team = $this->security->xss_clean($xml_str->team);
            $name = $this->security->xss_clean($this->input->post('username'));
            
            if($token == '') { // Redirects if password was wrong
                redirect('registration');
            } else {
                $this->session->set_userdata('token', $token);
                $this->session->set_userdata('team_id', $team);
                $this->session->set_userdata('team_name', $name);
            }
        } 
            
        // If there app was previously connected do not show the app 
        // registration form, but a page displaying the current logged in team.
        if (isset( $this->session->userdata['token'])){
            $this->data['pagebody'] = 'app_status';
            $this->data['team'] = $this->session->userdata['team_id']; 
            $this->data['name'] = $this->session->userdata['team_name']; 
            $this->data['token'] = $this->session->userdata['token'];  
        }
                 
        
        $this->render();
    }

    /**
     * Destroys the team session.
     */
    public function disconnect() {
        $this->session->unset_userdata('team_id');
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('team_name');
        redirect('registration');
    }
    
    /*
     * Retrieves token in xml form after registering to the BSX server.
     * @return: xml data in string - array/data form
     */
    private function get_token() { 
        $postdata = http_build_query( array(
            'team' => $_POST['userid'],
            'name' => $_POST['username'],
            'password' => $_POST['password'],
        ));

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $xml = file_get_contents(REGISTER_URL, false, $context);
        return simplexml_load_string($xml);
    }
    
    /*
     * Initializes the components for the view.
     */
    private function init_setup() {
        $this->data['pagebody'] = 'registration';
        $this->data['title'] = 'Registration';
        $this->data['page_title'] = 'App Registration';
        $this->data['active_tab'] = 'Regitration'; 
        $this->session->set_flashdata('redirectToCurrent', current_url());
    }
    
   
}
    
