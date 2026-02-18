<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . '/libraries/CreatorJwt.php');

class SwappApi extends CI_Controller {

	public function __construct()
{
        parent::__construct();

        $this->load->helper('url');
        
        $this->load->model('ColReportsModel', 'colReportsModel');

        $this->objOfJwt = new CreatorJwt();
    }


    public function insertDataFromLocal() {
        
        $received_Token = $this->input->request_headers('Authorization');
        
    	if (isset($received_Token['Authorization']) || isset($_GET['token'])) {
			header('Content-Type: application/json');
			if (isset($_GET['token'])) {
				$token = $_GET['token'];
			} else {
				$buffer = explode(' ', $received_Token['Authorization']);
				$token = $buffer[1];
			}
			
			try
			{
				$jwtData = $this->objOfJwt->DecodeToken($token);
                                
				if (isset($jwtData['schoolID']) && isset($jwtData['username'])) {
					
                    if ( ! $this->colReportsModel->validSchoolID($jwtData['schoolID'])) {
                        echo 0;
                        return;
                    }
                    
                    
                    $data = json_decode(file_get_contents('php://input'), true);
                    
                    $count = 0;
                    foreach ($data['recordphoto'] as $row) {
                        $data['recordphoto'][$count]['image'] = base64_decode(urldecode($row['image']));
                        $count++;
                    }
                   
                    echo $this->colReportsModel->createDataFromLocal($data);
					
				} else {
					$this->output->set_status_header('404');	
				}
			} catch (Exception $e) {
                echo 0;
				return;
			} catch (Error $err) {
                error_log('Send to Server - API Call Failed: ' . $err->getMessage());
                echo 0;
            }
		}
    }
}