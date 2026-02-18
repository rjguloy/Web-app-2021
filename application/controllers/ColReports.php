<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ColReports extends CI_Controller {

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
        $this->load->model('ChecklistActivityModel', 'checklistActivityModel');
        $this->load->model('ColHazardModel', 'colHazardModel');

    }

	public function index()
	{
        $this->out['years']     = $this->colReportsModel->getYearList();
        $this->out['items']     = $this->colReportsModel->getItemList();
        $this->out['regions']   = $this->colReportsModel->getRegions();

        if ($this->session->role == 'REGIONCOORD') {
            $this->out['divisions']   = $this->colReportsModel->getDivisions($this->session->regionID);
        }

        if ($this->session->role == 'DIVISIONCOORD') {
            
            $this->out['divisions']   = $this->colReportsModel->getDivision($this->session->divisionID);
            $this->out['schools']   = $this->colReportsModel->getSchools($this->session->divisionID);
        }
        
        if ($this->session->role == 'SCHOOLCOORD') {
            $this->out['divisions']   = $this->colReportsModel->getDivision($this->session->divisionID);
            $this->out['schools']   = $this->colReportsModel->getSchool($this->session->schoolID);
            $this->out['dates']   = $this->colReportsModel->getDates($this->session->schoolID);
        }

		$this->load->view('colreports', $this->out);		
	}


    public function getDivisions() {
        
        $data = $this->input->get(null, false);

        $this->out['divisions']   = $this->colReportsModel->getDivisions($data);

        echo json_encode($this->out);
    }


    public function getSchools() {
        
        $data = $this->input->get(null, false);

        $this->out['schools']   = $this->colReportsModel->getSchools($data);

        echo json_encode($this->out);
    }
    

    public function getDates() {
        
        $data = $this->input->get(null, false);

        $this->out['dates']   = $this->colReportsModel->getDates($data);

        echo json_encode($this->out);
    }

    
    public function getEvents() {
        $data = $this->input->get(null, false);

        $hazardCount = 0;
        $capacityCount = 0;
        $additionalCount = 0;

        $topTenHazardNamesArray = array();
        $hazardArray = array();

        $hazardStatusArray = array();
        $capacityStatusArray = array();
        $additionalStatusArray = array();
        $hazardTypeArray = array();
        $capacityTypeArray = array();
        $additionalTypeArray = array();

		try {
            /* Read retrieved records/data */
            $recordArray = $this->colReportsModel->getReportList($data);
            foreach($recordArray as $record){
                switch($record['type']){
                    CASE 'HAZARD': 
                        $hazardCount+=$record['item_count'];

                        if(in_array($record['item'], $topTenHazardNamesArray)){
                            $hazardArray[$record['item']] = $hazardArray[$record['item']] + $record['item_count'];
                        }else{
                            array_push($topTenHazardNamesArray, $record['item']);
                            $hazardArray[$record['item']] = $record['item_count'];
                        }

                        array_push($hazardStatusArray, $record['hazardstatus_name']);                
                        array_push($hazardTypeArray, $record['hazardtype_name']);
                        break;
                    CASE 'CAPACITY': 
                        $capacityCount+=$record['item_count'];
                        array_push($capacityStatusArray, $record['hazardstatus_name']);                
                        array_push($capacityTypeArray, $record['hazardtype_name']);
                        break;
                    CASE 'ADDITIONAL': 
                        $additionalCount+=$record['item_count'];
                        array_push($additionalStatusArray, $record['hazardstatus_name']);                
                        array_push($additionalTypeArray, $record['hazardtype_name']);
                        break;
                }
            }

            /* Overall Repored Hazards */
            $overallReportedHazard['hazard'] = $hazardCount;
            $overallReportedHazard['capacity'] = $capacityCount;
            $overallReportedHazard['additional'] = $additionalCount;

            arsort($hazardArray);
            $hazardArray = array_slice($hazardArray, 0, 10);
            $hazard['name'] = array_keys($hazardArray);
            $hazard['count'] = array_values($hazardArray);
            
            /* Reported Hazard per Hazard Status*/
            $hazardStatusList = $this->colHazardModel->getHazardStatusList();
            $statusList = array();
            $hazardStatusCount = array();
            $capacityStatusCount = array();
            $additionalStatusCount = array();

            $hazardStatusArrayTemp = array_count_values($hazardStatusArray);
            $capacityStatusArrayTemp = array_count_values($capacityStatusArray);
            $additionalStatusArrayTemp = array_count_values($additionalStatusArray);

            foreach($hazardStatusList as $hazardStatus){
                if(array_key_exists($hazardStatus->name, $hazardStatusArrayTemp)){
                    array_push($hazardStatusCount, $hazardStatusArrayTemp[$hazardStatus->name]);
                }else{
                    array_push($hazardStatusCount, 0);
                }

                if( array_key_exists($hazardStatus->name, $capacityStatusArrayTemp)){
                    array_push($capacityStatusCount, $capacityStatusArrayTemp[$hazardStatus->name]);
                }else{
                    array_push($capacityStatusCount, 0);
                }

                if(array_key_exists($hazardStatus->name, $additionalStatusArrayTemp)){
                    array_push($additionalStatusCount, $additionalStatusArrayTemp[$hazardStatus->name]);
                }else{
                    array_push($additionalStatusCount, 0);
                }

                array_push($statusList, $hazardStatus->name);
            }

            $statusArray['list'] = $statusList;
            $statusArray['hazard'] = $hazardStatusCount;
            $statusArray['capacity'] = $capacityStatusCount;
            $statusArray['additional'] = $additionalStatusCount;

            /* Reported Hazard per Hazard Type*/
            $hazardTypeList = $this->colHazardModel->getHazardTypeList();
            $typeList = array();
            $hazardTypeCount = array();
            $capacityTypeCount = array();
            $additionalTypeCount = array();

            $hazardTypeArrayTemp = array_count_values($hazardTypeArray);
            $capacityTypeArrayTemp = array_count_values($capacityTypeArray);
            $additionalTypeArrayTemp = array_count_values($additionalTypeArray);

            foreach($hazardTypeList as $hazardType){
                if(array_key_exists($hazardType->name, $hazardTypeArrayTemp)){
                    array_push($hazardTypeCount, $hazardTypeArrayTemp[$hazardType->name]);
                }else{
                    array_push($hazardTypeCount, 0);
                }

                if( array_key_exists($hazardType->name, $capacityTypeArrayTemp)){
                    array_push($capacityTypeCount, $capacityTypeArrayTemp[$hazardType->name]);
                }else{
                    array_push($capacityTypeCount, 0);
                }

                if(array_key_exists($hazardType->name, $additionalTypeArrayTemp)){
                    array_push($additionalTypeCount, $additionalTypeArrayTemp[$hazardType->name]);
                }else{
                    array_push($additionalTypeCount, 0);
                }

                array_push($typeList, $hazardType->name);
            }

            $typeArray['list'] = $typeList;
            $typeArray['hazard'] = $hazardTypeCount;
            $typeArray['capacity'] = $capacityTypeCount;
            $typeArray['additional'] = $additionalTypeCount;

            /* Data for AJAX */
            $this->out['records'] = $recordArray;
            $this->out['submissions'] = $this->colReportsModel->getSubmissionStats($data);
            $this->out['overallReportedHazard'] = $overallReportedHazard; // count data
            $this->out['hazardArray'] = $hazard; // pie chart data
            $this->out['hazardStatusArray'] = $statusArray;
            $this->out['hazardTypeArray'] = $typeArray;
		} catch (Exception $e) {
            $this->out['error'] = 1;
			$this->out['msg'] = "System error. Please contact your administrator.";
		}
		
		echo json_encode($this->out);
    }



    /*
    Export table data to excel
    */
    public function export(){
        $exportDIR = "col_reports/";

        if (!is_dir($exportDIR)) {
            mkdir($exportDIR, 0777, TRUE);
        }

        $year = $this->input->get("reports-year");
        $hazardId = $this->input->get("reports-item");
        $regionId = $this->input->get("sel-region");
        $divisionId = $this->input->get("sel-division");
        $schoolId = $this->input->get("sel-school");
        $cadId = $this->input->get("sel-cad");
        $queryData = array(
                        'year_id'       => $year, 
                        'item_id'     => $hazardId, 
                        'region_id'     => $regionId, 
                        'division_id'   => $divisionId, 
                        'school_id'     => $schoolId, 
                        'date_id'        => $cadId
                    );
        $data = $this->colReportsModel->getReportList($queryData); 
        
        $fileName = 'Central_Office_Report.xlsx';
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->setTitle('Checklist Activity Raw Data');

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Region');
        $sheet->setCellValue('B1', 'Division');
        $sheet->setCellValue('C1', 'School');
        $sheet->setCellValue('D1', 'Checklist Date');   
        $sheet->setCellValue('E1', 'Item');  
        $sheet->setCellValue('F1', 'Hazard Count');  
        $sheet->setCellValue('G1', 'Hazard Type');  
        $sheet->setCellValue('H1', 'Timeframe');  
        $sheet->setCellValue('I1', 'Status'); 
        
        $rows = 2;
        foreach ($data as $val){
            $sheet->setCellValue('A' . $rows, $val['region_name']);
            $sheet->setCellValue('B' . $rows, $val['division_name']);
            $sheet->setCellValue('C' . $rows, $val['school_name']);
            $sheet->setCellValue('D' . $rows, $val['date']);
            $sheet->setCellValue('E' . $rows, $val['item']);
            $sheet->setCellValue('F' . $rows, $val['item_count']);
            $sheet->setCellValue('G' . $rows, $val['hazardtype_name']);
            $sheet->setCellValue('H' . $rows, $val['timeline']);
            $sheet->setCellValue('I' . $rows, $val['hazardstatus_name']);
            $rows++;
        }  
        
        $writer = new Xlsx($spreadsheet);
        $writer->save($exportDIR.$fileName);
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/".$exportDIR.$fileName);        
    }
}