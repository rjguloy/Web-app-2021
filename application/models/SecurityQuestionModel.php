<?php

class SecurityQuestionModel extends CI_Model {
	
	public function __construct(){
        $this->load->database();
    }

    public function getList(){
        $query = "CALL sp_securityquestion_getlistrandom()";

        $result = $this->db->query($query);
        $list = $result->result();   

        return $list;
    }

    public function getListByUsername($data){
        $query = "CALL sp_securityquestion_getlistbyusername(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();   

        return $list;
    }

    public function validateAnswer($data){
        $query = "CALL sp_securityquestion_validateanswer(?,?,?)";

        $result = $this->db->query($query, $data);
        $row = $result->row();

        $result->next_result(); 
        $result->free_result();  

        return $row;
    }

}

?>