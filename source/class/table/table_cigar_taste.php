<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_taste extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_taste';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_taste ');
    }

    public function insert($uid,$pid,$taste = 0,$num = 0){
        return parent::insert(array('uid' => $uid,'taste' => $taste,'num' => $num,'pid' => $pid),true);
    }
    
    public function update($id,$uid,$pid,$taste = 0,$num = 0){
        return parent::update($id,array('uid' => $uid,'taste' => $taste,'num' => $num,'pid' => $pid));
    }
    
    public function auto_update($uid,$pid,$taste = 0,$num = 0){
        //如果存在数据就更新，否则就进行插入操作
        $data = self::data($pid, $uid);
        if ($data && isset($data['id'])){
            //更新
            return self::update($data['id'],$uid, $pid,$taste,$num);
        }else{
            //插入
            return self::insert($uid, $pid,$taste,$num);
        }
    }
    
    public function data($pid,$uid){
        return DB::fetch_first('SELECT * FROM ' . $this->_table . ' WHERE pid=' .$pid . ' AND uid=' .$uid);
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