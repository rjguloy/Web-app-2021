<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sublocation extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('SubLocationModel', 'subLocationModel');

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


	public function add() {

		$this->load->library('form_validation');

		$this->form_validation
			->set_rules('sublocationName', 'sublocation name', 
				'trim|required|max_length[100]');
		$this->form_validation
			->set_rules('locationId', 'Location ID', 
				'trim|required|integer');
		$this->form_validation
			->set_rules('sublocationType', 'Sublocation Type', 
				'trim|required|integer');

		if ( ! $this->form_validation->run()) {
            $this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

		$data = $this->input->post(NULL, FALSE);

		if ( ! $this->subLocationModel->addSubLocation($data)) {
			$this->session->set_flashdata($this->subLocationModel->out);
			redirect($_SERVER['HTTP_REFERER']);
			return false;
		}

		$this->session->set_flashdata('error', 0);
        $this->session->set_flashdata('msg', 'Successfully added sublocation.');
        redirect($_SERVER['HTTP_REFERER']);
	}


	public function edit() {

		$this->load->library('form_validation');

		$this->form_validation
			->set_rules('sublocationName', 'Sublocation name', 
				'trim|required|max_length[100]');
		$this->form_validation
			->set_rules('locationId', 'Location ID', 
				'trim|required|integer');
		$this->form_validation
			->set_rules('sublocationId', 'Sublocation ID', 
				'trim|required|integer');
		$this->form_validation
			->set_rules('sublocationType', 'Sublocation Type', 
				'trim|required|integer');
		
		if ( ! $this->form_validation->run()) {
            $this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

		$data = $this->input->post(NULL, FALSE);

		if ($data['sublocationName'] == $data['origSublocName']) {
        	$this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', 'Cannot update with same Sublocation name.');
			redirect($_SERVER['HTTP_REFERER']);
			return false;
        }

		if ( ! $this->subLocationModel->updateSubLocation($data)) {
			$this->session->set_flashdata($this->subLocationModel->out);
			redirect($_SERVER['HTTP_REFERER']);
			return false;
		}

		$this->session->set_flashdata('error', 0);
        $this->session->set_flashdata('msg', 'Successfully updated sublocation.');
        redirect($_SERVER['HTTP_REFERER']);
	}


	public function delete($id = NULL) {

		if ( ! $id) {
			$this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', 'No reference to the record was given.');
            redirect($_SERVER['HTTP_REFERER']);
		}

		if ( ! $this->subLocationModel->deleteSubLocation($id)) {
			$this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', 'Failed to remove sublocation.');
            redirect($_SERVER['HTTP_REFERER']);
		}

		$this->session->set_flashdata('error', 0);
        $this->session->set_flashdata('msg', 'Successfully deleted sublocation.');
        redirect($_SERVER['HTTP_REFERER']);
	}

	public function getList(){
		$locationId = $this->input->post("id");
		$queryData = array($locationId);
		$list = $this->subLocationModel->getList($queryData);

		echo json_encode($list);
	}
}