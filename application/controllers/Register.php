<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {


	function __construct() {
        parent::__construct();
        $this->load->model('SecurityQuestionModel', 'sqModel') ;
        $this->load->library('encryption') ;
		$this->load->helper('password');
		
		$this->session->unset_userdata('caDateId');
		$this->session->unset_userdata('locationId');
		$this->session->unset_userdata('sublocationId');
		$this->session->unset_userdata('sumDateId');
		$this->session->unset_userdata('photoDateId');
    }

	public function index()
	{
		$randomSecurityQuestionList = $this->sqModel->getList();
		$data['questions'] = $randomSecurityQuestionList;

		$this->load->view('register', $data);		
	}

	public function validatePassword(){
		$password = $this->input->post("pword");
		
		if(isPasswordValid($password)){
			echo true;
		}else{
			echo "New password format invalid.";
		}
	}

}