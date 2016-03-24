<?php

//cigar_stations

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_stations extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_stations';
        $this->_pk    = 'sid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_stations ');
    }

    public function insert($name){
        return parent::insert(array('name' => $name),true);
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
    
    public function update($id,$name){
        return parent::update($id,array('name' => $name));
    }

}

?>