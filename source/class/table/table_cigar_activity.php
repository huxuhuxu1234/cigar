<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_activity extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_activity';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM ' . $this->_table);
    }

    //word,condition
    public function insert($title,$url,$content){
        global  $_G;
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
        $data = array(
            'username' => $_G['username'],
            'uid' => $_G['uid'],
            'title' => $title ,
            'url' => $url ,
            'content' => $content,
            'publish_time' => $now
        );
//         exit('1');
        return parent::insert($data,true);
    }
    
    public function update($id,$title,$url,$content){
        global  $_G;
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
        $data = array(
            'title' => $title ,
            'url' => $url ,
            'content' => $content,
            'publish_time' => $now
        );
        return parent::update($id,$data);
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