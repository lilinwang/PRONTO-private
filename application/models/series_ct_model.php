<?php
class series_ct_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}	
	
	function insert_new($data,$id){
		$sql = 'SELECT * FROM series_ct WHERE series_id=?';
		$params = array($id);
		
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$this->db->where('series_id', $id);
			$this->db->update('series_ct', $data);        
        }
        else {            
			$this->db->insert('series_ct', $data);
        }		
	}	
	
	function get_list_by_number($protocol_number){
		$sql = 'SELECT * FROM series_ct WHERE protocol_number=?';
		$params = array($protocol_number);
		
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}	
	function delete_by_number($protocol_number){
		$sql = 'DELETE FROM series_ct WHERE protocol_number=?';
		$params = array($protocol_number);
		
        $query = $this->db->query($sql, $params);
	}
}