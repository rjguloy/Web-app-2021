<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comparative extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
    	$this->load->model('ComparativeDataModel', 'comparativeModel');
    	$this->load->model('ChecklistActivityModel', 'cadModel');
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
		$data['list'] = $this->comparativeModel->getList();
		$data['cad'] = $this->cadModel->getLast3Dates();

		if(count($data['cad']) == 0){
			$data['cad'] = array((object) ["date" => "No Checklist Date"]);
		}

		$this->load->view('comparative', $data);
	}
}