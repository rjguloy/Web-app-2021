<?php

class ComparativeDataModel extends CI_Model {
	
	public function __construct(){
        $this->load->database();
    }

    public function getList(){
        $query = "CALL sp_record_getcomparativedata()";

        $result = $this->db->query($query);
        $list = $result->result();   

        $result->next_result(); 
        $result->free_result(); 

        return $list;
    }
}

?>