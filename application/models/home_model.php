<?php
class Home_model extends CI_Model {
	
	public function get_spaces($filter){
		if(count($filter)>0){
			$query = $this->db->get_where('spaces', $filter);
		}
		else {
			$query = $this->db->get('spaces');
		}
		
		$return_array = array();
		
		foreach ($query->result_array() as $row){			
		    array_push($return_array, $row);
		}
		return $return_array;
	}//end get_spaces
}