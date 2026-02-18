<?php

class ReportPhotoModel extends CI_Model {


	public function __construct()
    {
        $this->load->database();
    }

	public function getListByDate($data)
    {

		$sql = "CALL sp_reportphoto_bydate(?)";
        $query = $this->db->query($sql, $data);
        $result = $query->result();

    	$query->next_result(); 
        $query->free_result(); 
        
        return $result;
    }


    public function hasActionRecord($data) {

        $sql    = 'CALL sp_reportphoto_action_check(?)';
        $query = $this->db->query($sql, [$data]);

        if ($query->num_rows()) { 
            $query->next_result(); 
            $query->free_result();
            return TRUE;
        }

        $query->next_result(); 
        $query->free_result(); 

        return FALSE;
    }


    public function updateAction($data) {

        $sql    = 'CALL sp_reportphoto_action_update(?, ?, ?, ?, ?, ?)';
        $vals   = [
                $data['actionId'],
                $this->session->userdata('schoolId'),
                $data['recordId'],
                $data['hazardDesc'],
                $data['hazardAction'],
                $this->session->userdata('username')
            ];

        $this->db->query($sql, $vals);

        if ( ! $this->db->affected_rows()) return FALSE;
        
        return TRUE;
    }


    public function saveAction($data) {

        $sql    = 'CALL sp_reportphoto_action_add(?, ?, ?, ?, ?, ?)';
        $vals   = [
                $data['actionId'],
                $this->session->userdata('schoolId'),
                $data['recordId'],
                $data['hazardDesc'],
                $data['hazardAction'],
                $this->session->userdata('username')
            ];

        $this->db->query($sql, $vals);

        if ( ! $this->db->affected_rows()) return FALSE;
        
        return TRUE;
    }


    public function getDetailsToDelete($data) {

        $sql = "CALL sp_reportphoto_byrecord(?)";
        $query = $this->db->query($sql, [$data]);
        $result = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $result;
    }


    public function deleteImages($id, $rec) {

        $sql    = 'CALL sp_reportphoto_images_delete(?, ?, ?, ?)';
        $vals   = [
                $id,
                $this->session->userdata('schoolId'),
                $rec,
                $this->session->userdata('username')
            ];
            
        $this->db->query($sql, $vals);

        if ( ! $this->db->affected_rows()) return FALSE;
        
        return TRUE;
    }
}
