<?php

class PasswordModel extends CI_Model {
	
	public function __construct(){
        $this->load->database();
    }

    public function update($data){
    	$query = "CALL sp_account_update(?,?)";

    	$this->db->query($query, $data);
    	
    	return ($this->db->affected_rows() < 1) ? false : true;
	}

}

?>