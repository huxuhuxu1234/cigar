<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_box_limit_group extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_box_limit_group';
        $this->_pk    = 'groupid';

        parent::__construct();
    }


    public function usedGid(){
        return DB::fetch_all('SELECT groupid FROM cigar_box_limit_group');            
    }
    
    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_box_limit_group');
    }

    public function insert($groupid,$limit){
        return parent::insert(array('groupid' => $groupid,'limit' => $limit),true);
    }
    
    public function update($groupid,$limit){
        return parent::update($groupid,array('limit' => $limit));
    }

    public function delete_id_array($id_array){
        $ret = 0;
        foreach ($id_array as $id){
            $t = parent::delete($id);
            if($t){
                $ret += $t;
            }
        }
        return $ret;
    }
    
}

?>