<?php

class SummaryModel extends CI_Model {


    public function __construct()
    {
        $this->load->database();
    }

    public function getListByDateID($data)
    {
        $sql      = "CALL sp_summary_records_bydate_get(?)";
        $query    = $this->db->query($sql, $data);
        $buffer   = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $buffer;
    }


    public function getHazardType() {

        // HAZARD = ['1,2'] 
        // CAPACITY = ['3,4,5']

        $sql      = "CALL sp_summary_hazardtype_get()";
        $query    = $this->db->query($sql);

        $buffer   = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $buffer;
    }


    public function getHazardStatus() {

        // HAZARD = ['1,2,3,4']
        // CAPACITY = ['5,6,7,8'];
         
        $sql      = "CALL sp_summary_hazardstatus_get()";
        $query    = $this->db->query($sql);

        $buffer   = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $buffer;
    }


    public function saveSummary($data) {

        $query = "CALL sp_summary_add(?,?,?,?,?,?,?,?)";
        
        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }
}