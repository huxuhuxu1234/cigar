<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_images_index extends discuz_table
{
    
    public function __construct() {

		$this->_table = 'cigar_images_index';
		$this->_pk    = 'iid';

		parent::__construct();
	}


	public function fetch_data(){
	    return DB::fetch_all('SELECT * FROM cigar_images_index order by `order`');
	}
	
	public function fetch_data_path(){
	    return DB::fetch_all('SELECT path,url FROM cigar_images_index order by `order`');
	}
	
	public function fetch_data_time(){
	    return DB::fetch_all('SELECT show_time FROM cigar_images_index order by `order`');
	}
	
	
	
	public function insert($img,$time,$order,$url){
	    $data = array(
	        'path' => $img,
	        'show_time' => $time,
	        'order' => $order,
	        'url' => $url
	    );
	    return parent::insert($data,true);
	}
	
	public function update($id,$img,$time,$order,$url){
	    $data = array(
	        'show_time' => $time,
	        'order' => $order,
	        'url' => $url
	    );
	    if (isset($img) && $img){
	        $data['path'] = $img;
	    }
        return parent::update($id, $data);
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
	 * 根据主键， 获得图片的地址
	 * @param unknown $id 主键
	 * @return string 图片地址
	 */
	public function getImagePath($id){
	    $table = $this->_table;
	    $pk = $this->_pk;
	    $img = 'path';
	    $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
	    return DB::fetch_first($sql)[$img];
	}
}

?>