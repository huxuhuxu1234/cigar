<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_culture_header extends discuz_table
{
    
    public function __construct() {

		$this->_table = 'cigar_culture_header';
		$this->_pk    = 'chid';

		parent::__construct();
	}


	public function fetch_data(){
	    return DB::fetch_all('SELECT * FROM cigar_culture_header order by `order`');
	}
	
	public function insert($name,$order){
        return parent::insert(array('name' => $name,'order' => $order),true);
	}

	public function update($id,$name,$order){
        return parent::update($id,array('name' => $name,'order' => $order));
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
	
	/**
	 * 获取真实的hid
	 * @param number $index 第几个hid  从0开始
	 * @return number
	 */
	public function get_hid($index = 0){
	    return intval(DB::fetch_all('SELECT chid FROM cigar_culture_header ORDER BY `order`')[$index]['chid']);
	}
	
	public function get_header_list(){
	    return DB::fetch_all('SELECT chid,name FROM cigar_culture_header ORDER BY `order`');
	}
	
	
}

