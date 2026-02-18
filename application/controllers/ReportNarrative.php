<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportNarrative extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('ChecklistActivityModel', 'checklistActivityModel');
		$this->load->model('Reports', 'reports');
		$this->load->helper('url');

		if(is_null($this->session->userdata('username'))){
			if (IS_SSO) redirect(LOGOUT_URL);
			redirect(base_url());
			exit;
		}

		if ($this->session->role != 'SCHOOL') {
			redirect('home');
		}

		$this->session->unset_userdata('caDateId');
		$this->session->unset_userdata('locationId');
		$this->session->unset_userdata('sublocationId');
		$this->session->unset_userdata('sumDateId');
		$this->session->unset_userdata('photoDateId');
    }

	public function index()
	{
		$data['dates'] = $this->checklistActivityModel->getList();

		$this->load->view('reportnarrative', $data);		
	}

	public function getNarrative(){
		$checklistDateId = $this->input->post("id");

		try{
			$queryData = array($checklistDateId);
			$narrative = $this->reports->getNarrative($queryData);

			if(!is_null($narrative)){
				$output = $narrative->description;
			}else{
				$output = "";
			}
		}catch(Exception $e){
			$output = "System error. Please contact your administrator.";
		}

		echo json_encode($output);
	}

	public function save(){
		$checklistDateId = $this->input->post("checklistDateId");
		$narrative = $this->input->post("narrative");

		try{
			$queryData = array($checklistDateId, $narrative, $this->session->userdata('username'), $this->session->userdata('schoolId'));
			$success = $this->reports->saveNarrative($queryData);
		}catch(Exception $e){
			$success = "System error. Please contact your administrator.";
		}

		echo $success;
	}
}