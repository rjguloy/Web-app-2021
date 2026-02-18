<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/CreatorJwt.php';

class Login extends CI_Controller {

	
	function __construct() {
        parent::__construct();
        $this->load->model('UserModel', 'usermodel') ;
        $this->load->model('LoginModel', 'loginModel') ;
		$this->load->model('SchoolInfoModel', 'schoolInfoModel') ;
        $this->load->library('encryption') ;
		$this->load->helper('url') ;

		$this->objOfJwt = new CreatorJwt();
    }

	public function index()
	{
		$sessionUnset = array('username', 'name');

		if ($this->session->username) redirect('home');
		
		if ($this->getTokenData()) return true;
		
		if (IS_SSO && ! $this->session->username) redirect(LOGOUT_URL);

		$this->load->view('login');
	}


	public function getTokenData()
    {
		
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
				
				if (isset($jwtData['customClaims']->email) && isset($jwtData['customClaims']->roleName)) {
					$this->load->model('DrrmisUserModel', 'drrmis');

					// fetch the user's role, region id, division id, and school id
					if ( ! $record = $this->drrmis->getValidUser($jwtData['customClaims']->email)) {
						return false;
					}

					$schoolID 	= null;
					$divisionID = null;
					$regionID 	= null;

					// $temp = 'super_admin';
					switch ($jwtData['customClaims']->roleName) {
						// switch ($temp) {
						case 'school.manage' 	: 
							$role 		= 'SCHOOLCOORD'; 	
							$buffer 	= json_decode($record['meta_data']);
							$schoolID 	= $buffer->school_id;
							$divisionID = $buffer->school_division_id;
							$regionID 	= $buffer->region_id;
							break;
						case 'division.manage' 	: 
							$role = 'DIVISIONCOORD';
							$buffer 	= json_decode($record['meta_data']);
							$divisionID = $buffer->division_id;
							$regionID 	= $buffer->region_id;
							break;
						case 'region.manage' 	: 
							$role = 'REGIONCOORD';
							$buffer 	= json_decode($record['meta_data']);
							$regionID 	= $buffer->region_id;
							break;
						case 'super_admin' 		: 
						case 'central.manage'	:
							$role = 'SUPERADMIN';		
							break;
					}

					$session = [
						'username' 		=> $record['email'],
						'fname'			=> $record['first_name'],
						'lname' 		=> $record['last_name'],
						'role'			=> $role,
						'regionID'		=> $regionID,
						'divisionID'	=> $divisionID,
						'schoolID'		=> $schoolID
					];
					
					$this->session->set_userdata($session);
					header('Location: home');
					
				} else {
					$this->output->set_status_header('404');	
				}
			} catch (Exception $e) {
				$this->output->set_status_header('404');
				// http_response_code('401');
				// echo json_encode(array( "status" => false, "message" => $e->getMessage()));
				exit;
			}
		}
	}


	public function validate(){
		$username = $this->input->post("uname");
		$password = $this->input->post("pword");
		$user = array($username);

		$user = $this->usermodel->getByUsername($user);

		if(is_null($user->username)){ // user invalid
			$message = "Username and/or password invalid.";
		}elseif($user->failedcount >= 3 && $user->lastloginduration < 900){ // 15 minutes or 900 seconds lockout
			$message = "Your account is locked. Please try again later.";
		}elseif (strcmp($password, $this->encryption->decrypt($user->password))) {
			$message = "Username and/or password invalid.";

			if(!is_null($user->validationdate)){ // will only log failed access if user is validated
				if($user->failedcount >= 3 && $user->lastloginduration > 900){ // if lockout done, remove all logs
					$this->loginModel->deleteAccess(array($user->username));
				}

				$failedCount = $this->loginModel->logAccess(array($user->username));
				
				if($failedCount >= 3){
					$message = "Your account is locked. Please try again later.";
				}
			}
		}elseif (is_null($user->validationdate)) { // user not yet validated
			$message = "User not yet validated.";
		}else{ //successful login
			$this->loginModel->deleteAccess(array($user->username));
			
			$session = array('passwordduration' => $user->passwordduration);
			if($user->passwordduration < 90){ // only store user session if password is not expired
				$session['username'] = $user->username;
				
				$schoolInfo = $this->schoolInfoModel->getInfo();
				$session['schoolId'] = $this->schoolInfoModel->out['info']['id'];
			}
			
			$session['role'] = 'SCHOOL';

			$this->session->set_userdata($session);
			
			$message = json_encode($user->passwordduration);
		}

		echo $message;
	}

	public function logout(){
		$sessionUnset = array('username', 'name');

		$this->session->unset_userdata($sessionUnset);
		$this->session->sess_destroy();

		if (IS_SSO) redirect(LOGOUT_URL);
		
		redirect(base_url());
        exit;
	}
}