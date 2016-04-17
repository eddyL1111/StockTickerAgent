<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends My_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('users');
    }
    
    public function index() {
       $this->init_setup();
       
       if(isset($_POST['username'])) {
           $this->data['token'] = $_POST['username'];
       }
       
       $this->render();
    }
    
    public function sending() {
        $data = array(
            'userid'    => $_POST['userid'],
            'username'  => $_POST['username'],
            'password'  => $_POST['password1'],
            'role'      => ROLE_PLAYER
         );
        $this->signup_m->add($data); 
        redirect('');
    }
    
    private function init_setup() {
        $this->data['pagebody'] = 'sign_up';
        $this->data['title'] = 'Signup';
        $this->data['page_title'] = 'Sign Up';
        $this->data['active_tab'] = 'Signup';
        $this->session->set_flashdata('redirectToCurrent', current_url());
    }
}