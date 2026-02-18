<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QRGenerator extends CI_Controller {

	
	private $token = "com.adec_innovations_swapp";

	private $data = [];

	public function __construct()
    {
		header('Access-Control-Allow-Origin: *');
    	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('SQLiteModel', 'sqliteModel') ;
		$this->load->library('session');
		if (!file_exists(FCPATH."uploads/qr_image/")) {
			mkdir(FCPATH."uploads/qr_image/", 0777, true);
		}
		if (!file_exists(FCPATH."uploads/db/")) {
			mkdir(FCPATH."uploads/db/", 0777, true);
		}

		$this->session->unset_userdata('caDateId');
		$this->session->unset_userdata('locationId');
		$this->session->unset_userdata('sublocationId');
		$this->session->unset_userdata('sumDateId');
		$this->session->unset_userdata('photoDateId');
	}

	public function createDownloadLink ()
	{
		$files = glob(FCPATH."uploads/qr_image/*"); // get all file names
		foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
		}
		$group_name = $this->input->post('group');
		$this->buildDB($group_name);
		
		if (!$this->sqliteModel->isDBValid()){
			$this->output->set_status_header(500)->set_content_type('application/text')->set_output("No data or invalid data to be send to mobile.");
			return;
		}
		$this->load->library('ciqrcode');
		$qr_image=rand().'.png';
		$params['data'] = site_url() . 'qRGenerator/downloadDB?appid=com.adec_innovations_swapp&action=download';
		$params['level'] = 'H';
		$params['size'] = 8;
		$params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
		if($this->ciqrcode->generate($params))
		{
			$data['img_url']= base_url('uploads/qr_image/'.$qr_image)  ;	
		}
		
		echo $data['img_url'];

	}

	public function createUploadLink(){
		$files = glob(FCPATH."uploads/qr_image/*"); // get all file names
		foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
		}
		
		$this->load->library('ciqrcode');
		$qr_image=rand().'.png';
		$params['data'] = site_url() . 'qRGenerator/uploadDB?appid=com.adec_innovations_swapp&action=upload';
		$params['level'] = 'H';
		$params['size'] = 8;
		$params['savename'] =FCPATH."uploads/qr_image/".$qr_image;
		if($this->ciqrcode->generate($params))
		{
			$data['img_url']= base_url('uploads/qr_image/'.$qr_image)  ;	
		}
		
		echo $data['img_url'];
	}

	private function buildDB($team){
		$this->sqliteModel->buildSWT($team);
	}

	public function downloadDB(){


		if ($this->getBearerToken() != $this->token){
			$response['response'] = "Unauthorize access";
			$this->output->set_status_header(403)->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}

		$this->load->helper('download');
		$data = file_get_contents(APPPATH . 'db/SWApp.db'); // Read the file's contents
		$name = 'SWApp.db';
		force_download($name, $data);
		$this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function uploadDB(){
		
		$cad_id = $this->input->get('cad');
		if (!($this->sqliteModel->isCADExisting($cad_id))){
			$response['response'] = "Checklist date not found on server.";
			$this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}

	
		$files = glob(FCPATH."uploads/db/*"); 
		foreach($files as $file){ // iterate files
			if(is_file($file))
				unlink($file); // delete file
		}
		
		if ($this->getBearerToken() != $this->token){

			$response['response'] = "Unauthorize access";
			$this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}

		$config['upload_path'] = './uploads/db/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload('swapp'))
		{
				$error = array('error' => $this->upload->display_errors());
				$response['response'] = $this->upload->display_errors();
				$this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode($response));
				return;
		}
		else
		{
				$data = array('upload_data' => $this->upload->data());
				$response['response'] = "DB Uploaded successfully.";
				$this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response));
				$this->sqliteModel->syncData($cad_id);
				return;
		}
	}

	private function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
	}
	
	private function getBearerToken() {
		$headers = $this->getAuthorizationHeader();
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

	
}