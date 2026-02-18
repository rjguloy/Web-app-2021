<?php

class Reports extends CI_Model {
	
	public function __construct(){
        $this->load->database();
    }

    public function getNarrative($data){
        $query = "CALL sp_narrative_getbychecklistdateid(?)";

        $result = $this->db->query($query, [$data]);
        $narrative = $result->row();

        return $narrative;
    }

    public function saveNarrative($data){
        $query = "CALL sp_narrative_update(?,?,?,?)";

        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }

    public function getChecklistActivityList($data){
        $query = "CALL sp_record_getchecklistactivity(?,?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        return $list;
    }

    public function validateRecord($data){
        $query = "CALL sp_record_validate(?,?,?,?)";

        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }

    public function getSendToServerHazard($data){
        $query = "CALL sp_record_getsendtoserver_hazard(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        return $list;
    }


    public function getListByDateID($data) {
        $query = "CALL sp_summary_forpdf(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        $result->next_result(); 
        $result->free_result(); 
// var_dump($list); die();
        return $list;
    }

    public function getSendToServerPhoto($data){
        $query = "CALL sp_record_getsendtoserver_photo(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        return $list;
    }

    public function getSendToServerData($data){
        // 1. select CAD
        $query = "CALL sp_checklistactivitydate_getsendtoserver(?)";

        $result = $this->db->query($query, $data);
        $cad = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 2. select location
        $query = "CALL sp_location_getsendtoserver()";

        $result = $this->db->query($query);
        $locationList = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 3. select sublocation
        $query = "CALL sp_sublocation_getsendtoserver()";

        $result = $this->db->query($query);
        $sublocationList = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 4. select VALIDATED - ADDITIONAL hazards
        $query = "CALL sp_hazard_getsendtoserver(?)";

        $result = $this->db->query($query, $data);
        $additionalHazardList = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 5. select VALIDATED records
        $query = "CALL sp_record_getsendtoserver(?)";

        $result = $this->db->query($query, $data);
        $recordList = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 6. select recordphoto
        $query = "CALL sp_recordphoto_getsendtoserver(?)";

        $result = $this->db->query($query, $data);
        $recordPhotoList = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 7. select recordaction
        $query = "CALL sp_recordaction_getsendtoserver(?)";

        $result = $this->db->query($query, $data);
        $recordActionList = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 8. select narrative
        $query = "CALL sp_narrative_getsendtoserver(?)";

        $result = $this->db->query($query, $data);
        $narrative = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        // 9. select summary
        $query = "CALL sp_summary_getsendtoserver(?)";

        $result = $this->db->query($query, $data);
        $summaryList = $result->result();

        $result->next_result(); 
        $result->free_result(); 
        
        $list = array(
                'cad' => $cad,
                'location' => $locationList,
                'sublocation' => $sublocationList,
                'additionalHazard' => $additionalHazardList,
                'record' => $recordList,
                'recordphoto' => $recordPhotoList,
                'recordaction' => $recordActionList,
                'narrative' => $narrative,
                'summary' => $summaryList
                );

        return $list;
    }

    

    public function deleteSynchedData($data){
        $query = "CALL sp_data_delete_aftersendtoserver(?)";

        $this->db->query($query, $data);
        
        return ($this->db->affected_rows() < 1) ? false : true;
    }


    public function getHazardsCount($data){
        
        $query = "CALL sp_pdf_hazardtype_count_get(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        return $list;
    }


    public function getHazardStatusCount($data) {

        $query = "CALL sp_pdf_gethazardstatus_count(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        return $list;
    }


    public function getHazardTypeCount($data) {

        $query = "CALL sp_pdf_gethazardtype_count(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        return $list;
    }


    public function getSummaryList($data) {

        $query = "CALL sp_summary_records_bydate_get(?)";

        $result = $this->db->query($query, $data);
        $list = $result->result();

        $result->next_result(); 
        $result->free_result(); 

        return $list;
    }
}

?>