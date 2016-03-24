<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_search extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_search';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM ' . $this->_table);
    }

    //word,condition
    public function insert($word,$condition ){
        return parent::insert(array('word' => $word,'condition' => $condition),true);
    }
    
    public function update($id,$word,$condition){
        return parent::update($id,array('word' => $word,'condition' => $condition));
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