<?php

class ColReportsModel extends CI_Model {

    public $dbCol   = NULL;
    public $dbEbeis = NULL;
    public $out     = NULL;


    public function __construct()
    {
        $this->dbCol = $this->load->database('colServer', TRUE);
        $this->dbEbeis = $this->load->database('ebeis', TRUE);
    }


    private function _getSchoolsSubmitted() {

        $sql      = "CALL sp_reports_dropdown_get()";
        $query    = $this->dbCol->query($sql);
        $result   = $query->result();

        $query->next_result(); 
        $query->free_result(); 

        return $result;
    }


    private function _matchAndArrangeFromSchools($buffer1, $buffer2) {

        $count = 0;
        $buffer = [];
        foreach ($buffer1 as $beis) {
            // if ( ! $beis->school_id) continue;
            // foreach ($buffer2 as $col) {
                // if ($beis->school_id != $col->school_id) continue;
                if ($count) {
                    if ($beis->loc_id == $buffer[$count-1]['id']) continue;
                }
                $buffer[$count]['id']   = $beis->loc_id;
                $buffer[$count]['name'] = $beis->loc_name;
                $count++;
            // }
        }
        
        return $buffer;
    }


    public function getYearList() {
        $sql = "CALL sp_reports_yearlist_get()";
        $query = $this->dbCol->query($sql);
        $res = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $res;
    }


    public function getItemList() {

        $sql = "CALL sp_reports_itemlist_get()";
        $query = $this->dbCol->query($sql);
        $res = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $res;
    }


    public function getRegions() {

        $sql      = 'SELECT 
                        a.id AS loc_id, 
                        a.region_short_name AS loc_name,
                        b.id AS division_id,
                        c.school_id
                    FROM region AS a 
                    LEFT JOIN division AS b
                    ON b.region_id = a.id
                    LEFT JOIN school AS c
                    ON c.division_id = b.id
                    ORDER BY loc_id';

        $query    = $this->dbEbeis->query($sql);
        $buffer1   = $query->result();

        $query->free_result(); 

        $buffer2 = $this->_getSchoolsSubmitted();
        
        return $this->_matchAndArrangeFromSchools($buffer1, $buffer2);
    }


    public function getDivisions($data) {

        $sql      = 'SELECT 
                        a.id AS loc_id, 
                        a.division_name AS loc_name,
                        b.school_id
                    FROM division AS a
                    LEFT JOIN school AS b
                    ON b.division_id = a.id
                    WHERE a.region_id = ?
                    ORDER BY loc_id';

        $query    = $this->dbEbeis->query($sql, $data);
        $buffer1   = $query->result();

        $query->free_result(); 

        $buffer2 = $this->_getSchoolsSubmitted();
        
        return $this->_matchAndArrangeFromSchools($buffer1, $buffer2);
    }


    public function getDivision($division) {
        
        $sql      = 'SELECT 
                        a.id AS id, 
                        a.division_name AS name
                    FROM division AS a
                    WHERE a.id = ?';

        $query    = $this->dbEbeis->query($sql, $division);
        $buffer   = $query->result_array();

        $query->free_result(); 
        
        return $buffer;
    }


    public function getSchools($data) {

        $sql      = 'SELECT 
                        school_id AS loc_id, 
                        school_name AS loc_name,
                        school_id
                    FROM school 
                    WHERE division_id = ?
                    ORDER BY loc_id';

        $query    = $this->dbEbeis->query($sql, $data);
        $buffer1   = $query->result();

        $query->free_result(); 

        $buffer2 = $this->_getSchoolsSubmitted();
        
        return $this->_matchAndArrangeFromSchools($buffer1, $buffer2);
    }


    public function getSchool($school) {

        $sql      = 'SELECT 
                        school_id AS id, 
                        school_name AS `name`,
                        school_id
                    FROM school 
                    WHERE school_id = ?';

        $query    = $this->dbEbeis->query($sql, $school);
        $buffer   = $query->result_array();

        $query->free_result(); 
        
        return $buffer;
    }


    public function getDates($data) {

        $sql      = "CALL sp_reports_dates_get(?)";
        $query    = $this->dbCol->query($sql, $data);
        $buffer   = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        return $buffer;
    }


