<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MobileSync extends CI_Controller {

	public function __construct()
    {
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
    }

	public function index()
	{
		$this->load->view('mobilesync');		
	}
}