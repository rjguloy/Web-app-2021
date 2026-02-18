<?php

class HazardCategoryModel extends CI_Model {
	
	public $out = [];


	public function __construct() {
        
        $this->load->database();
    }


    public function getHazardCategories() {

		$sql 	= 'CALL sp_hazardcat_get();';

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
}
