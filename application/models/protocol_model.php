<?php
class protocol_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function get_list_by_bodypart($bodypart_full,$modality)
	{
		$sql = 'SELECT * FROM protocol WHERE bodypart_full LIKE ? and modality LIKE ?';
		$params = array($bodypart_full,$modality);
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}
	function get_list_by_keywords($content)
	{	$content= explode(" ", $content);
		//echo $content;
		$ids = implode(" +",$content); 
		
		//echo $ids;
		$sql="SELECT * FROM `protocol` WHERE MATCH (protocol_name, description, bodypart_full, modality) AGAINST('+".$ids."' IN BOOLEAN MODE) ;";
		//echo $sql;
		//$sql = "SELECT * FROM protocol WHERE bodypart_full IN ('".$ids."')";
		//$params = array($ids);
		//$params = array($content);
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}	
	
	function get_by_number($protocol_number){
		$sql = 'SELECT * FROM protocol WHERE protocol_number like ?';
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
	function get_report_description_by_name($name){
		$sql = 'SELECT report,description FROM protocol WHERE protocol_name like ?';
		$params = array($name);
		
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}
	function get_report_description_by_number($number){
		$sql = 'SELECT report,description FROM protocol WHERE protocol_number like ?';
		$params = array($number);
		
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}
	function insert_new($data,$id){
		$sql = 'SELECT * FROM protocol WHERE protocol_number=?';
		$params = array($id);
		
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {			
			$this->db->insert('protocol_backup',$query->result_array()[0]);
			$this->db->where('protocol_number', $id);
			$this->db->update('protocol', $data);        
        }
        else {            
			$this->db->insert('protocol', $data);
        }		
	}	
	
	function delete_by_number($protocol_number){
		$sql = 'DELETE FROM protocol WHERE protocol_number=?';
		$params = array($protocol_number);
		
        $query = $this->db->query($sql, $params);
	}
	/*function get_thumb_by_upload_id($upload_id)
	{
		$sql = 'SELECT thumbimg_dir FROM upload WHERE upload_id=?';
        $query = $this->db->query($sql, $upload_id);
        if ($query->num_rows() > 0) {			
			return $query->row()->thumbimg_dir;            
        }
        else {
            return null;
        }
	}
	function get_id($user_id) {
        $sql = 'SELECT upload_id FROM upload WHERE user_id=? order by dining_time desc LIMIT 1';
        $query = $this->db->query($sql, $user_id);
        if ($query->num_rows() > 0) {
            return $query->row()->upload_id;
        }
        else {
            return null;
        }
    }
	function upload_url($upload_id,$full_image_dir,$small_image_dir){
		$sql = 'UPDATE upload SET img_dir=? WHERE upload_id=?';		
        $this->db->query($sql, array($full_image_dir,$upload_id));
		$sql = 'UPDATE upload SET thumbimg_dir=? WHERE upload_id=?';		
        $this->db->query($sql, array($small_image_dir,$upload_id));		
	}*/
}