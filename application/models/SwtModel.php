<?php

class SwtModel extends CI_Model {
	
	public $out = [];


	public function __construct() {
		
		$this->load->database();
		$CI =& get_instance();
        $CI->load->model('LocationsModel', 'loc');
	}


	public function __destruct() {
		$this->db->close();
	}


	public function getSwtMembers() {

		$sql 	= 'CALL sp_swt_members_get();';

		$query 	= $this->db->query($sql);

		if ( ! $query->num_rows()) {
			$query->next_result(); 
	        $query->free_result();
			return FALSE;
		}

		$result = $query->result_array();

        $query->next_result(); 
        $query->free_result();

        return $result;
	}


	public function getSwtPermissions() {

		$sql = 'CALL sp_swt_permissions_get();';
		
		$query = $this->db->query($sql);

		if ( ! $query->num_rows()) {
			$query->next_result(); 
	        $query->free_result();
			return FALSE;
		}

		$result = $query->result_array();

		$query->next_result(); 
        $query->free_result();

		return $result;
	}


	public function duplicateMemberCheck($data) {

		$sql 	= 'CALL sp_swt_member_check(?, ?)';
		$vals 	= [$data['memID'], $data['memName']];
		$query = $this->db->query($sql, $vals);

		if ($query->num_rows()) { 
			$query->next_result(); 
			$query->free_result();
			return TRUE;
		}
		
		$query->next_result(); 
		$query->free_result(); 
		
        return FALSE;
	}


	public function saveMember($team, $data) {
		
		$sql 	= 'CALL sp_swt_member_add(?, ?, ?, ?)';
		$vals 	= [
				$team, 
				$data['memName'], 
				$data['memSex'], 
				$this->session->userdata('username')
			];

		$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) return FALSE;
		
		$query = $this->db
				->select('id')
				->from('swt')
				->where('team', $team)
				->where('name', $data['memName'])
				->where('gender', $data['memSex'])
				->where('createstatus', 'ACTIVE')
				->get();
		
		$out = $query->row();
		
		return $out->id;
	}


	public function removeMember($data) {

       	$sql 	= 'CALL sp_swt_members_delete(?, ?, ?, ?, ?)';	
    	$vals 	= [
    			$data['memID'],
    			$data['memTeam'],
    			$data['memName'],
    			$data['memSex'],
    			$this->session->userdata('username')
    		];
    	
    	$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) return FALSE;
        
        return TRUE;
	}


	public function removeSublocPermissionsCheck($ids) {


		
		$sql 	= 'CALL sp_swt_permissions_subloc_check(?)';
		$vals 	= [$ids];

		$query = $this->db->query($sql, $vals);

		if ( ! $query->num_rows()) {
			$query->next_result(); 
        	$query->free_result(); 
			return FALSE;
		}

		$result = $query->result_array();

        $query->next_result(); 
        $query->free_result(); 
		
		return $result;
	}


	public function removePermissions($row) {

    	$sql 	= 'CALL sp_swt_permissions_delete(?, ?, ?, ?)';	
    	$vals 	= [
    			$row['id'],
    			$row['team'],
    			$row['sublocation_id'],
    			$this->session->userdata('username')
    		];
    	
    	$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) return FALSE;

		return TRUE;
	}


	public function idExists($subLoc) {

		$sql 	= 'CALL sp_swt_permissions_id_check(?)';
		$vals 	= [$subLoc];

		$query = $this->db->query($sql, $vals);

		if ( ! $query->num_rows()) {
			$query->next_result(); 
        	$query->free_result(); 
			return FALSE;
		}

		$out = $query->row_array();

        $query->next_result(); 
        $query->free_result(); 
	    
		return $out['id'];
	}


	public function updatePermissions($team, $subLoc) {

		
		$sql 	= 'CALL sp_swt_permissions_update(?, ?)';
		$vals 	= [$team, $subLoc];

		$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) return TRUE;

		return FALSE;
	}


	public function addPermissions($id, $team, $subLoc) {
		
		if ($id === null) $id = 0;
		
		$sql 	= 'CALL sp_swt_permissions_add(?, ?, ?, ?)';	
    	$vals 	= [
				$id,
    			$team,
    			$subLoc,
    			$this->session->userdata('username')
    		];
			
    	$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) return FALSE;

		return TRUE;
	}
}