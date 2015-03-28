<?php
class user_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

	//check whether the user_name exists, return all info if exists
	function check($user_name){
		$sql="SELECT * FROM user WHERE user_name=?";
		$query=$this->db->query($sql,array($user_name));
		return $query->result_array();
	}
	
	//get user info from user_id
	function get_from_id($id){
		$sql="SELECT * FROM user WHERE user_id=?";
		$query=$this->db->query($sql,array($id));
		$result=$query->result_array();
        return $result[0];
	}
	//get user_name from user_id
	function get_name($id){
		$sql="SELECT user_name FROM user WHERE user_id=?";
		$query=$this->db->query($sql,array($id));
		$query=$query->row();
        return $query->user_name;
	}
	//login
	function login($user_name,$password){
		$sql="SELECT * FROM user WHERE user_name=?";
		$query=$this->db->query($sql,array($user_name));
		$result1=$query->result_array();
		$query=$query->row();
		if($result1)// check password
		{
			$result2=($query->password==sha1($password.$query->reg_time));
			if($result2){//if the password match, return user_id
				return $query->user_id;
			}
			else{// password does not match
				return -1;
			}
		}
     	else{// user not exists
			return -2;
		}
	}	
	function register_simple($user_name,$password,$reg_time){
		$sql="INSERT INTO user (user_name,password,reg_time) VALUES (?,?,?)";
		$this->db->query($sql,array($user_name,$password,$reg_time));	
		
		$sql="SELECT * FROM user WHERE user_name=?";
		$query=$this->db->query($sql,$user_name);
		if ($query->num_rows() > 0) {
			//echo $query;
            return $query->row()->user_id;
        }
        else {			
            return -1;
        }
	}
	//update
	function update_by_email($map,$email){
		/*eg:
			$map['gender']='1';
			$map['name']='hello';
			$this->user_model->update_by_email($map,$email);
		 * *
		 */
		foreach($map as $key=>$var){
	    	$sql="UPDATE user SET ".$key."=? WHERE email=?";
			$result=$this->db->query($sql,array($var,$email));
		}
	}
	function update_by_id($map,$id){		
		foreach($map as $key=>$var){
	    	$sql="UPDATE user SET ".$key."=? WHERE user_id=?";
			$result=$this->db->query($sql,array($var,$id));
		}
	}

	function update_by_all($email,$password,$name,$nickname,$gender,$birthday,$introdution){
			$sql="UPDATE user SET password=?,name=?,nickname=?,gender=?,birthday=?,introduction=?  WHERE email=?";
			$result=$this->db->query($sql,array($password,$name,$nickname,$gender,$birthday,$introdution,$email));
	}

	function cancel_by_email($email){
		$sql="DELETE FROM user WHERE email=?";
		$this->db->query($sql,array($email));
	}
	
    
    function get_exposable_row($id) {
    	$sql = "SELECT * FROM user WHERE user_id=? LIMIT 1";
    	$query = $this->db->query($sql,array($id));
    	$result = $query->row_array();
    	
    	// unset user password, user reg_time
    	unset($result['password']);
    	unset($result['reg_time']);
    	
        return $result;
    }
    
    function get_exposable_row_by_username($username) {
    	$sql = "SELECT * FROM user WHERE user_name=? LIMIT 1";
    	$query = $this->db->query($sql,array($username));
    	$result = $query->row_array();
    	
    	// unset user password, user reg_time
    	unset($result['password']);
    	unset($result['reg_time']);
    	
        return $result;
    }
}