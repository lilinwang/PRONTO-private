<?php
class protocol_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	private function record($protocol_number,$protocol_name,$user_name,$status){
		$sql='INSERT INTO record (`Protocol ID`, `Protocol Name`, `created_by`, `status`) VALUES (?,?,?,?);';
		//0: new protocol; 1: modified; 2:no change
		$new_status=["New protocol","Modified","No change","Deleted"];
		$params = array($protocol_number,$protocol_name,$user_name,$new_status[$status]);
		$query = $this->db->query($sql, $params);
	}
	
	function get_list_by_category($category)
	{
		$sql = "SELECT * FROM protocol WHERE `Protocol Category` LIKE ? ORDER BY `Protocol Name`";
		$params = array('%'.$category.'%');
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$result=$query->result_array();
			return $result;            
        }
        else {
            return null;
        }
	}
	function get_all_protocols()
	{
		$sql = "SELECT * FROM protocol ORDER BY `Protocol Name`";
		
        $query = $this->db->query($sql);
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
		$sql="SELECT * FROM `protocol` WHERE MATCH (`Protocol Name`, `Indications`,`Protocol Category`) AGAINST('+".$ids."' IN BOOLEAN MODE) ORDER BY `Protocol Name`;";
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
		$sql = 'SELECT * FROM protocol WHERE `Protocol ID` like ?';
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
		$sql = 'SELECT `Report Template` FROM protocol WHERE `Protocol Name` like ?';
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
		$sql = 'SELECT report,description FROM protocol WHERE `Protocol ID` like ?';
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
	function insert_new($data,$id,$user_name){
		$sql = 'SELECT * FROM protocol WHERE `Protocol ID`=?';
		$params = array($id);
		$status = 0;//0: new protocol; 1: modified; 2:no change; 3:delete
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$status=2;
			$arrayobject = new ArrayObject($data);

			for($iterator = $arrayobject->getIterator();
				$iterator->valid();
				$iterator->next()) {
				if ($iterator->current()!=$query->result_array()[0][$iterator->key()]){
					$status=1;
					break;
				}
			}
			
			if ($status==1){	
				$this->backup($query->result_array()[0]);
				$this->delete_protocol($id);
				$this->insert_protocol($data);
				$this->insert_new_category($data['Protocol Category']);
				/*$this->db->insert('protocol_backup',$query->result_array()[0]);
				$this->db->where('Protocol ID', $id);
				$this->db->update('protocol', $data);  */
			}					
        }
        else {  
			$this->insert_new_category($data['Protocol Category']);
			$this->insert_protocol($data);        			
			//$this->db->insert('protocol', $data);			
        }		
		
		$this->record($id,$data['Protocol Name'],$user_name,$status);
		return $status;
	}	
	private function insert_protocol($data){
		$sql = 'INSERT INTO `protocol` VALUES(?';			
		
		$count = count($data);	
		
		for ($i = 1; $i < $count; $i++) {   
			$sql=$sql.", ? ";
		}
		$sql=$sql.")";
		
		$params = array();
		
		foreach($data as $key=>$val){ 			
			array_push($params,$val);
		}
		
		$query = $this->db->query($sql,$params);
	}
	
	private function backup($data){
		$sql = 'INSERT INTO `protocol_backup` VALUES(?';					
		$count = count($data);	
		
		for ($i = 1; $i < $count; $i++) {   
			$sql=$sql.", ? ";
		}
		$sql=$sql.")";
		
		$params = array();
		
		foreach($data as $key=>$val){ 			
			array_push($params,$val);
		}
		
		$query = $this->db->query($sql,$params);
	}
	
	function delete_by_number($protocol_number,$user_name){
		$sql = 'SELECT * FROM protocol WHERE `Protocol ID`=?';
		$params = array($protocol_number);
		$query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
			$this->backup($query->result_array()[0]);
			//$this->db->insert('protocol_backup',$query->result_array()[0]);//backup
			$this->record($protocol_number,$query->result_array()[0]['Protocol Name'],$user_name,3);//record
			$this->delete_protocol($protocol_number);
			$this->delete_category($query->result_array()[0]['Protocol Category']);
		}				
	}	
	function delete_all($user_name){
		$sql = 'SELECT * FROM protocol';		
		$query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
			foreach($query->result_array() as $data){
				$this->backup($data);
				$this->record($data['Protocol ID'],$data['Protocol Name'],$user_name,3);//record				
			}
		}			
		
		$sql = 'DELETE FROM protocol WHERE 1';
		$query = $this->db->query($sql);	

		$sql = 'DELETE FROM category WHERE 1';
		$query = $this->db->query($sql);	
	}
	private function delete_protocol($protocol_number){
		$sql = 'DELETE FROM protocol WHERE `Protocol ID`=?';
		$params = array($protocol_number);		
        $query = $this->db->query($sql, $params);				
	}
	private function delete_category($data){
		$arr = explode("-", $data);
		$count = count($arr);
		$tmp = $arr[0];
		$sql = "SELECT * FROM protocol WHERE `Protocol Category` LIKE ?";
		$query = $this->db->query($sql,$tmp."%");
		if ($query->num_rows() == 0){
			$q = "DELETE FROM category WHERE `name` = ?";
			$this->db->query($q,$tmp);
		};
		
		for ($i=1;$i<$count;$i++){	
			$tmp = $tmp."-".$arr[$i];
			$sql = "SELECT * FROM protocol WHERE `Protocol Category` LIKE ?";
			$query = $this->db->query($sql,$tmp."%");
			if ($query->num_rows() == 0){
				$q = "DELETE FROM category WHERE `name` = ?";
				$this->db->query($q,$tmp);
			};
		}
	}
	
	private function insert_new_category($data)
	{			
		$arr=explode("-", $data);
		$count=count($arr)-1;
		$sql = "SELECT * from category WHERE name=?";
		$query = $this->db->query($sql,$data);
		
        if ($query->num_rows() == 0) {
			$sql = "INSERT INTO category(`name`,`show_name`,`level`) VALUES (?,?,?)";
			
			$show_name=$arr[$count];
			
			$this->db->query($sql,array($data,$show_name,$count));
			
			$tmp = $arr[0];
			for ($i=0;$i<$count;$i++){			
				$sql = "SELECT * from category WHERE name=?";
				$q = $this->db->query($sql,$tmp);
				if ($q->num_rows()==0){
					$sql = "INSERT INTO category(`name`,`show_name`,`level`) VALUES (?,?,?)";
					
					$show_name=$arr[$i];
					$this->db->query($sql,array($tmp,$show_name,$i));
				}
				$tmp=$tmp.'-'.$arr[$i+1];
			}
            return null;
        }
	}	
}