    public function getReportList($data)
    {
        $sql_head   = 'SELECT a.id AS region_id, a.region_name, 
                    b.id AS division_id, b.division_name, 
                    c.school_id, c.school_name 
                    FROM region AS a 
                    LEFT JOIN division AS b 
                    ON b.region_id = a.id 
                    LEFT JOIN school AS c 
                    ON c.division_id = b.id 
                    WHERE school_id IS NOT NULL '; 
                    
        $sql_tail   = ' ORDER BY region_id, division_id, school_id';

        $sql_where = ' ';

        if ($data['region_id'])     $sql_where .= ' AND region_id = ' . $data['region_id'];
        if ($data['division_id'])   $sql_where .= ' AND division_id = ' . $data['division_id'];
        if ($data['school_id'])     $sql_where .= ' AND school_id = ' . $data['school_id'];

        $sql = $sql_head . $sql_where . $sql_tail;

        $query    = $this->dbEbeis->query($sql, $data['region_id']);
        $buffer1   = $query->result();

        $query->free_result();

        $param    = [$data['year_id'], $data['item_id'], $data['school_id'], $data['date_id']];

        $sql      = "CALL sp_reports_get(?, ?, ?, ?)";
        $query    = $this->dbCol->query($sql,$param);
        $buffer2   = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        $count = 0;
        $buffer = [];
        foreach ($buffer2 as $col) {
            foreach ($buffer1 as $beis) {
                if ($col->school_id != $beis->school_id) continue;
                $buffer[$count]['region_name']          = $beis->region_name;
                $buffer[$count]['division_name']        = $beis->division_name;
                $buffer[$count]['school_name']          = $beis->school_name;
                $buffer[$count]['date']                 = $col->date;
                $buffer[$count]['item']                 = $col->item;
                $buffer[$count]['item_count']           = $col->item_count;
                $buffer[$count]['type']                 = $col->type;
                $buffer[$count]['timeline']             = $col->timeline;
                $buffer[$count]['hazardstatus_name']    = $col->hazardstatus_name;
                $buffer[$count]['hazardtype_name']      = $col->hazardtype_name;
                $buffer[$count]['hazardstatus_name']    = $col->hazardstatus_name;
                $count++;
            }
        }
        //var_dump($buffer); die();
        return $buffer;
    }
   

    public function getSubmissionStats($data) {

        if ($this->session->role == 'SUPERADMIN' && ! $data['region_id']) {
            
            return $this->_submissionSuper($data);
        }

        if (($this->session->role == 'REGIONCOORD' && ! $data['division_id']) 
        || ($this->session->role == 'SUPERADMIN' && $data['region_id'] && ! $data['division_id'])) {
            
            $regionID = $this->session->role == 'REGIONCOORD' ? $this->session->regionID : $data['region_id'];
            return $this->_submissionRegion($data, $regionID);
        }
        
        if (($this->session->role == 'DIVISIONCOORD' && ! $data['school_id']) 
        || (($this->session->role == 'SUPERADMIN' || $this->session->role == 'REGIONCOORD') && $data['division_id']
        && ! $data['school_id']))  {
            
            $divisionID = $this->session->role == 'DIVISIONCOORD' ? $this->session->divisionID : $data['division_id'];
            return $this->_submissionDivision($data, $divisionID);
        }

        if ($this->session->role == 'SCHOOLCOORD' 
        || (($this->session->role == 'SUPERADMIN' || $this->session->role == 'REGIONCOORD'
        || $this->session->role == 'DIVISIONCOORD') && $data['school_id']))  {
            
            // $schoolID = $this->session->role == 'SCHOOLCOORD' ? $this->session->schoolID : $data['school_id'];
            // return $this->_submissionSchool($data, $schoolID);
            $divisionID = $this->session->role == 'SCHOOLCOORD' || $this->session->role == 'DIVISIONCOORD' ? $this->session->divisionID : $data['division_id'];
            return $this->_submissionDivision($data, $divisionID);
            
        }
    }


