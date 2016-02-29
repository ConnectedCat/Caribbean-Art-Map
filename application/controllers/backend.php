<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends CI_Controller {

	public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('backend_model');
    }
    
	public function index(){
		
		/*
if($this->session->userdata('logged_in')){
			$this->load->view('backend_view');
		}
		else {
			redirect('/login/index');	
		}
*/
	if($this->session->userdata('logged_in')){
		//print_r($this->session->all_userdata());
		$this->load->view('backend_view');
	}
	else {
		//print_r($this->session->all_userdata());
		redirect('/login/index');
	}
	}//end index()

	
	public function get_space(){
		
		$space_array = $this->backend_model->get_space($this->input->post('selected'));
		
		if($space_array == false){
			echo "none";
		}
		else {
			echo json_encode($space_array);
		}
	}//end get_space()
	
	public function image_upload(){
		$status = "";
		$msg = "";
		$file_element_name = $this->input->post('element_name');
		
		if($status != "error"){
			$config['upload_path'] = './upload/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']  = 1024 * 8;
			$config['encrypt_name'] = FALSE;
			//$config['max_width'] = '600';
			//$config['max_height'] = '400';
		
			$this->load->library('upload', $config);
		
			if(!$this->upload->do_upload($file_element_name)){
				$status = "error";
				$msg = $this->upload->display_errors('', '');
				$image_path = "";
			}
			
			else {
				$base = base_url();
				
				$data = $this->upload->data();
				$image_path = './upload/images/'.$data['file_name'];
				
				$config['image_library'] = 'gd2';
				$config['source_image'] = $data['full_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['thumb_marker'] = '';
				$config['new_image'] = './upload/thumbs/thumb_'.$data['file_name'];
				$config['width'] = 125;
				$config['height'] = 82;
				
				$this->load->library('image_lib', $config);
				
				if(!$this->image_lib->resize()){
					$status = "error";
				    $msg =  $this->image_lib->display_errors()." image path: ".$data['full_path'];
				}
				else {
					$status = "success";
					$msg = '../../upload/thumbs/thumb_'.$data['file_name'];	
				}
			}
		}
		
		echo json_encode(array('status' => $status, 'msg' => $msg, 'path' => $image_path));
	}//end image_upload()
	
	public function image_delete(){
		$path = $this->input->post('path');
		$thumb = $this->input->post('thumb');
		
		if(!unlink($path)){
			echo "There has been an error - deleting an image. \n
				Path to file: ".$path."\n
				Path to thumb: ".$thumb."\n 
				Current dir: ".getcwd()."\n";
		}
		else {
			if(!unlink($thumb)){
				echo "There has been an error - deleting a thumbnail. \n
				Path to file: ".$path."\n
				Path to thumb: ".$thumb."\n 
				Current dir: ".getcwd()."\n";
			}
			else{
				echo "Done";
			}
		}
	}//end image_delete()
	
	public function space_update(){
		echo $this->backend_model->update_space($this->input->post('space_info'));
	}//end space_update()
	
	public function space_remove(){
		echo $this->backend_model->remove_space($this->input->post('space_name'));
	}//end space_remove()
	
}