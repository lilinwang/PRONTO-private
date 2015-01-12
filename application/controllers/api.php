<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
    }
	
	public function index() {
		exit('Access denied');        
    }	
	public function protocol(){
		$name = $this->input->get('name');
		//echo $name;
		$this->load->model('protocol_model');	
		$info=$this->protocol_model->get_report_description_by_name($name);
		
		$data['data']=$info;
		echo json_encode($data);     
		return;
	}
	public function protocolNum(){
		$number = $this->input->get('number');
		//echo $name;
		$this->load->model('protocol_model');	
		$info=$this->protocol_model->get_report_description_by_number($number);
		
		$data['data']=$info;
		echo json_encode($data);     
		return;
	}
}