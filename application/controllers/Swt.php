<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Swt extends CI_Controller {

	public $out = [];

	public function __construct()
    {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('SwtModel', 'swt');
		$this->load->model('LocationsModel', 'loc');
		$this->load->model('HazardCategoryModel', 'hazard');
		
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
		$this->out['loc'] 			= NULL;
		$this->out['hazcat'] 		= NULL;
		$this->out['team'] 			= NULL;
		$this->out['permissions'] 	= NULL;
		
		$this->out['locs'] = $this->loc->getLocations();

		if ($buffer = $this->hazard->getHazardCategories()) {
			$count = 0;
			foreach ($buffer as $row) {
				
				$this->out['hazcat'][$count]['catId'] 		= $row['id'];
				$this->out['hazcat'][$count]['catName'] 	= $row['name'];
				$count++;
			}
		}

		$this->out['teams'] = $this->swt->getSwtMembers();

		$this->out['permissions'] = $this->swt->getSwtPermissions();

		$this->out['hasNoSchoolID'] = FALSE;

		if ( ! isset($_SESSION['schoolId'])) {
			$this->out['hasNoSchoolID'] = TRUE;
	    }

		$this->load->helper('form');

		$this->load->view('swt', $this->out);		
	}


	public function save() {

		$data = $this->input->post(null, false);
		
		$this->_savePermissions($data);

		if ( ! isset($this->out['error'])) {
			$this->out = [
				'error' => 0,
				'msg'	=> 'Successfully updated team assignments.'
			];
			echo json_encode($this->out);
			return TRUE;
		}
	}


	public function addMember($team = null) {

		if ( ! $team) {
			$this->out = [
				'error' => 2,
				'msg'	=> 'Invalid call to function.'
			];
			echo json_encode($this->out);
			return FALSE;
		}

		$data = $this->input->post(null, false);
		
		if ($this->swt->duplicateMemberCheck($data)) {
			
			$this->out = [
				'error' => 1,
				'msg'	=> 'Duplicate name is not allowed across teams.'
			];
			echo json_encode($this->out);
			return FALSE;
		}
		
		// Add the new members
		if ( ! $memID = $this->swt->saveMember($team, $data)) {
			
			$this->out = [
				'error' => 1,
				'msg'	=> 'Failed to save member records.'
			];
			echo json_encode($this->out);
			return FALSE;
		}
		
		$this->out = [
			'error' => 0,
			'msg'	=> 'Successfully added team member.',
			'memID' => $memID
		];
		echo json_encode($this->out);
		return TRUE;
	}


	public function removeMember() {

		$data = $this->input->post(null, false);

		if ( ! $this->swt->removeMember($data)) {
		
			$this->out = [
				'error' => 2,
				'msg'	=> 'Failed to remove member.'
			];
			echo json_encode($this->out);
			return FALSE;
		}

		$this->out = [
			'error' => 0,
			'msg'	=> 'Successfully deleted team member.'
		];
		echo json_encode($this->out);
		return TRUE;
	}

	private function _savePermissions($data) {

		$hasNoPermissions = FALSE;
		if ( ! isset($data['permission'])) {
			$hasNoPermissions = TRUE;
			$data['permission'][0][0] = '0-0';
		} 

		if ( ! $this->removePermissions($data)) {
			
			$this->out = [
				'error' => 2,
				'msg'	=> 'Failed to remove previous permissions.'
			];
			echo json_encode($this->out);
			return FALSE;
		}
		
		if ($hasNoPermissions) return TRUE; 

		if ( ! $this->addPermissions($data)) {
			
			$this->out = [
				'error' => 2,
				'msg'	=> 'Failed to add new permissions.'
			];
			echo json_encode($this->out);
			return FALSE;
		}

		return TRUE;
	}


	public function removePermissions($data) {

		$this->out['rec'] = $this->swt->getSwtPermissions();

		if ( ! $this->out['rec']) return TRUE;
		
		$buffer = array();
		foreach ($data['permission'] as $k => $v) {
			$buffer[] = $k;
		}

		$ids 	= join(', ', $buffer);

		if ( ! $buffer = $this->swt->removeSublocPermissionsCheck($ids)) {
			return TRUE;
		}

		foreach ($buffer as $row) {

			if ( ! $this->swt->removePermissions($row)) {
				
				$this->out = [
					'error' => 2,
					'msg'	=> 'Failed to remove new permissions.'
				];
				echo json_encode($this->out);
				return FALSE;
			}
		}

		return TRUE;
	}


	public function addPermissions($data) {
		
		foreach ($data['permission'] as $subLoc => $team) {

			$buffer = 0;
			if ($buffer = $this->swt->idExists($subLoc)) {
				
				if ($this->swt->updatePermissions($team, $subLoc)) 
					continue;
			}

			if ( ! $this->swt->addPermissions($buffer, $team, $subLoc)) {
				return FALSE;
			}
			
		}

		return TRUE;
	}
}