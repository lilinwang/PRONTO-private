<?php
class record_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function get_list_by_range($time_start,$time_end)
	{
		$date = DateTime::createFromFormat('Y-m-d', $time_end);
		$date->modify('+1 day');		
		$time_end=$date->format('Y-m-d');
		
		$sql = 'SELECT * FROM record WHERE created_at > ? AND created_at < ?';
		$params = array($time_start,$time_end);
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}		
}