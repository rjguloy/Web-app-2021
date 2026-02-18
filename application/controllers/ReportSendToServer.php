<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once(APPPATH . '/libraries/CreatorJwt.php');
require_once(APPPATH . '/libraries/TCPDF-master/MyTCPDF.php');

class ReportSendToServer extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->model('ChecklistActivityModel', 'checklistActivityModel');
		$this->load->model('Reports', 'reportsModel');
        $this->load->model('SchoolInfoModel', 'schoolModel');
        $this->load->model('SummaryModel', 'summaryModel');
        $this->load->model('UserModel', 'userModel');
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
		$data['dates'] = $this->checklistActivityModel->getList();

		$hazardList = array();
		$hazardPhoto = array();
		$cadId = 0;

		if($this->input->post("checklist-activity-date")){
			$cadId = $this->input->post("checklist-activity-date");
			$queryData = array($cadId);

			$hazardList = $this->reportsModel->getSendToServerHazard($queryData);
			$hazardPhoto = $this->reportsModel->getSendToServerPhoto($queryData);
			$cadId = $cadId;
		}

		$data['hazardList'] = $hazardList;
		$data['photoList'] = $hazardPhoto;
		$data['selectedCad'] = $cadId;

		$this->load->view('reportsendtoserver', $data);		
	}

	public function sendToCOServer(){
		$cadId = $this->input->post("cadid");
		$queryData = array($cadId);

        // 1. select all data for insertion
        $data = $this->reportsModel->getSendToServerData($queryData);

        if(!empty($data['record'])){

            $this->objOfJwt = new CreatorJwt();

            $tokenData['schoolID'] = $this->session->schoolId; 
            $tokenData['username'] = $this->session->username; 
            $tokenData['timeStamp'] = Date('Y-m-d h:i:s'); 
            
            $jwtToken = $this->objOfJwt->GenerateToken($tokenData); 
            
            /* 2. send all selected data into col server
                    - location and sublocation - only insert new data */

            // Convert the Images
            $count = 0;
            foreach ($data['recordphoto'] as $row) {
                $data['recordphoto'][$count]->image = urlencode(base64_encode($row->image));
                $count++;
            }

            $payload = json_encode($data);
            
            // Prepare new cURL resource
            $ch = curl_init(COL_SERVER . '/SwappApi/insertDataFromLocal');
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                
            // Set HTTP Header for POST request 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload),
                'Authorization: Bearer ' . $jwtToken)
            );
                
            // Submit the POST request
            $success = curl_exec($ch);
            
            // Close cURL session handle
            curl_close($ch);

            
            if($success){
                //3. delete all selected data, except for location and sublocation
                $success = $this->reportsModel->deleteSynchedData($queryData);
            } 
            
            if($success){
                echo true;
            }else{
                echo "Sending of data to central office server failed. Please contact administrator.";
            }
        }else{
            echo "Checklist date have no reported hazards.";
        }
	}

	/*
	Data for export should be the same data with sendToCOServer
	*/
	public function export(){
		$exportDIR = "send_to_server_files/";

		if (!is_dir($exportDIR)) {
		    mkdir($exportDIR, 0777, TRUE);
		}

		$cadId = $this->input->post("checklist-activity-date");
		$queryData = array($cadId);
		
		$data = $this->reportsModel->getSendToServerData($queryData);

		$fileName = 'Checklist_Activity_Data_'.$data['cad'][0]->date.'.xlsx';
		$spreadsheet = new Spreadsheet();
       
        // 1 Sheet for Checklist Activity Date
		$spreadsheet->getActiveSheet()->setTitle('Checklist Activity Setting');

        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Date');
        $sheet->setCellValue('D1', 'Created By');   
        
        $rows = 2;
        foreach ($data['cad'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->date);
            $sheet->setCellValue('D' . $rows, $val->createdby);
            $rows++;
        } 

        // 2 Sheet for Locations
		$spreadsheet->createSheet()->setTitle('Locations');
		$spreadsheet->setActiveSheetIndex(1);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Created By');   
        
        $rows = 2;
        foreach ($data['location'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->name);
            $sheet->setCellValue('D' . $rows, $val->createdby);
            $rows++;
        }       

        // 3 Sheet for Sub Locations
		$spreadsheet->createSheet()->setTitle('Sub Locations');
		$spreadsheet->setActiveSheetIndex(2);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Location ID');
        $sheet->setCellValue('D1', 'Name');   
        $sheet->setCellValue('E1', 'Created By');   
        
        $rows = 2;
        foreach ($data['sublocation'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->location_id);
            $sheet->setCellValue('D' . $rows, $val->name);
            $sheet->setCellValue('E' . $rows, $val->createdby);
            $rows++;
        } 

        // 4 Sheet for Additional Hazards
		$spreadsheet->createSheet()->setTitle('Additional Hazards');
		$spreadsheet->setActiveSheetIndex(3);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Name');   
        $sheet->setCellValue('D1', 'Description');   
        $sheet->setCellValue('E1', 'Type');   
        $sheet->setCellValue('F1', 'Created By');   
        
        $rows = 2;
        foreach ($data['additionalHazard'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->name);
            $sheet->setCellValue('D' . $rows, $val->description);
            $sheet->setCellValue('E' . $rows, $val->type);
            $sheet->setCellValue('F' . $rows, $val->createdby);
            $rows++;
        } 

        // 5 Sheet for Records
		$spreadsheet->createSheet()->setTitle('Records');
		$spreadsheet->setActiveSheetIndex(4);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Checklist Activity ID');
        $sheet->setCellValue('D1', 'Sub Location ID');
        $sheet->setCellValue('E1', 'Hazard ID');
        $sheet->setCellValue('F1', 'Validation Date');   
        $sheet->setCellValue('G1', 'Validated By');   
        $sheet->setCellValue('H1', 'Created By');   
        
        $rows = 2;
        foreach ($data['record'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->cad_id);
            $sheet->setCellValue('D' . $rows, $val->sublocation_id);
            $sheet->setCellValue('E' . $rows, $val->hazard_id);
            $sheet->setCellValue('F' . $rows, $val->validationdate);
            $sheet->setCellValue('G' . $rows, $val->validatedby);
            $sheet->setCellValue('H' . $rows, $val->createdby);
            $rows++;
        } 		        

        // 6 Sheet for Record Photos
		$spreadsheet->createSheet()->setTitle('Record Photos');
		$spreadsheet->setActiveSheetIndex(5);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Record ID');
        $sheet->setCellValue('D1', 'Image');   
        $sheet->setCellValue('E1', 'Created By');   
        
        $rows = 2;
        foreach ($data['recordphoto'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->record_id);
            $sheet->setCellValue('D' . $rows, $val->image);
            $sheet->setCellValue('E' . $rows, $val->createdby);
            $rows++;
        }  		        

        // 7 Sheet for Record Actions
		$spreadsheet->createSheet()->setTitle('Record Actions');
		$spreadsheet->setActiveSheetIndex(6);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Record ID');
        $sheet->setCellValue('D1', 'Description');   
        $sheet->setCellValue('E1', 'Action');   
        $sheet->setCellValue('F1', 'Created By');   
        
        $rows = 2;
        foreach ($data['recordaction'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->record_id);
            $sheet->setCellValue('D' . $rows, $val->description);
            $sheet->setCellValue('E' . $rows, $val->action);
            $sheet->setCellValue('F' . $rows, $val->createdby);
            $rows++;
        }   		        

        // 8 Sheet for Record Actions
		$spreadsheet->createSheet()->setTitle('Narrative');
		$spreadsheet->setActiveSheetIndex(7);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Checklist Activity Date ID');
        $sheet->setCellValue('D1', 'Description');   
        $sheet->setCellValue('E1', 'Created By');   
        
        $rows = 2;
        foreach ($data['narrative'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->cad_id);
            $sheet->setCellValue('D' . $rows, $val->description);
            $sheet->setCellValue('E' . $rows, $val->createdby);
            $rows++;
        }   		        

        // 9 Sheet for Record Actions
		$spreadsheet->createSheet()->setTitle('Summary');
		$spreadsheet->setActiveSheetIndex(8);
		
        $sheet = $spreadsheet->getActiveSheet();
       	$sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'School ID');
        $sheet->setCellValue('C1', 'Checklist Activity Date ID');
        $sheet->setCellValue('D1', 'Hazard ID');  
        $sheet->setCellValue('E1', 'Hazard Type ID');   
        $sheet->setCellValue('F1', 'Hazard Status ID');   
        $sheet->setCellValue('G1', 'Timeframe From');   
        $sheet->setCellValue('H1', 'Timeframe To');    
        $sheet->setCellValue('I1', 'Created By');   
        
        $rows = 2;
        foreach ($data['summary'] as $val){
            $sheet->setCellValue('A' . $rows, $val->id);
            $sheet->setCellValue('B' . $rows, $val->school_id);
            $sheet->setCellValue('C' . $rows, $val->cad_id);
            $sheet->setCellValue('D' . $rows, $val->hazard_id);
            $sheet->setCellValue('E' . $rows, $val->hazardtype_id);
            $sheet->setCellValue('F' . $rows, $val->hazardstatus_id);
            $sheet->setCellValue('G' . $rows, $val->from);
            $sheet->setCellValue('H' . $rows, $val->to);
            $sheet->setCellValue('I' . $rows, $val->createdby);
            $rows++;
        }       
        
        $writer = new Xlsx($spreadsheet);
		$writer->save($exportDIR.$fileName);
		header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."/".$exportDIR.$fileName);        
    }
    

    public function generatePdf($cad = 0) {

		if ( ! $cad) { 
			show_404(); 
			return false; 
		}

		$concatList = function($data, $cat) {
			$buffer = '';
			$match = false;
			foreach ($data as $row) {
                if ($row->type != $cat) continue;
                if ( $row->type == 'HAZARD' &&! $row->hazard_count) continue;
				$buffer .= '<tr><td></td><td>'.$row->name.'</td><td class="r">'.$row->hazard_count.'</td></tr>';
			}

			return $buffer;
        };
        
        $detailList = function ($data, $cat) {
            $buffer = '';
            foreach ($data as $key => $val) {
                if ($val['type'] != $cat) continue;
                $from = null; $to = null;
                if ($val['from'])   $from   = date_create($val['from']);
                if ($val['to'])     $to     = date_create($val['to']);
                $buffer .= '<tr><td>'.$key.'</td>
                                <td>'.($from ? date_format($from, 'd M Y') : '').'</td>
                                <td>'.($to ? date_format($to, 'd M Y') : '').'</td>
                                <td>'.$val['type_name'].'</td>
                                <td>'.$val['status_name'].'</td>
                            </tr>';
            }

            return $buffer;
        };
        
        if ( ! $this->schoolModel->getInfo()) return false;
        
        $data['user'] = $this->userModel->getByUsername($this->session->username);

		$data['info'] = $this->schoolModel->out['info'];

		$rawDate			= $this->checklistActivityModel->getByID($cad);	
		$rawDate 			= date_create($rawDate[0]->date);
		$data['cadDate'] 	= date_format($rawDate, 'd F Y'); 

		$rawData = $this->reportsModel->getHazardsCount($cad);
		foreach ($rawData as $row) {
			switch($row->type) {
				case 'HAZARD'		: $data['count']['hazard'] 		= $row->hazard_count; break;
				case 'CAPACITY'		: $data['count']['capacity'] 	= $row->hazard_count; break;
				case 'ADDITIONAL'	: $data['count']['others'] 		= $row->hazard_count; break;
			}
		}

		$data['list'] = $this->reportsModel->getListByDateID($cad);

		$rawData = $this->reportsModel->getHazardStatusCount($cad);

		foreach ($rawData as $row) {
			$data[$row->hazardstatus_name] = $row->status_count;
		}

		$rawData = $this->reportsModel->getHazardTypeCount($cad);

		foreach ($rawData as $row) {
			$data[$row->hazardtype_name] = $row->type_count;
		}

		$rawData = $this->reportsModel->getSummaryList($cad);

		foreach ($rawData as $row) {
            $data['details'][$row->name]['type']           = $row->type;
            $data['details'][$row->name]['from']           = $row->from;
            $data['details'][$row->name]['to']             = $row->to;
            $data['details'][$row->name]['type_name']      = $row->type_name;
            $data['details'][$row->name]['status_name']    = $row->status_name;
		}

		$data['narrative'] = $this->reportsModel->getNarrative($cad);
        
        // create new PDF document
        $pdf = new MyTCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->session->username);
        $pdf->SetTitle('Deped - School Watching Activity Report');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFontSize(11);
        // add a page
        $pdf->AddPage();

        $html = '<style>
                    table.box-table {
                        margin: 10px 0px;
                        border:1px solid #CCCCCC; 
                    }
                    th.box-header {
                        background-color:#CBE5FE;     
                        border-bottom:1px solid #CCCCCC;
                    }
                    div.box {
                        color:#FFFFFF;
                        text-align:right;
                    }
                    h2.border {
                        border-bottom:1px solid #222222;
                    }
                    th.r, td.r {
                        text-align:right;
                    }
                    tr.white-color {
                        color:#FFFFFF;
                        font-weight:bold;
                        text-align:center;
                    }
                </style>
                <table width="100%" border="1" cellpadding="3" cellspacing="0" style="">
                    <tbody>
                        <tr><td style="width:25%">School Name</td><td style="width:75%">'.$data['info']['name'].'</td></tr>
                        <tr><td>School ID</td><td>'.$data['info']['id'].'</td></tr>
                        <tr><td>Date</td><td>'.$data['cadDate'].'</td></tr>
                    </tbody>
                </table>
                <br /><br />
                <table class="box-table" width="100%" cellpadding="5" cellspacing="0">
                    <tr><th colspan="3" class="box-header">OVERALL REPORTED HAZARDS</th></tr>
                    <tr>
						<td><div class="box" style="background-color:#faaf3b; width:80%;"><small>Hazard</small><br /><strong>'.
						(isset($data['count']['hazard']) ? $data['count']['hazard'] : 0).'</strong></div></td>
						<td><div class="box" style="background-color:#174882; width:80%;"><small>Capacity</small><br /><strong>'.
						(isset($data['count']['capacity']) ? $data['count']['capacity'] : 0).'</strong></div></td>
						<td><div class="box" style="background-color:#CCCCCC; color:#000000; width:80%;"><small>Others</small><br /><strong>'.
						(isset($data['count']['others']) ? $data['count']['others'] : 0).'</strong></div></td>
                    </tr>
                </table>
                <h2 class="border">Hazard</h2>
                <table width="100%" cellpadding="5" border="0">
					<tr style="font-weight:bold"><th style="width:15%"></th><th style="width:65%">Description</th><th class="r" style="width:20%">Quantity</th></tr>
					'.($concatList($data['list'], 'HAZARD')).'
                </table>
                <h2 class="border">Capacity</h2>
                <table width="100%" cellpadding="5" border="0">
                    <tr style="font-weight:bold"><th style="width:15%"></th><th style="width:65%">Description</th><th class="r" style="width:20%">Quantity</th></tr>
                    '.($concatList($data['list'], 'CAPACITY')).'
                </table>
                <h2 class="border">Others</h2>
                <table width="100%" cellpadding="5" border="0">
					<tr style="font-weight:bold"><th style="width:15%"></th><th style="width:65%">Description</th><th class="r" style="width:20%">Quantity</th></tr>
					'.($concatList($data['list'], 'ADDITIONAL')).'
                </table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');  
        
        $pdf->AddPage();

                $html = '
                <style>
                    table.box-table {
                        margin: 10px 0px;
                        border:1px solid #CCCCCC; 
                    }
                    th.box-header {
                        background-color:#CBE5FE;     
                        border-bottom:1px solid #CCCCCC;
                    }
                    div.box {
                        color:#FFFFFF;
                        text-align:right;
                    }
                    h2.border {
                        border-bottom:1px solid #222222;
                    }
                    th.r, td.r {
                        text-align:right;
                    }
                    tr.white-color {
                        color:#FFFFFF;
                        font-weight:bold;
                        text-align:center;
                    }
                </style>
                <table class="box-table" width="100%" cellpadding="5" cellspacing="0">
                    <tr><th colspan="8" class="box-header">REPORTED HAZARDS PER STATUS</th></tr>
                    <tr>
						<td>
							<div class="box" style="background-color:#BD1B30; width:11%">
								<small>Not Yet Started</small><br /><strong>'.(isset($data['Not Yet Started'])?$data['Not Yet Started']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#faaf3b; width:11%">
								<small>Ongoing</small><br /><strong>'.(isset($data['On-going'])?$data['On-going']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#CCCCCC; color:#000000; width:11%">
								<small>Not Priority</small><br /><strong>'.(isset($data['Not Priority'])?$data['Not Priority']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#1DA054; width:11%">
								<small>Completed</small><br /><strong>'.(isset($data['Completed'])?$data['Completed']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#BD1B30; width:11%">
								<small>Unchanged</small><br /><strong>'.(isset($data['Unchanged'])?$data['Unchanged']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#faaf3b; width:11%">
								<small>Upgraded</small><br /><strong>'.(isset($data['Upgraded'])?$data['Upgraded']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#CCCCCC; color:#000000; width:11%">
								<small>Obsolete</small><br /><strong>'.(isset($data['Obsolete'])?$data['Obsolete']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#1DA054; width:11%">
								<small>Replaced</small><br /><strong>'.(isset($data['Replaced'])?$data['Replaced']:'0').'</strong>
							</div>
						</td>
                    </tr>
                </table>
                <br /><br />
                <table class="box-table" width="100%" cellpadding="5" cellspacing="0">
                    <tr><th colspan="4" class="box-header">REPORTED HAZARDS PER TYPE</th></tr>
                    <tr>
						<td>
							<div class="box" style="background-color:#1DA054; width:10%">
								<small>Major</small><br /><strong>'.(isset($data['Major Hazard'])?$data['Major Hazard']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#faaf3b; width:10%">
								<small>Minor</small><br /><strong>'.(isset($data['Minor Hazard'])?$data['Minor Hazard']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#BD1B30; width:10%">
								<small>Sufficient</small><br /><strong>'.(isset($data['Sufficient'])?$data['Sufficient']:'0').'</strong>
							</div>
						</td>
						<td>
							<div class="box" style="background-color:#CCCCCC; color:#000000; width:10%">
								<small>Insufficient</small><br /><strong>'.(isset($data['Insufficient'])?$data['Insufficient']:'0').'</strong>
							</div>
						</td>
                    </tr>
                </table>
                <br /><br /><br />
                <table border="1" width="100%" cellpadding="5" cellspacing="0">
                    <tr class="white-color" style="background-color:#BD1B30"><th rowspan="2">Hazard</th><th colspan="2">Timeframe</th><th rowspan="2">Type</th><th rowspan="2">Status</th></tr>
                    <tr class="white-color" style="background-color:#BD1B30"><th>Start</th><th>Until</th></tr>
                     '.(isset($data['details']) ? $detailList($data['details'], 'HAZARD') : '').'
                </table>
                <br /><br /><br />
                <table border="1" width="100%" cellpadding="5" cellspacing="0">
                    <tr class="white-color" style="background-color:#174882"><th rowspan="2">Capacity</th><th colspan="2">Timeframe</th><th rowspan="2">Type</th><th rowspan="2">Status</th></tr>
                    <tr class="white-color" style="background-color:#174882"><th>Start</th><th>Until</th></tr>
                    '.(isset($data['details']) ? $detailList($data['details'], 'CAPACITY') : '').'
                </table>
                <br /><br /><br />
                <table border="1" width="100%" cellpadding="5" cellspacing="0">
                    <tr class="white-color" style="background-color:#F09667"><th rowspan="2">Other Hazards</th><th colspan="2">Timeframe</th><th rowspan="2">Type</th><th rowspan="2">Status</th></tr>
                    <tr class="white-color" style="background-color:#F09667"><th>Start</th><th>Until</th></tr>
                    '.(isset($data['details']) ? $detailList($data['details'], 'ADDITIONAL') : '').'
                </table>';
        $pdf->writeHTML($html, true, false, true, false, '');        
        
        $pdf->AddPage();

            $html = '
                <style>
                table.box-table {
                    margin: 10px 0px;
                    border:1px solid #CCCCCC; 
                }
                th.box-header {
                    background-color:#CBE5FE;     
                    border-bottom:1px solid #CCCCCC;
                }
                div.box {
                    color:#FFFFFF;
                    text-align:right;
                }
                h2.border {
                    border-bottom:1px solid #222222;
                }
                th.r, td.r {
                    text-align:right;
                }
                tr.white-color {
                    color:#FFFFFF;
                    font-weight:bold;
                    text-align:center;
                }
                </style>
				<h2 class="border">School Head Narrative</h2><br /><br /><br />
				<div style="text-align:justify">
					<div></div>
					'.(isset($data['narrative']->description) ? nl2br($data['narrative']->description) : '<p>No data to show.</p>').'
                </div>
                <div></div>
                <div></div>
                <table class="box-table" width="100%" cellpadding="5" cellspacing="0">
                    <tr><th colspan="2" class="box-header" style="text-align:center">Submitted By:</th></tr>
                    <tr>
                        <td align="center" style="width:60%"><br /><div style="width:90%; border-bottom:1px solid #000000"></div>'.ucfirst($data['user']->name).'</td>
                        <td align="center" style="width:40%"><br /><div style="width:90%; border-bottom:1px solid #000000"></div>Date</td>
                    </tr>
                    <tr><th colspan="2" class="box-header" style="text-align:center">Reviewed By:</th></tr>
                    <tr>
                        <td align="center" style="width:60%"><br /><div style="width:90%; border-bottom:1px solid #000000"></div>'.$data['info']['reviewer'].'</td>
                        <td align="center" style="width:40%"><br /><div style="width:90%; border-bottom:1px solid #000000"></div>Date</td>
                    </tr>
                    <tr><th colspan="2" class="box-header" style="text-align:center">Approved By:</th></tr>
                    <tr>
                        <td align="center" style="width:60%"><br /><div style="width:90%; border-bottom:1px solid #000000"></div>'.$data['info']['approver'].'</td>
                        <td align="center" style="width:40%"><br /><div style="width:90%; border-bottom:1px solid #000000"></div>Date</td>
                    </tr>
                </table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
        
        // reset pointer to the last page
        $pdf->lastPage();
        //Close and output PDF document
        $pdf->Output('DEPED-School-Watching-Activity-Report.pdf', 'I');
	}
}
