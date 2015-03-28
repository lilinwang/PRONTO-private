<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sign_up_web extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		header('Content-Type: text/html;charset=utf-8');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->library('session');
	}
	public function index() {
		date_default_timezone_set("EST");
        $time_stamp = date("Y-m-d H:i:s");
       	
        $user_name = $this->input->post('user_name');
        $password = sha1( $this->input->post('password').$time_stamp);    
             
		$this->load->model('user_model');		
		
		$result=$this->user_model->check($this->input->post('user_name'));            
        if(!$result){ 
			
			$this->user_model->register_simple($user_name,$password,$time_stamp);
			$row = $this->user_model->get_exposable_row_by_username($user_name);
            $this->session->set_userdata('is_logged_in', true);
            $this->session->set_userdata('user_id', $row['user_id']);			               
			$this->session->set_userdata('user_name', $user_name);
			$this->load->view('home');
			return;
		}
		else {
			$data['sign_up_prompt']='the user name has been used, please change another one.';
			$data['login_prompt']="";
            $this->load->view('welcome',$data);
			return;
			
			
		}	 
    }

}
?>
