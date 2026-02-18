<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checklist extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('ChecklistModel');
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
		$data['hazards'] = $this->ChecklistModel->getListByType("HAZARD");
		$data['capacity'] = $this->ChecklistModel->getListByType("CAPACITY");

		$this->load->view('checklist',$data);
	}

}