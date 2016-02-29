<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->model('user_auth_model');
		$data['error'] = "";

		if(get_cookie('FreshMilk') != ""){
			if (in_array(get_cookie('FreshMilk'), $this->user_auth_model->get_loginkeys())){
				$this->session->set_userdata('logged_in', true);
				redirect('/backend/index');
			}
			else {
				$this->load->view('login_view', $data);
			}
		}
		else if($this->session->userdata('logged_in')){
			redirect('/backend/index');	
		}
		else {
			$this->load->view('login_view', $data);
		}
		
	}//end index()
	
	function validate()
	{
		$this->load->model('user_auth_model');
		
		if($this->user_auth_model->validate() != false)
		{
			
			if($this->input->post('remember')){			
				
				$this->set_new_cookie();
			}
			
			$user_info = $this->user_auth_model->validate();
			
			$this->session->set_userdata(array(
				'email' => $this->input->post('email'),
				'logged_in' => true,
				'first_name' => $user_info['first_name'],
				'last_name' => $user_info['last_name']
			));
			
			redirect('backend/index');
		}
		
		else
		{
			$data['error'] = "incorrect login credentials please try again";
			$this->load->view('login_view', $data);
		}
	}//end validate()
	
	function set_new_cookie(){
		$loginkey = uniqid();
		$domain =  $_SERVER['SERVER_NAME'];
		
		$cookie = array(
		    'name'   => 'FreshMilk',
		    'value'  => $loginkey,
		    'expire' => '1209600',
		    'path'   => '/',			    
		    'prefix' => '',
		    'secure' => FALSE
		);
		
		set_cookie($cookie);
		
		$this->user_auth_model->set_loginkey($loginkey, $this->input->post('email'));
	}// end set_new_cookie()
	
	function forgot()
	{
		$this->load->view('forgot_view');
	}//end forgot()
	
	function send_info()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->forgot();
		}
		else {
			echo 'validated';
		//$this->load->model('user_auth_model');
		//$this->user_auth_model->retrieve();
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('logged_in');
		redirect('');
	}
}
