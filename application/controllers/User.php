<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'usermodel') ;
        $this->load->library('encryption') ;
        $this->load->helper('url');

        $functionCall = $this->router->fetch_method();

        if(is_null($this->session->userdata('username')) && $functionCall != 'add'){
			if (IS_SSO) redirect(LOGOUT_URL);
			redirect(base_url());
	        exit;
		}
		
		$this->session->unset_userdata('caDateId');
		$this->session->unset_userdata('locationId');
		$this->session->unset_userdata('sublocationId');
		$this->session->unset_userdata('sumDateId');
		$this->session->unset_userdata('photoDateId');
    }


	public function index()
	{
		$userList = $this->usermodel->getList();
		$data['users'] = $userList;
		
		$this->load->view('user', $data);	
	}

	public function add(){

		$username = $this->input->post("uname");
		$name = $this->input->post("name");
		$password = $this->encryption->encrypt($this->input->post("pword"));
		$securityQuestions = $this->input->post("questions");
		$answers = $this->input->post("answers");

		try{
			$user = $this->usermodel->getByUsername($username);

			if(is_null($user->username)){
				$user = array($username, $name, $password, $securityQuestions, $answers);
				$success = $this->usermodel->add($user);
			}else{
				$success = "Username already exists.";
			}
		}catch(Exception $e){
			$success = "System error. Please contact your administrator.";
		}

		echo $success;
	}

    public function approve(){
		$userId = $this->input->post("id");
		$createdBy = $this->session->userdata('username');
		$data = array($userId, $createdBy);

		$success = $this->usermodel->approve($data);

		echo $success;
    }

    public function delete(){
		$userId = $this->input->post("id");
		$createdBy = $this->session->userdata('username');
		$data = array($userId, $createdBy);

		$success = $this->usermodel->delete($data);

		echo $success;
    }
}
