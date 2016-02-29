<?php

class user_auth_model extends CI_Model {
	function validate()
	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		
		$query = $this->db->get('users');
		
		if($query->num_rows == 1){
		
			$row = $query->row();
			return array(
				'first_name' => $row->first_name,
				'last_name' => $row->last_name
				);
		}
		
		else {
			return false;
		}
	}
	
	function set_loginkey($loginkey, $email){
		$data = array('loginkey' => $loginkey);
		
		$this->db->where('email', $email);
		
		$this->db->update('users', $data);
	}
	
	function get_loginkeys(){
		$this->db->select('loginkey');
		
		$query = $this->db->get('users');
		
		$return_array = array();
		
		foreach ($query->result() as $row){
		    array_push($return_array, $row->loginkey);
		}
		
		return $return_array;
	}
	
}