<?php

class UserModel extends CI_Model {
	
	public function __construct(){
        $this->load->database();
    }

    public function add($data){
    	$query = "CALL sp_user_add(?,?,?,?,?)";

    	$this->db->query($query, $data);
    	
    	return ($this->db->affected_rows() < 1) ? false : true;
	}

    public function getByUsername($data){
        $query = "CALL sp_user_getbyusername(?)";

        $result = $this->db->query($query, $data);
        $user = $result->row();  

        $result->next_result(); 
        $result->free_result(); 

        return $user;
    }

    public function getList(){
        $query = "CALL sp_user_getlist()";

        $result = $this->db->query($query);
        $userList = $result->result();   

        return $userList;
    }
       
    public function approve($data){
        $query = "CALL sp_user_approve(?,?)";

        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }

    public function delete($data){
        $query = "CALL sp_user_delete(?,?)";

        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }
}

?>