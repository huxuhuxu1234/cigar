<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_box_limit extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_box_limit';
        $this->_pk    = 'uid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_box_limit ');
    }

    public function insert($uid,$limit){
        return parent::insert(array('uid' => $uid,'limit' => $limit),true);
    }
    
    public function update($uid,$limit){
        return parent::update($uid,array('limit' => $limit));
    }
    
    public function extend($uid,$num){
        
        if(!parent::fetch($uid)){
            self::insert($uid, $num);
        }else{
            DB::query('UPDATE '.DB::table($this->_table) . ' SET `limit`=`limit`+' .$num . ' WHERE uid=' . $uid);
        }
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