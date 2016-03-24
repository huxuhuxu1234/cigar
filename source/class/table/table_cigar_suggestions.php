<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_suggestions extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_suggestions';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_suggestions ');
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

    
    public function insert($uid,$name,$email,$title,$content,$type){
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
		//exit('t: ' . $type);
        $data = array(
            'uid' => $uid,
            'name' => $name,
            'email' => $email,
            'title' => $title,
            'content' => $content,
            'publish_time' => $now,
			'stype' => $type
        );
        return parent::insert($data,true);
    }


}

?>