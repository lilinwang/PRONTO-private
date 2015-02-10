<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	function __construct() {
        parent::__construct();
		$this->load->model('series_ct_model');
		$this->load->model('series_mr_model');
        $this->load->library('csvimport');
		$this->load->library('session');
    }
	
    function index()
    {
        exit('Access denied');
    }
	/*public function add_protocol(){	
		$data = json_decode(file_get_contents("php://input"));
		$this->load->model('protocol_model');	
		$protocol_data = array(
                        'protocol_name'=>mysql_real_escape_string($data->protocol_name),
                        'protocol_number'=>mysql_real_escape_string($data->protocol_number),
                        'code'=>(mysql_real_escape_string($data->code)==null)?NULL:mysql_real_escape_string($data->code),
                        'description'=>mysql_real_escape_string($data->description),
						'modality'=>mysql_real_escape_string($data->modality),
                        'bodypart'=>mysql_real_escape_string($data->bodypart),
                        'bodypart_code'=>NULL,
                        'bodypart_full'=>mysql_real_escape_string($data->bodypart_full),
						'approval_date'=>(mysql_real_escape_string($data->approval_date)==null)?NULL:mysql_real_escape_string($data->approval_date),
                        'golive_date'=>(mysql_real_escape_string($data->golive_date)==null)?NULL:mysql_real_escape_string($data->golive_date),
                        'approved_by'=>mysql_real_escape_string($data->approved_by)                       
        );	
		$series_data = array(
						'series_id'=>mysql_real_escape_string($data->series),
                        'indication'=>mysql_real_escape_string($data->indication),
                        'patient_orientation'=>mysql_real_escape_string($data->patient_orientation),
                        'landmark'=>mysql_real_escape_string($data->landmark),
                        'intravenous_contrast'=>mysql_real_escape_string($data->intravenous_contrast),
						'scout'=>mysql_real_escape_string($data->scout),
                        'scanning_mode'=>NULL,
                        'range_direction'=>NULL,
                        'gantry_angle'=>NULL,
						'algorithm'=>NULL,
                        'collimation'=>NULL,
                        'slice_thickness'=>NULL,
                        'interval'=>NULL,
						'table_speed'=>NULL,
                        'pitch'=>NULL,
						'kvp'=>NULL,
                        'am'=>NULL,
						'noise_reduction'=>NULL,
                        'rotation_time'=>NULL,
                        'scan_fov'=>NULL,
						'display_fov'=>NULL,
                        'post_processing'=>NULL,
						'transfer_images'=>NULL,
                        'notes'=>mysql_real_escape_string($data->notes),
						'protocol_number'=>mysql_real_escape_string($data->protocol_number)
        );
		$result= $this->protocol_model->insert_new($protocol_data,mysql_real_escape_string($data->protocol_number));
		$this->load->model('series_ct_model');	
        $this->series_ct_model->insert_new($series_data,mysql_real_escape_string($data->series));
		
		echo json_encode($result);			
	}
	*/
	function get_record(){
		$data = json_decode(file_get_contents("php://input"));
		
		$time_start = mysql_real_escape_string($data->time_start);
		$time_end = mysql_real_escape_string($data->time_end);			
		$this->load->model('record_model');				
		$result= $this->record_model->get_list_by_range($time_start,$time_end);
		echo json_encode($result);	
	}
	function get_protocol(){	
		$data = json_decode(file_get_contents("php://input"));
		
		$modality = mysql_real_escape_string($data->modality);
		$bodypart_full = mysql_real_escape_string($data->bodypart_full);			
		$this->load->model('protocol_model');				
		$result= $this->protocol_model->get_list_by_bodypart($bodypart_full,$modality);		
		
			
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
	function search_protocol(){
		$data = json_decode(file_get_contents("php://input"));
		
		$content = mysql_real_escape_string($data->content);
		//echo $content;		
		$this->load->model('protocol_model');				
		$result= $this->protocol_model->get_list_by_keywords($content);						
		echo json_encode($result);		
	}		
	
	function upload(){	
		$config['allowed_types'] = 'csv';
		if ( 0 < $_FILES['file']['error'] ) {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
			return;
		}
		else {
			$dest='uploads/'.$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'],$dest);							
		}					
		 
		$user_name=$this->session->userdata('user_name');
		 
        $file_path = $dest;
		
		$this->load->model('protocol_model');
		
        if ($this->csvimport->get_array($file_path)) {
			$csv_array = $this->csvimport->get_array($file_path);
			$imported_protocols=array(array(),array(),array());
			//$imported_status=array();
			foreach ($csv_array as $row) {	
				$protocol_data = array(
                        'protocol_name'=>$row['Protocol Name'],
                        'protocol_number'=>$row['Protocol ID'],
                        'code'=>($row['Code']==null)?NULL:$row['Code'],
                        'description'=>$row['Description'],
						'modality'=>$row['Modality'],
                        'bodypart'=>$row['BodyPart'],
                        'bodypart_code'=>($row['BodyPart Code']==null)?NULL:$row['BodyPart Code'],
                        'bodypart_full'=>$row['BodyPart Full'],
						'approval_date'=>($row['Approval Date']==null)?NULL:$row['Approval Date'],
                        'golive_date'=>($row['Go-Live Date']==null)?NULL:$row['Go-Live Date'],
                        'approved_by'=>$row['Approved by'],                        
						'report'=>$row['Report Template'] 
                );					
				if ($row['Protocol ID']==NULL) break;	
				
				$protocol_status=$this->protocol_model->insert_new($protocol_data,$row['Protocol ID'],$user_name);
				array_push($imported_protocols[0], $row['Protocol ID']);   
				array_push($imported_protocols[1], $row['Protocol Name']);				
				
				$series_status;
				if (strtoupper($protocol_data['modality'])==='MR'){
					$series_data = array(
                        'firstname'=>$row['Protocol Name'],
                        'lastname'=>$row['Protocol ID'],
                        'phone'=>$row['Code'],
                        'email'=>$row['Description'],
						'firstname'=>$row['Modality'],
                        'lastname'=>$row['BodyPart'],
                        'phone'=>$row['BodyPart Code'],
                        'email'=>$row['BodyPart Full'],
						'firstname'=>$row['Approval Date'],
                        'lastname'=>$row['Go-Live Date'],
                        'phone'=>$row['Approved by'],
                        'email'=>$row['Series']
                    );
                    $series_status=$this->series_mr_model->insert_new($series_data,$row['Series']);
				}else{
					$series_data = array(
						'series_name'=>$row['Series'],
                        'indication'=>$row['Indications'],
                        'patient_orientation'=>$row['Patient Orientation'],
                        'landmark'=>$row['Landmark'],
                        'intravenous_contrast'=>$row['Intravenous Contrast'],
						'oral_contrast'=>$row['Oral Contrast'],
						'scout'=>$row['Scout'],
                        'scanning_mode'=>$row['Scanning Mode'],
                        'range_direction'=>$row['Range/Direction'],
                        'gantry_angle'=>$row['Gantry Angle'],
						'algorithm'=>$row['Algorithm'],
                        'beam_collimation_detector_configuration'=>$row['Beam Collimation / Detector Configuration'],
                        'slice_thickness'=>$row['Slice Thickness'],
                        'interval'=>$row['Interval'],
						'table_speed'=>$row['Table Speed (mm/rotation)'],
                        'pitch'=>$row['Pitch'],
						'kvp'=>$row['kVp'],						
                        'am'=>$row['mA'],
						'noise_reduction'=>$row['Noise Reduction'],
                        'rotation_time'=>$row['Rotation Time'],
                        'scan_fov'=>$row['Scan FOV'],
						'display_fov'=>$row['Display FOV'],
						'scan_delay'=>$row['Scan Delay'],						 
                        'post_processing'=>$row['Post Processing'],
						'transfer_images'=>$row['Transfer Images'],
                        'notes'=>$row['Notes'],
						'protocol_number'=>$row['Protocol ID']
                    );
                    $series_status=$this->series_ct_model->insert_new($series_data,$row['Series']);
				}	
				//0: new protocol; 1: modified; 2:no change
				$status="modified";
				if($protocol_status==0){
					$status="new protocol";
				}else if ($protocol_status==2 && $series_status==2){
					$status="no change";
				};
				//$status=$protocol_status."**".$series_status;
				array_push($imported_protocols[2], $status);
			}
			//$this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
			echo json_encode($imported_protocols);
		} else {
            $data['error'] = "Error occured";
            //$this->load->view('csvindex', $data);
			echo 0;
        }		
	}
}
