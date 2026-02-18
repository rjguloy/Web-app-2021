<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schoolinfo extends CI_Controller {

	public $out = null;

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

		$this->load->model('SchoolInfoModel', 'info');

		$this->session->unset_userdata('caDateId');
		$this->session->unset_userdata('locationId');
		$this->session->unset_userdata('sublocationId');
		$this->session->unset_userdata('sumDateId');
		$this->session->unset_userdata('photoDateId');
	}


	public function index() {

		//Loading url helper
		$this->load->helper('form');

		$this->out['info'] = NULL;

		if ($this->info->getInfo()) {
			$this->out = $this->info->out;	
		}

		$this->out['ip'] 	= $this->_getIP();
		$this->out['title'] = 'School Information - School Watching Activity';

		$this->load->view('school_info', $this->out);
	}


	private function _getIP() {

		// Common code in getting getIP.
	    $thisIP = $_SERVER['SERVER_ADDR'];

	    // If does not work, try Windows getIP command.
	    if (PHP_OS == 'WINNT'){
	        $thisIP = getHostByName(getHostName());

	        if ($thisIP == "127.0.0.1") {
	        	$thisIP = "NOT CONNECTED.";
	        }
	    }

	    return $thisIP;
	}


	public function save() {

		$this->load->library('form_validation');

		$this->form_validation
			->set_rules('schoolid', 'School ID', 
				'trim|required|integer');
		$this->form_validation
			->set_rules('server', 'Deped Server', 
				'trim|integer');
		$this->form_validation
			->set_rules('schoolname', 'School name', 
				'trim|required|max_length[100]');
		$this->form_validation
			->set_rules('schooladdress', 'School address', 
				'trim|max_length[255]');
		$this->form_validation
			->set_rules('approver', 'Approver', 
				'trim|max_length[50]');
		$this->form_validation
			->set_rules('reviewer', 'Reviewer', 
				'trim|max_length[50]');

		if ( ! $this->form_validation->run()) {
            $this->out['error'] = 1;
            $this->out['msg'] = validation_errors();
			echo json_encode($this->out);
			return;
        }

		$data = $this->input->post(NULL, FALSE);

		if ( ! $this->info->save($data)) {
			$this->out = $this->loc->out;
            echo json_encode($this->out);
			return;
		}

		$this->out['error'] = 0;
        $this->out['msg'] = 'Successfully updated school information.';
        echo json_encode($this->out);
	}
}
