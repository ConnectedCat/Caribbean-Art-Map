<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('backend_model');
    }
    
	public function index(){
		$this->load->view('test_view');
	}
	
	public function process(){
		if($this->input->post('test')){
			$jsonStr = htmlspecialchars_decode($this->input->post('test'));
			var_dump($jsonStr);
		}
	}
}