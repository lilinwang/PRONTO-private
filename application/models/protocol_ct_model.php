<?php
class protocol_ct_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	function insert_new(
		$protocol_number,$protocol_name,$code,$description,$bodypart,$bodypart_full,
		$approval_date,$golive_date,$approved_by,$series,$notes,
		$indication,$patient_orientation,$landmark,$intravenous_contrast,$scout
	){
		 $sql='INSERT INTO protocol_ct
            (protocol_number,protocol_name,code,description,bodypart,bodypart_full,approval_date,golive_date,approved_by,series,notes,indication,patient_orientation,landmark,intravenous_contrast,scout) 
            values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
		
        $params = array(
            $protocol_number,$protocol_name,$code,$description,$bodypart,$bodypart_full,$approval_date,$golive_date,$approved_by,$series,$notes,$indication,$patient_orientation,$landmark,$intravenous_contrast,$scout
		);
        if (!$this->db->query($sql, $params)) {
            echo $this->db->_error_message();
            return 0;
        }else{
			return 1;//$this->get_id($user_id);
		}
	}	
	function get_list_by_bodypart($bodypart_full)
	{
		$sql = 'SELECT * FROM protocol_ct WHERE bodypart_full LIKE ?';
		$params = array($bodypart_full);
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
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