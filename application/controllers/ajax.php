<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function index()
    {
        exit('Access denied');
    }
	public function add_protocal(){	
		/*$data = json_decode(file_get_contents("php://input"));
		$notes = mysql_real_escape_string($data->notes);
		$series = mysql_real_escape_string($data->series);
		$scan_position = mysql_real_escape_string($data->scan_position);
		$approved_by = mysql_real_escape_string($data->approved_by);
		$golive_date = mysql_real_escape_string($data->golive_date);
		$approval_date = mysql_real_escape_string($data->approval_date);
		$bodypart = mysql_real_escape_string($data->bodypart);
		$bodypart_full = mysql_real_escape_string($data->bodypart_full);
		$modality = mysql_real_escape_string($data->modality);
		$description = mysql_real_escape_string($data->description);
		$code = mysql_real_escape_string($data->code);
		$protocal_name=mysql_real_escape_string($data->protocal_name);		
		/*$protocal_name=$this->input->post('protocal_name');*/
		$code=$this->input->post('code');
		$description=$this->input->post('description');
		$modality=$this->input->post('modality');
		$bodypart=$this->input->post('bodypart');
		$bodypart_full=$this->input->post('bodypart_full');
		$approval_date=$this->input->post('approval_date');
		$golive_date=$this->input->post('golive_date');
		$approved_by=$this->input->post('approved_by');
		$series=$this->input->post('series');
		$scan_position=$this->input->post('scan_position');
		$notes=$this->input->post('notes');
		//echo $user_id;
		$this->load->model('protocal_model');				
		$result= $this->protocal_model->insert_new($protocal_name,$code,$description,$modality,$bodypart,$bodypart_full,$approval_date,$golive_date,$approved_by,$series,$scan_position,$notes);			
		echo json_encode($result);			
	}
	function get_list(){	
		$user_id=$_POST['user_id'];
		//echo $user_id;
		$this->load->model('protocal_model');				
		$result= $this->protocal_model->get_list_by_id($user_id);			
		echo json_encode($result);		
		
	}
	
    function get_profile()
	{
		$this->load->model('user_model');
		$data['company_id']=$this->user_model->get_id_by_name($_POST['company_name']);
		$list= $this->user_model->get_focus_by_id($data['company_id']);
		
		$data['focus_list']=explode('|',substr($list,1,strlen($list)-2));
		echo json_encode($data);
	}		
}
