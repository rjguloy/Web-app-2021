<?php

class SQLiteModel extends CI_Model {
	
	public $out = [];
    
    public function __construct() {
		$this->load->database();
	}

    public function __destruct() {
		$this->db->close();
	}

    public function buildSWT($team){
        log_message("info", $team);
        $this->cleanupDB();
        $this->prepareSWT($team);
        $this->prepareHazardCategory($team);
        $this->prepareHazardItem($team);
        $this->prepareHazard($team);
        $this->prepareSubLocation($team);
        $this->prepareLocation($team);
        $this->prepareSwtPermission($team);
        $this->prepareChecklistActivityDate();
    }

    public function isDBValid(){
        
        return $this->checkRecords();
    }

    public function syncData($cad){
        $details = $this->retrieveRecordPhoto($cad);
        //log_message("info", $list);
        //log_message("info", substr($details[0]->username, 0, 1));
        $this->removeOldRecord($cad, substr($details[0]->username, 0, 1));
        $this->prepareRecordInsert($details);
    }

    private function checkRecords(){
        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "SELECT count(*) cnt FROM swt"; 
        if ($db->querySingle($sql)>0){
            $sql = "SELECT count(*) FROM checklistactivtydate"; 
            if ($db->querySingle($sql)>0){
                $sql = "SELECT count(*) FROM hazard"; 
                if ($db->querySingle($sql)>0){
                    $sql = "SELECT count(*) FROM hazardcategory"; 
                    if ($db->querySingle($sql)>0){
                    $sql = "SELECT count(*) FROM hazarditem"; 
                    if ($db->querySingle($sql)>0){
                        $sql = "SELECT count(*) FROM location"; 
                        if ($db->querySingle($sql)>0){
                            $sql = "SELECT count(*) FROM sublocation"; 
                            if ($db->querySingle($sql)>0){
                                return true;
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
                }else{
                    return false;
                }

            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    private function cleanupDB(){
        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sqls = [];
        array_push($sqls, 'DELETE FROM swt');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM checklistactivtydate');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM hazard');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM hazardcategory');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM hazarditem');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM location');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM sublocation');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM record');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM recordphoto');
        array_push($sqls, 'VACUUM');
        array_push($sqls, 'DELETE FROM swtpermission');
        array_push($sqls, 'VACUUM');
        foreach ($sqls as &$sql) {
            $db->exec($sql);
        }
        
        return true;
    }

    private function prepareSWT($team){
        $query = "SELECT id, name, gender, team FROM swt WHERE team = ? AND createStatus = 'ACTIVE';";

        $result = $this->db->query($query, [$team]);
        $userList = $result->result();

        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO swt (username, name, gender, team, avatar) VALUES (:username, :name, :gender, :team, ABS(RANDOM()) % (3) + 1)";   
        $insert = $db->prepare($sql);
        foreach($userList as &$user){
            $insert->bindValue(':username',strval($user->id),SQLITE3_TEXT);
            $insert->bindValue(':name',strval($user->name),SQLITE3_TEXT);
            $insert->bindValue(':gender',strval($user->gender),SQLITE3_TEXT);
            $insert->bindValue(':team',strval($user->team),SQLITE3_TEXT);
            $insert->execute();
        }
        
    }

    private function prepareHazardCategory($team){
        $query = "SELECT DISTINCT hc.id, hc.name 
                    FROM sublocation sl
                   INNER JOIN hazardcategory hc 
                      ON sl.hazardcategory_id = hc.id 
                   INNER JOIN swtpermission sp
                      ON sp.sublocation_id = sl.id 
                   WHERE team = ?
                     AND sp.createStatus = 'ACTIVE';";

        $result = $this->db->query($query, [$team]);
        $list = $result->result();

        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO hazardcategory (category_name, category_id) VALUES (:category_name, :category_id)";   
        $insert = $db->prepare($sql);
        foreach($list as &$hazardCategory){
            $insert->bindValue(':category_name',strval($hazardCategory->name),SQLITE3_TEXT);
            $insert->bindValue(':category_id',strval($hazardCategory->id),SQLITE3_TEXT);
            $insert->execute();
        }

        $insert->bindValue(':category_name',"Additional",SQLITE3_TEXT);
        $insert->bindValue(':category_id',6,SQLITE3_INTEGER);
        $insert->execute();
        
    }


    private function prepareHazardItem($team){
        $query = "SELECT DISTINCT hi.hazardcategory_id, hi.hazard_id 
                    FROM sublocation sl
                   INNER JOIN hazardcategory hc 
                      ON sl.hazardcategory_id = hc.id 
                   INNER JOIN hazarditem hi 
                      ON hi.hazardcategory_id = hc.id
                   INNER JOIN swtpermission sp
                      ON sp.sublocation_id = sl.id 
                   WHERE team = ?
                     AND sp.createStatus = 'ACTIVE';";

        $result = $this->db->query($query, [$team]);
        $list = $result->result();

        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO hazarditem (hazardcategory_id, hazard_id) VALUES (:hazardcategory_id, :hazard_id)";   
        $insert = $db->prepare($sql);
        foreach($list as &$hazardItem){
            $insert->bindValue(':hazardcategory_id',strval($hazardItem->hazardcategory_id),SQLITE3_TEXT);
            $insert->bindValue(':hazard_id',strval($hazardItem->hazard_id),SQLITE3_TEXT);
            $insert->execute();
        }
    }

    private function prepareHazard($team){
        $query = "SELECT DISTINCT h.id, h.name 
                    FROM sublocation sl
                   INNER JOIN hazardcategory hc 
                      ON sl.hazardcategory_id = hc.id 
                   INNER JOIN hazarditem hi 
                      ON hi.hazardcategory_id = hc.id
                   INNER JOIN swtpermission sp
                      ON sp.sublocation_id = sl.id 
                   INNER JOIN hazard h 
                      ON h.id = hi.hazard_id
                   WHERE team = ?
                     AND sp.createStatus = 'ACTIVE';";

        $result = $this->db->query($query, [$team]);
        $list = $result->result();

        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO hazard (hazard_id, hazard_name) VALUES (:hazard_id, :hazard_name)";   
        $insert = $db->prepare($sql);
        foreach($list as &$hazard){
            $insert->bindValue(':hazard_id',strval($hazard->id),SQLITE3_TEXT);
            $insert->bindValue(':hazard_name',strval($hazard->name),SQLITE3_TEXT);
            $insert->execute();
        }
    }

    private function prepareSubLocation($team){
        $query = "SELECT DISTINCT sl.name, sl.location_id, sl.id
                    FROM swtpermission sp 
                   INNER JOIN sublocation sl on sl.id = sp.sublocation_id
                   WHERE team = ?
                     AND sp.createStatus = 'ACTIVE'
                     AND sl.createStatus = 'ACTIVE' ";

        $result = $this->db->query($query, [$team]);
        $list = $result->result();

        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO sublocation (location_id, name, sublocation_id) VALUES (:location_id, :name, :sublocation_id)";   
        $insert = $db->prepare($sql);

        foreach($list as &$location){
            $x = $location->location_id;
            $insert->bindValue(':location_id',strval($location->location_id),SQLITE3_TEXT);
            $insert->bindValue(':name',strval($location->name),SQLITE3_TEXT);
            $insert->bindValue(':sublocation_id',strval($location->id),SQLITE3_TEXT);
            $insert->execute();
        }
        
    }

    private function prepareLocation($team){
        $query = "SELECT DISTINCT l.name, l.id
                    FROM swtpermission sp 
                   INNER JOIN sublocation sl 
                      ON sl.id = sp.sublocation_id
                   INNER JOIN location l 
                      ON sl.location_id = l.id
                   WHERE team = ?
                     AND sp.createStatus = 'ACTIVE'
                     AND l.createStatus = 'ACTIVE'";

        $result = $this->db->query($query, [$team]);
        $list = $result->result();

        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO location (location_id, name) VALUES (:location_id, :name)";   
        $insert = $db->prepare($sql);
        foreach($list as &$location){
            $insert->bindValue(':location_id',strval($location->id),SQLITE3_TEXT);
            $insert->bindValue(':name',strval($location->name),SQLITE3_TEXT);
            $insert->execute();
        }
    }

    private function prepareChecklistActivityDate(){
        $query = "SELECT `date`, id
                    FROM checklistactivitydate
                   WHERE createStatus = 'ACTIVE';";

        $result = $this->db->query($query);
        $list = $result->result();

        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO checklistactivtydate (cad_date, cad_code) VALUES (:cad_date, :cad_code)";   
        $insert = $db->prepare($sql);
        foreach($list as &$cad){
            $insert->bindValue(':cad_date',strval($cad->date),SQLITE3_TEXT);
            $insert->bindValue(':cad_code',strval($cad->id),SQLITE3_TEXT);
            $insert->execute();
        }
    }

    private function prepareSwtPermission($team){
        $query = "SELECT DISTINCT sublocation_id, hazardcategory_id
                    FROM sublocation sl
                   INNER JOIN swtpermission sp
                      ON sl.id = sp.sublocation_id
                   WHERE team = ?
                     AND sp.createStatus = 'ACTIVE'";

        $result = $this->db->query($query, [$team]);
        $list = $result->result();
        //log_message("info", $list);
        $db = new SQLite3(APPPATH . '/db/SWApp.db');
        $sql = "INSERT INTO swtpermission (sublocation_id, hazardcategory_id) VALUES (:sublocation_id, :hazardcategory_id)";   
        $insert = $db->prepare($sql);
        foreach($list as &$location){
            $insert->bindValue(':sublocation_id',strval($location->sublocation_id),SQLITE3_TEXT);
            $insert->bindValue(':hazardcategory_id',strval($location->hazardcategory_id),SQLITE3_TEXT);
            $insert->execute();
        }
        $insert->bindValue(':sublocation_id',-1,SQLITE3_TEXT);
        $insert->bindValue(':hazardcategory_id',3,SQLITE3_TEXT);
        $insert->execute();
    }

    private function retrieveRecordPhoto($cad){
        $db = new SQLite3(FCPATH . '/uploads/db/SWApp.db');
        $sql = "SELECT r.id, r.hazard_id, h.hazard_name, r.hazardcategory_id, r.sublocation_id, r.cad_id, r.username, rp.image imageBlob
                  FROM record r 
                 INNER JOIN recordPhoto rp 
                    ON r.id = rp.record_id 
                 INNER JOIN hazard h
                    ON h.hazard_id = r.hazard_id
                 WHERE r.cad_id = :cad_id";   

        $select = $db->prepare($sql);
       
        $select->bindValue(':cad_id',$cad, SQLITE3_INTEGER);
        
        $result = $select->execute();
        $tmp = -1;
        $details = [];
        $images = [];
        $object = new stdClass();
        while ($row = $result->fetchArray()) {
            $recordId = $row['id'];
            if ($tmp == -1){
                $tmp = $row["id"];
            }
            if ($tmp != $recordId) {
                $recordId = $tmp;
                $object->images = $images;
                array_push($details, $object);
                $recordId = $row["id"];
                $tmp = $recordId;
                $images = [];
            }
            $imageBlob = $row["imageBlob"];
            array_push($images, $imageBlob);
            $object = new stdClass();
            $object->hazardId = $row["hazard_id"];
            $object->hazardName = $row["hazard_name"];
            $object->hazardCategoryId = $row["hazardcategory_id"];
            $object->sublocationId = $row["sublocation_id"];
            $object->cadId = $row["cad_id"];
            $object->username = $row["username"];
            $object->images = $images;
        }
        array_push($details, $object);
        return $details;
    }

    private function removeOldRecord($cad_id, $team){
        
        $sql = "SET FOREIGN_KEY_CHECKS=0;";
        $this->db->query($sql, []);
        $sql = "DELETE r, rp, s 
                  FROM record r 
                 INNER JOIN recordphoto rp ON r.id = rp.record_id
                 INNER JOIN summary s ON s.cad_id = r.cad_id AND r.hazard_id = s.hazard_id
                 WHERE r.cad_id = ? AND locate(?,r.createdby)";
        $this->db->query($sql, [$cad_id, $team]);
        $sql = "SET FOREIGN_KEY_CHECKS=1;";
        $this->db->query($sql, []);

    }

    private function prepareRecordInsert($details){


        
        $this->db->select('id');
        $this->db->from('school');
        $this->db->where('createStatus', 'ACTIVE');
        $query = $this->db->get();
        $school_id = 0;
        foreach ($query->result() as $row)
        {
            $school_id = $row->id;
        }

        
        $insert = "INSERT INTO record (id,school_id,cad_id,sublocation_id,hazard_id,createdBy) 
                    SELECT coalesce(max(id)+1,1),?,?,?,?,? from record";

       
        $photo = "INSERT INTO recordphoto (id, school_id, record_id, image, createdby) 
                  SELECT coalesce(max(id)+1,1),?,?,?,? 
                    FROM recordphoto ";

        foreach ($details as &$record) {
            $hazard_id = $this->getHazardId($record->hazardId, $record->hazardName, $school_id, $record->username);
            $this->db->query($insert, [$school_id, $record->cadId, $record->sublocationId, $hazard_id, $record->username]);
            $last_id = $this->db->insert_id();
            $id = $this->getLastInsertRecordId($last_id );
            foreach ($record->images as &$image){
                $this->db->query($photo, [$school_id,$id,base64_decode($image), $record->username]);
            }
        }
    }

    private function getHazardId($hazard_id, $hazard_name, $school_id, $username){
        $this->db->select('hazard_id');
        $this->db->from('hazarditem');
        $this->db->where('hazard_id', $hazard_id);
        $query = $this->db->get();
        $record_id = 0;
        foreach ($query->result() as $row)
        {
            $record_id = $hazard_id;
        }
        if ($record_id == 0){
            $insert = "INSERT INTO hazard (id,school_id,name,description,type,createdBy) 
            SELECT coalesce(max(id)+1,1),?,?,null,'ADDITIONAL',? from hazard";
            $this->db->query($insert, [$school_id,$hazard_name, $username]);
            $last_id = $this->db->insert_id();

            $this->db->select('id');
            $this->db->from('hazard');
             $this->db->where('seqid', $last_id);
            $query = $this->db->get();
            $record_id = 0;
            foreach ($query->result() as $row)
            {
                $record_id = $row->id;
            }
            return $record_id;
        }else{
            return $hazard_id;
        }
        
    }

    public function isCADExisting($cad){
        $isExisting = false;
        $this->db->select('id');
        $this->db->from('checklistactivitydate');
        $this->db->where('id', $cad);
        $this->db->where('createstatus', 'ACTIVE');
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            $isExisting = true;
        }

        return $isExisting;
    }

    private function getLastInsertRecordId($last_insert_id){
        $this->db->select('id');
        $this->db->from('record');
        $this->db->where('seqid', $last_insert_id);
        $query = $this->db->get();
        $record_id = 0;
        foreach ($query->result() as $row)
        {
            $record_id = $row->id;
        }

        return $record_id;
    }
}
