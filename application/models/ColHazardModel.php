<?php

class ColHazardModel extends CI_Model {

    private $dbCol;

    public function __construct()
    {
        $this->dbCol = $this->load->database('colServer', TRUE);
    }


    public function getHazardStatusList(){

        $sql = "CALL sp_hazardstatus_getlist()";
        $query = $this->dbCol->query($sql);
        $result = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $result;
    }

    public function getHazardTypeList(){

        $sql = "CALL sp_hazardtype_getlist()";
        $query = $this->dbCol->query($sql);
        $result = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $result;
    }

}