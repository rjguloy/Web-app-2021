<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SchoolInfoModel extends CI_Model {
	
	public $out = [];


	public function __construct() {
		$this->load->database();
	}


	public function getInfo() {
		
		$query = $this->db->query('CALL sp_schoolinfo_get()');

		if ( ! $query->num_rows()) return FALSE;

		foreach($query->result_array() as $row) { 
			$this->out['info'] = $row;
		}

        $query->next_result(); 
        $query->free_result(); 
        
		return TRUE;
	}


	public function save($data) {

		$sql 	= 'CALL sp_schoolinfo_save(?, ?, ?, ?, ?, ?, ?)';
		$vals 	= [
				$data['schoolid'], 
				0,
				$data['schoolname'],
				0,
				$data['approver'],
				$data['reviewer'], 
				$_SESSION['username']
			];

		$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) { 
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Failed to save information.';
			return FALSE;
		}
		
        return TRUE;
	}
}
