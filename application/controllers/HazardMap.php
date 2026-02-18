<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HazardMap extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('LocationsModel', 'locationModel');
		$this->load->model('ChecklistActivityModel', 'checklistActivityModel');
		$this->load->helper('url');
		$this->load->helper('directory');

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
		$locationId = 0;
		$hasTemplate = false;
		$hazardMapList = array();

		if($this->input->post("locationId")){
			$locationId = $this->input->post("locationId");

			$hmDIR = "hm_output/image/hm/";
			$templateDIR = "hm_output/image/template/";

			$hasTemplate = false;
			if(file_exists($templateDIR.$locationId.".jpg")){
				$hasTemplate = true;
			}

			$hazardMapList = array();
			$hmFileList = array();
			if(is_dir($hmDIR)){
				$hmFileList = directory_map($hmDIR);
				foreach ($hmFileList as $fileName) {
					if(strpos($fileName, "hm-".$locationId) !== false){
						$cadId = substr($fileName, (strrpos($fileName , "-") + 1), -4);
						$cad = $this->checklistActivityModel->getByID($cadId);

						if(count($cad) > 0){
							$hazardMapDetails = array('fileName' => $hmDIR.$fileName, 'date' => $cad[0]->date);
							array_push($hazardMapList, $hazardMapDetails);
						}
					}
				}
			}
		}

		$data['locationId'] = $locationId;
		$data['hasTemplate'] = $hasTemplate;
		$data['hazardMaps'] = $hazardMapList;
		$data['locationList'] = $this->locationModel->getList();

		$this->load->view('hazard_map', $data);
	}

	// public function getHazardMaps()
	// {		
	// 	$locationId = $this->input->post("locationId");

	// 	$hmDIR = "hm_output/image/hm/";
	// 	$templateDIR = "hm_output/image/template/";

	// 	$hasTemplate = false;
	// 	if(file_exists($templateDIR.$locationId.".jpg")){
	// 		$hasTemplate = true;
	// 	}

	// 	$hazardMapList = array();
	// 	$hmFileList = array();
	// 	if(is_dir($hmDIR)){
	// 		$hmFileList = directory_map($hmDIR);
	// 		foreach ($hmFileList as $fileName) {
	// 			if(strpos($fileName, "hm-".$locationId) !== false){
	// 				$cadId = substr($fileName, (strrpos($fileName , "-") + 1), -4);
	// 				$cad = $this->checklistActivityModel->getByID($cadId);

	// 				if(count($cad) > 0){
	// 					$hazardMapDetails = array('fileName' => $hmDIR.$fileName, 'date' => $cad[0]->date);
	// 					array_push($hazardMapList, $hazardMapDetails);
	// 				}
	// 			}
	// 		}
	// 	}

	// 	$output['hasTemplate'] = $hasTemplate;
	// 	$output['hazardMaps'] = $hazardMapList;

	// 	echo json_encode($output);
	// }
}