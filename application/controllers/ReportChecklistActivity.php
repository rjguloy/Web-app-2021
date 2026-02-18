<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportChecklistActivity extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('ChecklistActivityModel', 'checklistActivityModel');
		$this->load->model('LocationsModel', 'locationModel');
		$this->load->model('SubLocationModel', 'subLocationModel');
		$this->load->model('Reports', 'reportsModel');
		$this->load->helper('url');

		if(is_null($this->session->userdata('username'))){
			if (IS_SSO) redirect(LOGOUT_URL);
			redirect(base_url());
			exit;
		}

		if ($this->session->role != 'SCHOOL') {
			redirect('home');
		}

		$this->session->unset_userdata('photoDateId');
		$this->session->unset_userdata('sumDateId');
    }

	public function index()
	{
		$data['dates'] = $this->checklistActivityModel->getList();
		$data['locations'] = $this->locationModel->getList();

		if ($this->session->caDateId) {
			$data['cadId'] 			= $this->session->caDateId;
			$data['locationId'] 	= $this->session->locationId;
			$data['sublocationId'] 	= $this->session->sublocationId;

			$data['sublocations'] = $this->subLocationModel->getList($data['locationId']);

			$queryData = array($data['cadId'], $data['sublocationId']);

			$data['list'] = $this->reportsModel->getChecklistActivityList($queryData);
			
			$this->session->unset_userdata('caDateId');
			$this->session->unset_userdata('locationId');
			$this->session->unset_userdata('sublocationId');
		}

		$this->load->view('reportchecklistactivity', $data);	
	}

	public function getList()
	{
		$cadId = $this->input->post("cadid");
		$sublocationId = $this->input->post("sublocationid");
		$queryData = array($cadId, $sublocationId);

		$data['list'] = $this->reportsModel->getChecklistActivityList($queryData);

		echo json_encode($data);		
	}

    public function validate(){
		$cadId = $this->input->post("cadid");
		$sublocationId = $this->input->post("sublocationid");
		$hazardId = $this->input->post("hazardid");
		$createdBy = $this->session->userdata('username');
		$queryData = array($cadId, $sublocationId, $hazardId, $createdBy);

		$success = $this->reportsModel->validateRecord($queryData);

		$this->session->set_userdata('caDateId', $cadId);
		$this->session->set_userdata('locationId', $this->input->post('locationid'));
		$this->session->set_userdata('sublocationId', $sublocationId);
		
		echo $success;
    }
}