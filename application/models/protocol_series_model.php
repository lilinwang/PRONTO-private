<?php
class protocol_series_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	function get_export($bodypart_full,$modality)
	{		
		/*$this->db->select('*');
		foreach ($bodypart as $body){
			$this->db->where('bodypart_full LIKE',$body);
		}
		$this->db->where_in('bodypart_full',$bodypart_full);
		$this->db->where('modality LIKE',$modality);
		$query=$this->db->get('protocol');*/
		$sql = 'SELECT * FROM protocol WHERE modality LIKE ? AND (bodypart_full LIKE ? ';
		
		$count = count($bodypart_full);	
		
		for ($i = 1; $i < $count; $i++) {   
			$sql=$sql."OR bodypart_full LIKE ? ";
		}
		$sql=$sql.")";
		
		$params = array($modality);
		
		foreach ($bodypart_full as $body) {   			
			array_push($params,$body);
		}
		//var_dump( $params);
        $query = $this->db->query($sql,$params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}
}
?>