<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportSummary extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('SummaryModel', 'summaryModel');
		$this->load->model('ChecklistActivityModel', 'checklistActivityModel');

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
		$this->session->unset_userdata('photoDateId');
    }

	public function index()
	{
		$this->out['dates'] = $this->checklistActivityModel->getList();

		if ($this->session->sumDateId) {
			$dateID = $this->session->sumDateId;
			$this->session->unset_userdata('sumDateId');
			$this->_fetchEvents($dateID);

			$this->out['dateID'] = $dateID;
		}

		$this->load->view('reportsummary', $this->out);		
	}


	public function events($dateID = null) {

		if ( ! $dateID) redirect($_SERVER['HTTP_REFERER']);

		try {
			$this->_fetchEvents($dateID);

		} catch (Exception $e) {
			$output = "System error. Please contact your administrator.";
		}
		
		$this->out['dateID'] = $dateID;

		echo json_encode($this->out);
	}


	private function _fetchEvents($dateID) {

		$this->out['records'] 	= $this->summaryModel->getListByDateID($dateID);
		$this->out['type'] 		= $this->summaryModel->getHazardType();
		$this->out['status'] 	= $this->summaryModel->getHazardStatus();
	}



	public function save() {

		$this->load->library('form_validation');

		$data = $this->input->post(null, false);
		
		$this->form_validation
			->set_rules('hazardType', 'Hazard Type', 
				'trim|required|integer');
		$this->form_validation
			->set_rules('hazardStatus', 'Hazard Status', 
				'trim|required|integer');
		$this->form_validation
			->set_rules('dateFrom', 'Timeline From', 
				'trim|required|regex_match[/^[0-9\-]+$/]');
		$this->form_validation
			->set_rules('dateTo', 'Timeline To', 
				'trim|required|regex_match[/^[0-9\-]+$/]');

		if ( ! $this->form_validation->run()) {
            $this->out = [
					'error' => 1,
					'msg'	=> validation_errors()
				];
			
			$this->session->set_userdata('sumDateId', $data['dateID']);

			echo json_encode($this->out);
			return FALSE;
		}
		
		$from 	= date_create($data['dateFrom']);
		$to 	= date_create($data['dateTo']);
		if (date_format($from, 'Y-m-d') > date_format($to, 'Y-m-d')) {
			$this->out = [
				'error' => 1,
				'msg'	=> 'Timeframe To date cannot be before the Timeframe From date.'
			];

			$this->session->set_userdata('sumDateId', $data['dateID']);

			echo json_encode($this->out);
			return FALSE;
		}

		$values = [
           $this->session->userdata('schoolId'),
           $data['dateID'],
           $data['hazardID'],
           $data['hazardType'],
           $data['hazardStatus'],
           $data['dateFrom'],
           $data['dateTo'],
           $this->session->userdata('username')
        ];

		if ( ! $this->summaryModel->saveSummary($values)) {
			$this->out = [
					'error' => 2,
					'msg'	=> 'Failed to update the Summary record.'
				];
			echo json_encode($this->out);
			return FALSE;
		}

		$this->out = [
				'error' => 0,
				'msg'	=> 'Successfully saved summary record.'
			];

		$this->session->set_userdata('sumDateId', $data['dateID']);

		echo json_encode($this->out);
		return TRUE;
	}
}