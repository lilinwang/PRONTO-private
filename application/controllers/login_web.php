<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_web extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
    }
	
	public function index() {
				
        // get post params
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');
        
        // load model
        
		$this->load->model('user_model');	
	
	    // validate login params
		$result = $this->user_model->login($user_name, $password);
        if ($result >0) { // login success
            // update session
            $row = $this->user_model->get_exposable_row_by_username($user_name);
            $this->session->set_userdata('is_logged_in', true);
            $this->session->set_userdata('user_id', $row['user_id']);   
			$this->session->set_userdata('user_name', $user_name);  
            $this->load->view('home');
			return;
        }
        else {		//login fail
			$data['login_prompt']='user name or password is not correct!';
			$data['sign_up_prompt']="";
			$this->load->view('welcome',$data);
			return;
        }
    }	
}