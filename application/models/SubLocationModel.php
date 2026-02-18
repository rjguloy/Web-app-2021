<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubLocationModel extends CI_Model {
	
	public $out = [];

	public function __construct() {
		$this->load->database();
	}


	public function addSubLocation($data) {

		$sql 	= 'CALL sp_sublocation_check(?, ?, ?, ?)';
		$vals 	= [0, $data['locationId'], $_SESSION['schoolId'], $data['sublocationName']];

		$query = $this->db->query($sql, $vals);

		if ($query->num_rows()) {
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Sublocation name already exist.';
			return FALSE;
		}

        $query->next_result(); 
        $query->free_result(); 

		$sql 	= 'call sp_sublocation_add(?, ?, ?, ?, ?, ?)';
		$vals 	= [
				0,
				$_SESSION['schoolId'],
				$data['locationId'], 
				$data['sublocationName'], 
				$_SESSION['username'],
				$data['sublocationType']
			];

		$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows())  { 
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Failed to add record.';
			return FALSE;
		}
		
        return TRUE;
	}


	public function updateSubLocation($data) {

		$sql 	= 'CALL sp_sublocation_check(?, ?, ?, ?)';
		$vals 	= [
				$data['sublocationId'], 
				$data['locationId'], 
				$_SESSION['schoolId'], 
				$data['sublocationName']
			];

		$query = $this->db->query($sql, $vals);

		if ($query->num_rows()) {
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Sublocation name already exist.';
			return FALSE;
		}

        $query->next_result(); 
        $query->free_result(); 

		$sql 	= 'call sp_sublocation_update(?, ?, ?, ?, ?, ?)';
		$vals 	= [
				$data['sublocationId'], 
				$_SESSION['schoolId'],
				$data['locationId'], 
				$data['sublocationName'], 
				$_SESSION['username'],
				$data['sublocationType']
			];

		$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows())  { 
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Failed to update record.';
			return FALSE;
		}
		
        return TRUE;
	}


	public function deleteSubLocation($id) {

		$sql 	= 'call sp_sublocation_delete(?, ?)';
		
		$this->db->query($sql, [$id, $this->session->userdata('username')]);

		if ( ! $this->db->affected_rows())  { 
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Failed to remove record.';
			return FALSE;
		}
		
        return TRUE;
	}

	public function getList($data) {
		$query = "CALL sp_sublocation_getlistbylocation(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();   

    	$result->next_result(); 
        $result->free_result(); 

        return $list;
	}
}