    private function _submissionSuper($data) {

        $sql   = 'SELECT a.id AS loc_id, a.region_short_name AS loc_name,
                    e.division_id, e.school_id, e.school_name
                    FROM region AS a 
                    LEFT JOIN (
                        SELECT b.id, 
                        c.id AS division_id,  
                        d.school_id, d.school_name 
                        FROM region AS b
                        LEFT JOIN division AS c 
                        ON c.region_id = b.id 
                        LEFT JOIN school AS d 
                        ON d.division_id = c.id 
                    ) AS e
                    ON e.id = a.id
                    ORDER BY loc_id, division_id, school_id'; 
                        
            $query    = $this->dbEbeis->query($sql);
            $buffer1   = $query->result();

            $query->free_result();

            $buffer = $this->_getFromSwappCOL($buffer1, $data);

            $buffer['scope'] = 'super';

            return $buffer;
    }


    private function _submissionRegion($data, $regionID) {

        $sql   = 'SELECT a.id AS loc_id, a.division_name AS loc_name,
                    b.school_id, c.id AS scope_id, 
                    c.region_short_name AS scope_name
                    FROM division AS a 
                    LEFT JOIN school AS b 
                    ON b.division_id = a.id 
                    LEFT JOIN region AS c 
                    ON c.id = a.region_id 
                    
                    WHERE c.id = ?
                    ORDER BY loc_id, school_id'; 
                        
            $query      = $this->dbEbeis->query($sql, $regionID);
            $buffer1    = $query->result();

            $query->free_result();

            $buffer = $this->_getFromSwappCOL($buffer1, $data);

            $buffer['scope'] = 'region';
            return $buffer;
    }


    private function _submissionDivision($data, $divisionID) {

        $sql   = 'SELECT a.id AS loc_id, a.division_name AS loc_name,
                    b.school_id, c.id AS scope_id, 
                    c.region_short_name AS scope_name
                    FROM division AS a 
                    LEFT JOIN school AS b 
                    ON b.division_id = a.id 
                    LEFT JOIN region AS c 
                    ON c.id = a.region_id 
                    WHERE a.id = ?
                    ORDER BY loc_id'; 
                        
            $query      = $this->dbEbeis->query($sql, $divisionID);
            $buffer1    = $query->result();

            $query->free_result();

            $buffer = $this->_getFromSwappCOL($buffer1, $data);

            $buffer['scope'] = 'division';
            return $buffer;
    }


    // private function _submissionSchool($data, $schoolID) {

    //     $sql   = 'SELECT a.id,
    //                 a.school_name,
    //                 a.school_id
    //                 FROM school AS a
    //                 WHERE a.school_id = ?'; 
                        
    //     $query      = $this->dbEbeis->query($sql, $schoolID);
    //     $buffer1    = $query->result();

    //     $query->free_result();

    //     $buffer = [$data['year_id'], $schoolID, $data['date_id']];
    // 	$sql 	= "CALL sp_dashboard_school_submission_get(?, ?, ?)";
        
    //     $query 	= $this->dbCol->query($sql, $buffer);
    //     $buffer2 = $query->result();

    //     $query->next_result(); 
    //     $query->free_result(); 
        
    //     $buffer = [];
    //     foreach ($buffer1 as $beis) {
    //         $buffer['scope_id']     = $beis->school_id;
    //         $buffer['scope_name']   = $beis->school_name;
    //         foreach ($buffer2 as $col) {
    //             $buffer['loc_id'][]               = $col->loc_id;
    //             $buffer['loc_name'][]             = $col->loc_name;
    //             $buffer['school_submitted'][]     = 1;
    //             $buffer['school_not_submitted'][] = 0;
    //             $buffer['total_schools'][]        = 1;
    //         }
    //     }

    //     $buffer['scope'] = 'school';
    //     return $buffer;
    // }


