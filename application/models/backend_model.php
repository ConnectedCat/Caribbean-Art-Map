<?php
class Backend_model extends CI_Model {

	public function get_tables(){
		$tables = $this->db->list_tables();
		$tables_array = array();
		
			foreach ($tables as $table)
			{
			   array_push($tables_array, $table);
			}
		return $tables_array;
	}
	
	
	public function check_spaces($places){
		$in_db = array();
		
		$this->db->select('space');
		$query = $this->db->get('spaces');
		
		foreach($query->result() as $row){
			array_push($in_db, $row->space);
		}
		
		if(count($places) > count($in_db)){
			$into_db = array();
			
			for($i = count($in_db); $i < count($places); $i++){
				$this->db->insert('spaces', array('space' => $places[$i]));
			}
		}//end if
	}//end check_spaces
	
	public function get_space($current){
		$current = htmlspecialchars_decode($current);
		
		$this->db->where('space_name', $current);
		$query = $this->db->get('images');
				
		if($query->num_rows == 1){
			
			$row = $query->row();
			
			return array(
				'space_name' 	=> $row->space_name,
				'images'		=> array(
					$row->image_path1,$row->image_path2,$row->image_path3,$row->image_path4,$row->image_path5,$row->image_path6
				),
				'thumbs'		=> array(
					$row->thumb_path1,$row->thumb_path2,$row->thumb_path3,$row->thumb_path4,$row->thumb_path5,$row->thumb_path6
				),
				'comments'		=> array(
					$row->comment1,$row->comment2,$row->comment3,$row->comment4,$row->comment5,$row->comment6
				),
				'links'			=> array(
					$row->link1,$row->link2,$row->link3,$row->link4,$row->link5,$row->link6
				)

			);
		}
		else {
			return false;
		}
		
	}
	
	public function update_space($info_array){
		$return_value;
		
		$info_array['space_name'] = htmlspecialchars_decode($info_array['space_name']);
		
		$this->db->select('space_name');
		$query = $this->db->get_where('images', array('space_name' => $info_array['space_name']));
		
		if($query->num_rows == 1){
			$this->db->where('space_name', $info_array['space_name']);
			
			if(!$this->db->update('images', $info_array)){
				$return_value = 'error updating';
			}
			else {
				$return_value = 'success updating';
			}
		}
		else {
			
			if(!$this->db->insert('images', $info_array)){
				$return_value = 'error inserting';
			}
			else {
				$return_value = 'success inserting';
			}
		}
		
		return $return_value;
	}//end update_space()
	
	public function remove_space($space){
		$return_value;
		
		$space = htmlspecialchars_decode($space);

			
		if(!$this->db->delete('images', array('space_name' => $space))){
			$return_value = 'error deleting space';
		}
		else {
			$return_value = 'success deleting space';
		}
		
		return $return_value;
	}//end remove_space()
}