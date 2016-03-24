<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_box_groom_commonage extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_box_groom_commonage';
        $this->_pk    = 'cid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_box_groom_commonage ');
    }

    public function insert($name){
        return parent::insert(array('name' => $name),true);
    }

    public function update($id,$name){
        return parent::update($id,array('name' => $name));
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