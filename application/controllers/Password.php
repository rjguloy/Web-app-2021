<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'usermodel') ;
        $this->load->model('PasswordModel', 'passwordmodel') ;
        $this->load->model('SecurityQuestionModel', 'sqModel') ;
        $this->load->model('SchoolInfoModel', 'schoolInfoModel') ;
        $this->load->library('encryption') ;
        $this->load->helper(array('url', 'password'));

        $functionCall = $this->router->fetch_method();
        // $noSession = array('index', 'validateUsername', 'validateAnswers', 'change2');

        // if(is_null($this->session->userdata('username')) && !in_array($functionCall, $noSession)){
        if(is_null($this->session->userdata('username')) && $functionCall == 'change'){
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
		$this->load->view('forgotpassword');		
	}

    public function change(){
		$oldPassword = $this->input->post("oldpword");
		$newPassword = $this->encryption->encrypt($this->input->post("newpword"));
		
		if(isPasswordValid($this->input->post("newpword"))){
			try{
		    	$user = $this->usermodel->getByUsername($this->session->userdata('username'));
		    	$data = array($user->username, $newPassword);

				if(strcmp($oldPassword, $this->encryption->decrypt($user->password))){
					$success = "Old password incorrect.";
				}else{
					$success = $this->passwordmodel->update($data);
				}
			}catch(Exception $e){
				$success = "System error. Please contact your administrator.";
			}
		}else{
			$success = "New password format invalid.";
		}

		echo $success;
    }

    public function validateUsername(){
		$username = $this->input->post("uname");
		$queryData = array($username);

		$user = $this->usermodel->getByUsername($queryData);

		if(is_null($user->username) || is_null($user->validationdate)) { // user not found or no yet validated
			echo "Username invalid.";
		}else{
			$userSecurityQuestionList = $this->sqModel->getListByUsername($queryData);

			echo json_encode($userSecurityQuestionList);
		}
    }

    public function validateAnswers(){
		$username = $this->input->post("uname");
		$securityQuestions = explode(",", $this->input->post("questions"));
		$answers = explode(",", $this->input->post("answers"));

		$success = true;
		for($i = 0; $i < 3; $i++){
			$queryData = array($username, $securityQuestions[$i], $answers[$i]);
			$row = $this->sqModel->validateAnswer($queryData);

			if($row->isverified == '0'){
				$success = "At least one answer is not verified. Please try again.";
				break;
			}

		}
		echo $success;
    }

    public function change2(){
		$username = $this->input->post("uname");
		$newPassword = $this->encryption->encrypt($this->input->post("newpword"));
		
		if(isPasswordValid($this->input->post("newpword"))){
	    	$data = array($username, $newPassword);
			$success = $this->passwordmodel->update($data);

			if(!is_null($this->session->userdata('passwordduration'))){
				$this->session->set_userdata('username', $username);

				$schoolInfo = $this->schoolInfoModel->getInfo();
				$this->session->set_userdata('schoolId', $this->schoolInfoModel->out['info']['id']);
			}
		}else{
			$success = "New password format invalid.";
		}

		echo $success;
    }
}