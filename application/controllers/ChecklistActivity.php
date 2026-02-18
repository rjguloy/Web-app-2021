<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChecklistActivity extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel') ;
        $this->load->model('ChecklistActivityModel');
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
		$list['activity'] = $this->ChecklistActivityModel->getList();

		$this->load->view('checklistactivity',$list);
	}

	public function addActivityDate()
	{
		$activityDate = $this->input->post("date");
		$schoolID = $this->session->userdata('schoolId');
		$createdBy = $this->session->userdata('username');


		try{
			$activity = $this->ChecklistActivityModel->getByDate($activityDate);

			if(empty($activity)){
				$data = array($activityDate, $schoolID,$createdBy);
				$this->ChecklistActivityModel->addActivity($data);
				$out['error'] = 0;
				$out['msg'] = "Successfully added checklist activity date.";
			}else{
				$out['error'] = 1;
				$out['msg'] = "Checklist Activity Date already exists.";
			}
		}catch(Exception $e){
			$out['error'] = 2;
			$out['msg'] = "System error. Please contact your administrator";
		}

		echo json_encode($out);
	}

	public function deleteActivityDate()
	{
		$cad_id = $this->input->post("cad_id");

		try{
			$activity = $this->ChecklistActivityModel->getByID($cad_id);

			if(!empty($activity)){
				$this->ChecklistActivityModel->deleteActivity($cad_id);
				$out['error'] = 0;
				$out['msg'] = "Successfully deleted checklist activity date.";
			}else{
				$out['error'] = 1;
				$out['msg'] = "Checklist Activity Date not found.";
			}
		}catch(Exception $e){
			$out['error'] = 2;
			$out['msg'] = "System error. Please contact your administrator";
		}

		echo json_encode($out);
	}
}