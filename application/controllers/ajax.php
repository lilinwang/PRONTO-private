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
	function notify(){
		$data = json_decode(file_get_contents("php://input"));	
		$state = mysql_real_escape_string($data->state);
		$protocol_ID = mysql_real_escape_string($data->protocol_ID);
		$protocol_name = mysql_real_escape_string($data->protocol_name);
		$series_ID = mysql_real_escape_string($data->series_ID);
		$user = $this->session->userdata('user_name');
		$timestamp = time(); 
		exec("python /var/www/html/wanglilin/radiology/radiqal_pronto_test.py $state $protocol_ID $protocol_name $series_ID $user $timestamp");	
		echo 1;	
	}
	function get_category(){
		$this->load->model('category_model');				
		$result= $this->category_model->get_all_list();
		echo json_encode($result);
	}
	function get_record(){
		$data = json_decode(file_get_contents("php://input"));
		
		$time_start = mysql_real_escape_string($data->time_start);
		$time_end = mysql_real_escape_string($data->time_end);			
		$this->load->model('record_model');				
		$result= $this->record_model->get_list_by_range($time_start,$time_end);
		echo json_encode($result);	
	}
	function get_all_record(){
		$data = json_decode(file_get_contents("php://input"));
		
		$time_start = mysql_real_escape_string($data->time_start);
		$time_end = mysql_real_escape_string($data->time_end);			
		$this->load->model('record_model');				
		$result= $this->record_model->get_all_list_by_range($time_start,$time_end);
		echo json_encode($result);	
	}
	function get_protocol(){	
		$data = json_decode(file_get_contents("php://input"));
		
		$category = mysql_real_escape_string($data->category);
		$this->load->model('protocol_model');				
		$result= $this->protocol_model->get_list_by_category($category);		
		
			
		echo json_encode($result);				
	}
	function get_protocol_scanner(){
		$data = json_decode(file_get_contents("php://input"));
		
		$scanner = mysql_real_escape_string($data->scanner);
		$this->load->model('protocol_series_model');				
		$result= $this->protocol_series_model->get_list_by_scanner($scanner);		
			
		echo json_encode($result);				
	}
	function get_all_protocols(){	
		$this->load->model('protocol_model');				
		$result= $this->protocol_model->get_all_protocols();		
		
		echo json_encode($result);				
	}
	function export_protocol(){
		$data = json_decode(file_get_contents("php://input"));
		
		$modality = mysql_real_escape_string($data->modality);		
		//echo $modality;
		$this->load->model('protocol_series_model');				
		$result= $this->protocol_series_model->get_export($data->category_full,$modality);		
				
		echo json_encode($result);				
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
		//$this->load->model('category_model');
		
        if ($this->csvimport->get_array($file_path)) {
			$csv_array = $this->csvimport->get_array($file_path);
			$imported_protocols=array(array(),array(),array(),array());
			//$imported_status=array();
			foreach ($csv_array as $row) {	
				$protocol_data = array(                        
                        "Protocol ID"=>$row['Protocol ID'],
						"Protocol Name"=>$row['Protocol Name'],
						'Protocol Category'=>$row['Protocol Category'],                        
						'Report Template'=>$row['Report Template'],
						'Indications'=>$row['Indications']
                );					
				if ($row['Protocol ID']==NULL) break;	
				
				$protocol_status=$this->protocol_model->insert_new($protocol_data,$row['Protocol ID'],$user_name);
				//$this->category_model->insert_new($row['Protocol Category']);
				array_push($imported_protocols[0], $row['Protocol ID']);   
				array_push($imported_protocols[1], $row['Protocol Name']);				
				
				$series_status;
				if (strtoupper($protocol_data['Protocol Category'][0])==='M'){
					$series_data = array(
                        'Series'=>$row['Series'],                        
                        'Pulse Sequence'=>$row['Pulse Sequence'],
                        'Plane'=>$row['Plane'],
                        'Imaging Mode'=>$row['Imaging Mode'],
						'Sequence Description'=>$row['Sequence Description'],
						'Localization'=>$row['Localization'],
						'FOV'=>$row['FOV'],
                        'MATRIX (1.5T)'=>$row['MATRIX (1.5T)'],
                        'MATRIX (3T)'=>$row['MATRIX (3T)'],
						'NEX'=>$row['NEX'],
						'Bandwidth'=>$row['Bandwidth'],
                        'THK/SPACE'=>$row['THK/SPACE'],
						'Sequence options'=>$row['Sequence options'],
						'Injection options'=>$row['Injection options'],
						'Time'=>$row['Time'],                        
						'Protocol ID'=>$row['Protocol ID'],
						'Scanner'=>$row['Scanner'],
						'Notes'=>$row['Notes']
                    );
                    $series_status=$this->series_mr_model->insert_new($series_data,$row['Series'],$row['Protocol ID']);
		    array_push($imported_protocols[3], $row['Series']);				
				}else{
					$series_data = array(
						'Series'=>$row['Series'],
			                        'Orientation'=>$row['Orientation'],                        
                        'Intravenous Contrast'=>$row['Intravenous Contrast'],
						'Oral Contrast'=>$row['Oral Contrast'],
						'Scout'=>$row['Scout'],
                        'Scanning Mode'=>$row['Scanning Mode'],
                        'Range/Direction'=>$row['Range/Direction'],
                        'Gantry Angle'=>$row['Gantry Angle'],
						'Algorithm'=>$row['Algorithm'],
                        'Beam Collimation / Detector Configuration'=>$row['Beam Collimation / Detector Configuration'],
                        'Slice Thickness'=>$row['Slice Thickness'],
                        'Interval'=>$row['Interval'],
						'Table Speed (mm/rotation)'=>$row['Table Speed (mm/rotation)'],
                        'Pitch'=>$row['Pitch'],
						'kVp'=>$row['kVp'],						
                        'mA'=>$row['mA'],
						'Noise Index'=>$row['Noise Index'],
						'Noise Reduction'=>$row['Noise Reduction'],
                        'Rotation Time'=>$row['Rotation Time'],
                        'Scan FOV'=>$row['Scan FOV'],
						'Display FOV'=>$row['Display FOV'],
						'Scan Delay'=>$row['Scan Delay'],						 
                        'Post Processing'=>$row['Post Processing'],
						'Transfer Images'=>$row['Transfer Images'],
                        'Notes'=>$row['Notes'],
						'CTDI'=>$row['CTDI'],
						'Protocol ID'=>$row['Protocol ID'],
						'Scanner'=>$row['Scanner']                        
 
                    );
                    $series_status=$this->series_ct_model->insert_new($series_data,$row['Series'],$row['Protocol ID']);
        	    array_push($imported_protocols[3], $row['Series']);				
			
				}	
				//0: new protocol; 1: modified; 2:no change
				$status=1;
				if($protocol_status==0){
					$status=0;
				}else if ($protocol_status==2 && $series_status==2){
					$status=2;
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
