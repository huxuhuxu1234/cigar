<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_types extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_types';
        $this->_pk    = 'tid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_types');
    }
    
    public function update($id,$name){
        return parent::update($id,array('value' => $name));
    }
    
    public function _list(){
        return DB::fetch_all('SELECT * FROM ' . $this->_table . ' ORDER BY tid');
    }
    
    public function types_without_search(){
        
        return DB::fetch_all('SELECT * FROM cigar_types LIMIT 4');
        
    }
    
    public function first_id(){
        return DB::fetch_first('SELECT tid FROM cigar_types ORDER BY tid LIMIT 1');        
    }
    
    public function redwine_id(){
        return DB::fetch_first('SELECT tid FROM cigar_types ORDER BY tid LIMIT 3,1');
    }
	
	

}



?>