    private function _getFromSwappCOL($buffer1, $data) {

        $buffer = [$data['year_id'], $data['item_id'], $data['school_id'], $data['date_id']];
        $sql 	= "CALL sp_dashboard_submission_get(?, ?, ?, ?)";
        
        $query 	= $this->dbCol->query($sql, $buffer);
        $buffer2 = $query->result();

        $query->next_result(); 
        $query->free_result(); 
        
        
        $handle = null;
        $count = -1;
        foreach ($buffer1 as $beis) {

            $buffer['scope_id']   = isset($beis->scope_id) ? $beis->scope_id : null;
            $buffer['scope_name'] = isset($beis->scope_name) ? $beis->scope_name : null;

            if ($handle != $beis->loc_id) {
                $count++;
                $handle = $beis->loc_id;
                $buffer['loc_id'][$count] 		            = $beis->loc_id;
                $buffer['loc_name'][$count] 	            = $beis->loc_name;
                $buffer['school_submitted'][$count] 	    = 0;
                $buffer['school_not_submitted'][$count]     = 0;
                $buffer['total_schools'][$count]            = 0;
            } 
            $match = false;
            foreach ($buffer2 as $col) {

                if ($beis->school_id == $col->school_id) {
                    $match = true;
                    $buffer['school_submitted'][$count]++;    
                    $buffer['total_schools'][$count]++;
                }
            }     

            if ( ! $match && $beis->school_id) {
                $buffer['school_not_submitted'][$count]++;
                $buffer['total_schools'][$count]++;
            }
        }

        return $buffer;
    }


    private function _getFromEbeis($data) {

        $sql_head   = 'SELECT a.id AS region_id, 
                        b.id AS division_id,  
                        c.school_id
                        FROM region AS a 
                        LEFT JOIN division AS b 
                        ON b.region_id = a.id 
                        LEFT JOIN school AS c 
                        ON c.division_id = b.id 
                        WHERE c.school_id IS NOT NULL '; 

        $sql_where = ' ';

        if ($data['region_id'])     $sql_where .= ' AND region_id = ' . $data['region_id'];
        if ($data['division_id'])   $sql_where .= ' AND division_id = ' . $data['division_id'];
        if ($data['school_id'])     $sql_where .= ' AND c.school_id = ' . $data['school_id'];

        $sql = $sql_head . $sql_where;

        $query    = $this->dbEbeis->query($sql);
        $result   = $query->result();

        $query->free_result();

        return $result;
    }

    public function validSchoolID($id) {
        
        $sql      = "SELECT school_name FROM school WHERE school_id = ?";
        $query    = $this->dbEbeis->query($sql,[$id]);
        
        if ( ! $query->num_rows()) {
            
            return false;
        }

        return true;
    }


    public function createDataFromLocal($data){    
        
        $this->dbCol->trans_begin();

        $this->dbCol->insert_batch('checklistactivitydate', $data['cad']);

        foreach ($data['location'] as $key=>$location) {
            $where = array('id' => $location['id'], 'school_id' => $location['school_id']);
            
            $this->dbCol->select('*');
            $this->dbCol->from('location');
            $this->dbCol->where($where);
            $result = $this->dbCol->get();

            if ($result->num_rows() > 0){
                unset($data['location'][$key]);
            }
        }
        if(!empty($data['location'])){
            $this->dbCol->insert_batch('location', $data['location']);
        }

        foreach ($data['sublocation'] as $key=>$sublocation) {
            $where = array('id' => $sublocation['id'], 'school_id' => $sublocation['school_id'], 'location_id' => $sublocation['location_id']);
            
            $this->dbCol->select('*');
            $this->dbCol->from('sublocation');
            $this->dbCol->where($where);
            $result = $this->dbCol->get();

            if ($result->num_rows() > 0){
                unset($data['sublocation'][$key]);
            }
        }
        if(!empty($data['sublocation'])){
            $this->dbCol->insert_batch('sublocation', $data['sublocation']);
        }

        if(!empty($data['additionalHazard']))
            $this->dbCol->insert_batch('hazard', $data['additionalHazard']);

        if(!empty($data['record']))
            $this->dbCol->insert_batch('record', $data['record']);

        if(!empty($data['recordphoto']))
            $this->dbCol->insert_batch('recordphoto', $data['recordphoto']);

        if(!empty($data['recordaction']))
            $this->dbCol->insert_batch('recordaction', $data['recordaction']);

        if(!empty($data['narrative']))
            $this->dbCol->insert_batch('narrative', $data['narrative']);

        if(!empty($data['summary']))
            $this->dbCol->insert_batch('summary', $data['summary']);

        if ($this->dbCol->trans_status() === FALSE){
                $this->dbCol->trans_rollback();
                return 0;
        }else{
                $this->dbCol->trans_commit();
                return 1;
        }
    }    
}