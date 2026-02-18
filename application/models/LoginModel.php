<?php

class LoginModel extends CI_Model {
	
	public function __construct(){
        $this->load->database();
    }

    /* insert and return access count*/
    public function logAccess($data){
    	$query = "CALL sp_loginaccess_add(?, @failedCount)";

    	$result = $this->db->query($query, $data);
    	//mysqli_next_result($this->db->conn_id);

        return $result->row()->o_count;
	}

    public function deleteAccess($data){
        $query = "CALL sp_loginaccess_delete(?)";

        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }

}

?>