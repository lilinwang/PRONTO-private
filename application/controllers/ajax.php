<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function index()
    {
        exit('Access denied');
    }
	public function add_protocol(){	
		$data = json_decode(file_get_contents("php://input"));
		
		$notes = mysql_real_escape_string($data->notes);
		$series = mysql_real_escape_string($data->series);		
		$approved_by = mysql_real_escape_string($data->approved_by);
		$golive_date = mysql_real_escape_string($data->golive_date);
		$approval_date = mysql_real_escape_string($data->approval_date);
		$bodypart = mysql_real_escape_string($data->bodypart);
		$bodypart_full = mysql_real_escape_string($data->bodypart_full);		
		$description = mysql_real_escape_string($data->description);
		$code = mysql_real_escape_string($data->code);
		$protocol_name=mysql_real_escape_string($data->protocol_name);	
		$protocol_number=mysql_real_escape_string($data->protocol_number);	
		$indication=mysql_real_escape_string($data->indication);	
		$patient_orientation=mysql_real_escape_string($data->patient_orientation);	
		$landmark=mysql_real_escape_string($data->landmark);	
		$intravenous_contrast=mysql_real_escape_string($data->intravenous_contrast);	
		$scout=mysql_real_escape_string($data->scout);	
//echo json_encode($protocol_name);			
		/*$protocol_number=$this->input->post('protocol_number');
		$protocol_name=$this->input->post('protocol_name');
		$code=$this->input->post('code');
		$description=$this->input->post('description');
		$bodypart=$this->input->post('bodypart');
		$bodypart_full=$this->input->post('bodypart_full');
		$approval_date=$this->input->post('approval_date');
		$golive_date=$this->input->post('golive_date');
		$approved_by=$this->input->post('approved_by');
		$series=$this->input->post('series');		
		$notes=$this->input->post('notes');				
		$indication=$this->input->post('indication');
		$patient_orientation=$this->input->post('patient_orientation');
		$landmark=$this->input->post('landmark');
		$intravenous_contrast=$this->input->post('intravenous_contrast');
		$scout=$this->input->post('scout');*/
		
		//echo $user_id;
		$this->load->model('protocol_ct_model');				
		$result= $this->protocol_ct_model->insert_new($protocol_number,$protocol_name,$code,$description,$bodypart,$bodypart_full,$approval_date,$golive_date,$approved_by,$series,$notes,$indication,$patient_orientation,$landmark,$intravenous_contrast,$scout);			
		echo json_encode($result);			
	}
	function get_protocol(){	
		$data = json_decode(file_get_contents("php://input"));
		
		$modality = mysql_real_escape_string($data->modality);
		$bodypart_full = mysql_real_escape_string($data->bodypart_full);	
		if ($modality=="CT"){
			$this->load->model('protocol_ct_model');				
			$result= $this->protocol_ct_model->get_list_by_bodypart($bodypart_full);		
		}else{
			$this->load->model('protocol_mr_model');				
			$result= $this->protocol_mr_model->get_list_by_bodypart($bodypart_full);		
		}
			
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
