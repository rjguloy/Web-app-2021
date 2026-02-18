<?php

class ChecklistActivityModel extends CI_Model {


    public function __construct()
    {
        $this->load->database();
    }


    public function getList(){

        $sql = "CALL sp_checklistactivitydate_getList()";
        $query = $this->db->query($sql);
        $result = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $result;
    }

    public function getByDate($activityDate){

        $sql = "CALL sp_checklistactivitydate_getByDate(?)";
        $query = $this->db->query($sql,$activityDate);
        $result = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $result;
    }

    public function getByID($cad_id){

        $sql = "CALL sp_checklistactivitydate_getByID(?)";
        $query = $this->db->query($sql,[$cad_id]);
        $result = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $result;
    }

    public function addActivity($data){

        $query = "CALL sp_checklistactivitydate_add(?,?,?)";

        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }

    public function deleteActivity($cad_id){

        $query = "CALL sp_checklistactivitydate_delete(?, ?)";

        $values = [$cad_id, $this->session->userdata('schoolId')];

        $this->db->query($query, $values);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }

    public function getLast3Dates(){
        $query = "CALL sp_get_checklistactivitydate_getlast3();";

        $result = $this->db->query($query);
        $list = $result->result();   

        $result->next_result(); 
        $result->free_result(); 

        return $list;
    }

}