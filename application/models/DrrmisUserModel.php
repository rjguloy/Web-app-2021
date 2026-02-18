<?php

class DrrmisUserModel extends CI_Model {

    public $dbDrrmis    = NULL;

    public function __construct()
    {
        $this->dbDrrmis = $this->load->database('drrmis', TRUE);
    }


    public function getValidUser($email) {

        $query = $this->dbDrrmis->from('users')->where('email', $email)->where('is_approved', 1)->get();

        if ( ! $query->num_rows()) {
            return false;
        }
        
        $result = $query->row_array();

        $query->free_result(); 
        
        return $result;
    }
}
