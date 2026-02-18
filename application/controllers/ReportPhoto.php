<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportPhoto extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->helper(['url', 'form']);
		$this->load->model('ChecklistActivityModel', 'checklistActivityModel');
		$this->load->model('reportPhotoModel');

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
		
    }

	public function index()
	{
		$this->out['dateID'] 	= null;
		$this->out['records'] 	= null;

		if ($this->input->post('dateID')) {
			$this->session->set_userdata('photoDateId', $this->input->post('dateID'));
			$this->out['dateID']  = $this->input->post('dateID');
			$buffer = $this->reportPhotoModel->getListByDate($this->out['dateID']);
			$this->out['records'] = $this->_arrangeRecords($buffer);
		} else if ($this->session->photoDateId) {
			$this->out['dateID']  = $this->session->photoDateId;
			$buffer = $this->reportPhotoModel->getListByDate($this->out['dateID']);
			$this->out['records'] = $this->_arrangeRecords($buffer);
		}

		$this->out['dates'] = $this->checklistActivityModel->getList();

		$this->load->view('reportphoto', $this->out);		
	}


	public function save() {

		$this->load->library('form_validation');
		
		$data = $this->input->post(null, false);
		
		$this->form_validation
			->set_rules('hazardDesc', 'Description', 
				'trim|required');
		$this->form_validation
			->set_rules('hazardAction', 'Planned Action', 
				'trim|required');

		if ( ! $this->form_validation->run()) {
            $this->out = [
					'error' => 1,
					'msg'	=> validation_errors()
				];
			echo json_encode($this->out);
			return FALSE;
        }

		if ($this->reportPhotoModel->hasActionRecord($data['recordId'])) {
				if ( ! $this->reportPhotoModel->updateAction($data)) {
					$this->out = [
					'error' => 1,
					'msg'	=> 'Failed to save hazard photos action.'
				];
				echo json_encode($this->out);
				return FALSE;
			}

			$this->out = [
				'error' => 0,
				'msg'	=> 'Successfully saved hazard photos action.'
			];
			echo json_encode($this->out);
			return TRUE;			
		}

		if ( ! $this->reportPhotoModel->saveAction($data)) {
			$this->out = [
				'error' => 1,
				'msg'	=> 'Failed to save hazard photos action.'
			];
			echo json_encode($this->out);
			return FALSE;
		}

		$this->out = [
			'error' => 0,
			'msg'	=> 'Successfully saved hazard photos action.'
		];
		echo json_encode($this->out);
		return TRUE;
	}


	private function _arrangeRecords($data) {

		if ( ! $data) return null;

		$counter 	= 0;
		$count 		= 0;
		$subcount 	= 0;
		$buffer 	= $data[0]->record_id;
		
		foreach ($data as $row) {
			
			$out[$count]['record_id'] 					= $row->record_id;
			$out[$count]['hazard_id'] 					= $row->hazard_id;
			$out[$count]['hazard_name']					= $row->hazard_name;
			$out[$count]['action_id']					= $row->action_id;
			$out[$count]['desc']						= $row->desc;
			$out[$count]['action']						= $row->action;
			$out[$count]['photo'][$subcount]['id'] 		= $row->photo_id;
			$out[$count]['photo'][$subcount]['image'] 	= $row->image;
			$subcount++;
			
			if ($counter < count($data)-1) {
				if ($buffer != $data[$counter+1]->record_id) {
					$buffer = $data[$counter+1]->record_id;
					$count++;
					$subcount = 0;
				}
			}
			
			$counter++;
		}

		return $out;
	}


	public function delete() {

		$data = $this->input->post('recordId');
		
		if ( ! $data) {
			$this->out = [
				'error' => 1,
				'msg'	=> 'Missing parameter. Process cancelled.'
			];
			echo json_encode($this->out);
			return FALSE;
		}

		if ( ! $buffer = $this->reportPhotoModel->getDetailsToDelete($data)) {
			$this->out = [
				'error' => 1,
				'msg'	=> 'No photos to remove.'
			];
			echo json_encode($this->out);
			return FALSE;
		}

		foreach ($buffer as $row) {
			if ( ! $this->reportPhotoModel->deleteImages($row->id, $data)) {
				$this->out = [
					'error' => 1,
					'msg'	=> 'Failed to delete hazard photos.'
				];
				echo json_encode($this->out);
				return FALSE;
			}
		}
		
		$this->out = [
			'error' => 0,
			'msg'	=> 'Successfully deleted hazard photos.'
		];
		echo json_encode($this->out);
		return TRUE;
	}
}