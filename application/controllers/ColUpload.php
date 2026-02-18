<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ColUpload extends CI_Controller {

	public function __construct()
{
        parent::__construct();

        $this->load->helper('url');
        
        if(is_null($this->session->userdata('username'))){
            if (IS_SSO) redirect(LOGOUT_URL);
            redirect(base_url());
            exit;
        }

        if ($this->session->role == 'SCHOOL') {
            redirect('home');
        }

        $this->load->model('ColReportsModel', 'colReportsModel');

        $this->session->unset_userdata('caDateId');
		$this->session->unset_userdata('locationId');
		$this->session->unset_userdata('sublocationId');
		$this->session->unset_userdata('sumDateId');
		$this->session->unset_userdata('photoDateId');
    }

	public function index(){
		$this->load->view('colupload');		
	}

    public function import(){
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $message = true;
        try{
            if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
             
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $reader->setLoadAllSheets();
                $worksheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetCount = $worksheet->getSheetCount();
                $excelData = array();
                
                /* Start read excel data*/
                $error = false;
                for ($i = 0; $i < $sheetCount; $i++) {
                    $sheet = $worksheet->getSheet($i);
                    $sheetData = $sheet->toArray(null, true, true, false);
                    array_shift($sheetData);

                    if($i == 0 && count($sheetData) < 1){ // if no data in CAD - invalid data
                        $message = "No checklist activity date recorded.";
                        $error = true;
                        break;
                    }

                    if($i == 4 && count($sheetData) < 1){ // if no data in Records - invalid data
                        $message = "Checklist date have no reported hazards.";
                        $error = true;
                        break;
                    }

                    $rowDataArray = array();
                    switch($i){
                        CASE 0: 
                            $key = 'cad'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['date'] = $value; break;
                                        CASE 3: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 1: 
                            $key = 'location'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['name'] = $value; break;
                                        CASE 3: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 2: 
                            $key = 'sublocation'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['location_id'] = $value; break;
                                        CASE 3: $rowData['name'] = $value; break;
                                        CASE 4: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 3: 
                            $key = 'additionalHazard'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['name'] = $value; break;
                                        CASE 3: $rowData['description'] = $value; break;
                                        CASE 4: $rowData['type'] = $value; break;
                                        CASE 5: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 4: 
                            $key = 'record'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['cad_id'] = $value; break;
                                        CASE 3: $rowData['sublocation_id'] = $value; break;
                                        CASE 4: $rowData['hazard_id'] = $value; break;
                                        CASE 5: $rowData['validationdate'] = $value; break;
                                        CASE 6: $rowData['validatedby'] = $value; break;
                                        CASE 7: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 5: 
                            $key = 'recordphoto'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['record_id'] = $value; break;
                                        CASE 3: $rowData['image'] = $value; break;
                                        CASE 4: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 6: 
                            $key = 'recordaction'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['record_id'] = $value; break;
                                        CASE 3: $rowData['description'] = $value; break;
                                        CASE 4: $rowData['action'] = $value; break;
                                        CASE 5: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 7: 
                            $key = 'narrative'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['cad_id'] = $value; break;
                                        CASE 3: $rowData['description'] = $value; break;
                                        CASE 4: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                        CASE 8: 
                            $key = 'summary'; 
                            foreach($sheetData as $row) {
                                $rowData = array();
                                foreach($row as $rowNum => $value) {
                                    switch($rowNum){
                                        CASE 0: $rowData['id'] = $value; break;
                                        CASE 1: $rowData['school_id'] = $value; break;
                                        CASE 2: $rowData['cad_id'] = $value; break;
                                        CASE 3: $rowData['hazard_id'] = $value; break;
                                        CASE 4: $rowData['hazardtype_id'] = $value; break;
                                        CASE 5: $rowData['hazardstatus_id'] = $value; break;
                                        CASE 6: $rowData['from'] = $value; break;
                                        CASE 7: $rowData['to'] = $value; break;
                                        CASE 8: $rowData['createdby'] = $value; break;
                                    }
                                }
                                array_push($rowDataArray, $rowData);
                            }
                            break;
                    }

                    $excelData[$key] = $rowDataArray; // converted data with correct table headers
                }
                /* End read excel data*/
               
                if(!$error){
                    if (!$this->colReportsModel->validSchoolID($excelData['cad'][0]['school_id'])) {
                        echo 'Invalid School ID.';
                        return;
                    }
                    
                    if(!$this->colReportsModel->createDataFromLocal($excelData)){
                        $message = "File uploaded may be invalid."; // happens when data is incomplete or invalid
                    }
                }
            }else{
                $message = "File uploaded may be invalid.";
            }
        }catch( Exception $e ){
            $message = "System error. Please contact administrator1.";
        }

        echo $message;
    }
}