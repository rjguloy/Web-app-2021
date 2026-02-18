<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends CI_Controller {

	public $out = [];

	
	public function __construct() {
		parent::__construct();

		$this->load->helper('url');

        if(is_null($this->session->userdata('username'))){
			if (IS_SSO) redirect(LOGOUT_URL);
			redirect(base_url());
	        exit;
		}

		if ($this->session->role != 'SCHOOL') {
			redirect('home');
		}
		
		$this->load->model('LocationsModel', 'loc');
		$this->load->model('SubLocationModel', 'subLocationModel');

		$this->session->unset_userdata('caDateId');
		$this->session->unset_userdata('locationId');
		$this->session->unset_userdata('sublocationId');
		$this->session->unset_userdata('sumDateId');
		$this->session->unset_userdata('photoDateId');
	}


	public function index() {	

		$this->load->helper('form');
		$this->out = NULL;

		if ($data['recs'] = $this->loc->getLocations()) {
			$this->_assign_data($data['recs']);	
		}

		$this->out['hasNoSchoolID'] = FALSE;
		if ( ! isset($_SESSION['schoolId'])) {
			$this->out['hasNoSchoolID'] = TRUE;
		}

		$this->out['title'] = 'Locations - School Watching Activity';
		
		$this->load->view('locations', $this->out);		
	}

	public function add() {

		$this->load->library('form_validation');

		$this->form_validation
			->set_rules('locationName', 'location name', 
				'trim|required|max_length[100]');

		if ( ! $this->form_validation->run()) {
            $this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

		$data = $this->input->post('locationName');

		if ( ! $this->loc->addLocation($data)) {
			$this->session->set_flashdata($this->loc->out);
			redirect($_SERVER['HTTP_REFERER']);
			return false;
		}

		$this->session->set_flashdata('error', 0);
        $this->session->set_flashdata('msg', 'Successfully added location.');
        redirect($_SERVER['HTTP_REFERER']);
	}


	private function _assign_data($records) {

		$buffer = NULL;
		$count 	= 0;

		foreach ($records as $row){
			
			if ($buffer != $row['id']) {
				$buffer = $row['id'];
				$count 	= 0;
			}
			
			$this->out['recs'][$row['id']]['bldg_seqid'] 	= $row['bldg_seqid'];
			$this->out['recs'][$row['id']]['bldg_id'] 		= $row['id'];
			$this->out['recs'][$row['id']]['school_id'] 	= $row['school_id'];
			$this->out['recs'][$row['id']]['bldg'] 			= $row['bldg'];

			$this->out['recs'][$row['id']]['room'][$count]['room_seqid'] 	= $row['room_seqid'];
			$this->out['recs'][$row['id']]['room'][$count]['room_id'] 		= $row['room_id'];
			$this->out['recs'][$row['id']]['room'][$count]['name'] 			= $row['room'];
			$this->out['recs'][$row['id']]['room'][$count]['hazcat_type'] 	= $row['hazcat_type'];
			$count++;
		}
	}


	public function edit() {

		$this->load->library('form_validation');

		$this->form_validation
			->set_rules('locationName', 'Building name', 
				'trim|required|max_length[100]');
		$this->form_validation
			->set_rules('locationId', 'Building ID', 
				'trim|required|integer');

		if ( ! $this->form_validation->run()) {
            $this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = $this->input->post(NULL, FALSE);

        if ($data['locationName'] == $data['origLocName']) {
        	$this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', 'Cannot update with same location name.');
            redirect($_SERVER['HTTP_REFERER']);
        }

		if ( ! $this->loc->updateLocation($data)) {
			$this->session->set_flashdata($this->loc->out);
            redirect($_SERVER['HTTP_REFERER']);
		}

		$this->session->set_flashdata('error', 0);
        $this->session->set_flashdata('msg', 'Successfully updated location.');
        redirect($_SERVER['HTTP_REFERER']);
	}


	public function delete($id = NULL) {

		if ( ! $id) {
			$this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', 'No reference to the record was given.');
            redirect($_SERVER['HTTP_REFERER']);
		}

		if ( ! $this->loc->deleteLocation($id)) {
			$this->session->set_flashdata('error', 1);
            $this->session->set_flashdata('msg', 'Failed to delete location.');
            redirect($_SERVER['HTTP_REFERER']);
		}

		$this->session->set_flashdata('error', 0);
        $this->session->set_flashdata('msg', 'Successfully deleted location.');
        redirect($_SERVER['HTTP_REFERER']);
	}
}