<?php

class LocationsModel extends CI_Model {
	
	public $out = [];

	public function __construct() {
		
		$this->load->database();
	}

	/* this function will be removed soon. calling fucntions will later use getList() */
	public function getLocations() {

		$query = $this->db->query('CALL sp_locations_get();');

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

	/* same as getLocations(), however optimized */
	public function getList() {
		$sql = "CALL sp_location_getlist()";

        $query = $this->db->query($sql);
        $result = $query->result();   


    	$query->next_result(); 
        $query->free_result(); 


        return $result;
	}


	public function addLocation($data) {

		$sql 	= 'CALL sp_location_check(?, ?, ?)';
		$vals 	= [0, $_SESSION['schoolId'], $data];

		$query = $this->db->query($sql, $vals);

		if ($query->num_rows()) {
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Building name already exist.';
			return FALSE;
		}


        $query->next_result(); 
        $query->free_result(); 

		$sql 	= 'CALL sp_locations_add(?, ?, ?, ?, ?)';
		$vals 	= [
				0, 
				$_SESSION['schoolId'], 
				$data, 
				$_SESSION['username'],
				'ADD'
			];

		$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) { 
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Failed to add record.';
			return FALSE;
		}
		
		$query->next_result(); 
        $query->free_result(); 
        
        return true;
	}


	public function updateLocation($data) {

		$sql 	= 'CALL sp_location_check(?, ?, ?)';
		$vals 	= [$data['locationId'], $_SESSION['schoolId'], $data['locationName']];

		$query = $this->db->query($sql, $vals);

		if ($query->num_rows()) {
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Building name already exist.';
			return FALSE;
		}

        $query->next_result(); 
        $query->free_result(); 

		$sql 	= 'CALL sp_locations_update(?, ?, ?, ?)';
		$vals 	= [
				$data['locationId'], 
				$_SESSION['schoolId'], 
				$data['locationName'],
				$_SESSION['username']
			];

		$this->db->query($sql, $vals);

		if ( ! $this->db->affected_rows()) { 
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Failed to update record.';
			return FALSE;
		}

        return TRUE;
	}


	public function deleteLocation($id) {

		$sql 	= 'CALL sp_locations_delete(?, ?)';
		
		$this->db->query($sql, [$id, $this->session->userdata('username')]);

		if ( ! $this->db->affected_rows()) { 
			$this->out['error'] = 1;
			$this->out['msg'] 	= 'Failed to remove record.';
			return FALSE;
		}

		$sql 	= 'CALL sp_sublocation_getlistbylocation(?)';
		
		$query = $this->db->query($sql, [$id]);

		if ( ! $query->num_rows()) {
			return TRUE;
		}
		
		$result = $query->result_array();

		$query->next_result(); 
		$query->free_result(); 
		
		foreach ($result as $row) {
			$sql 	= 'CALL sp_sublocation_delete(?, ?)';
		
			$this->db->query($sql, [$row['id'], $this->session->userdata('username')]);

			if ( ! $this->db->affected_rows()) { 
				$this->out['error'] = 1;
				$this->out['msg'] 	= 'Failed to remove record.';
				return FALSE;
			}
		}
    	
        return TRUE;
	}

}