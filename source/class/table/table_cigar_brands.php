<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_brands extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_brands';
        $this->_pk    = 'bid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_brands ');
    }

    public function insert($name,$type ){
        return parent::insert(array('value' => $name,'type' => $type),true);
    }
    
    public function update($id,$name,$type){
        return parent::update($id,array('value' => $name,'type' => $type));
    }
    
    public function _list($type = 0){
        return DB::fetch_all('SELECT * FROM ' . $this->_table . ' WHERE type=' . $type );
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
    
    public function check_type($typeValue,$brand){
        $type = DB::fetch_first('SELECT `type` FROM ' . $this->_table . ' WHERE bid = ' .$brand );
        if (!$type || !isset($type['type'])){
//             exit('-1');
            return  FALSE;
        }
//         exit('' . $type['type']);
        return $type['type'] == $typeValue;
    }
    
    
}

?>