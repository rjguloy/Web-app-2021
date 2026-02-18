<?php

class ChecklistModel extends CI_Model {


	public function __construct()
    {
        $this->load->database();
    }

	public function getListByType($data)
    {

		$sql = "CALL sp_checklist_ByType(?)";
        $query = $this->db->query($sql,$data);
        $res = $query->result();

    	$query->next_result(); 
        $query->free_result(); 
        
        return $res;


 
    }


}