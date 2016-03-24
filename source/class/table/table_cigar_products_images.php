<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_products_images extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_products_images';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function insert($pid,$image,$length,$width,$size,$frontmark,$origin){
        $data = array(
            'pid' => $pid,
            'image' => $image,
            'length' => $length,
            'width' => $width,
            'size' => $size,
            'frontmark' => $frontmark,
            'origin' => $origin
        );
        return parent::insert($data,true);
    }

    public function update($id,$pid,$image,$length,$width,$size,$frontmark,$origin){
        $data = array(
            'pid' => $pid,
            'length' => $length,
            'width' => $width,
            'size' => $size,
            'frontmark' => $frontmark,
            'origin' => $origin
        );
		if(isset($image) && $image){
			$data['image'] = $image;
		}
        return parent::update($id, $data);
    }

	public function delete_by_pid($pid){
		$sql = 'DELETE FROM ' . $this->table . ' WHERE pid = ' . $pid;
		return DB::query($sql);
	}
	
	public function first_id_flag_pid($pid = 0,$index = 0){
		$sql = 'SELECT id FROM ' . $this->table . ' WHERE pid = ' . $pid . ' ORDER BY id ASC LIMIT ' .$index. ',1';
		$ret = DB::fetch_first($sql);
		//echo 'sql: ' . $sql;
		if($ret){
			//echo 'ret[0]: ' . $ret['id'];
			return $ret['id'];
		}
		return -1;
	}

    public function delete_pid_array($id_array){
        $ret = 0;
        foreach ($id_array as $id){
            $ret .= DB::delete($this->_table, DB::field('pid', $id), null);
        }
        return $ret;
    }
    
    public function delete_one_flag_pid($pid = 0){
        $id = DB::fetch_first('SELECT * FROM ' . $this->_table . ' WHERE pid=' . $pid);
        if ($id && isset($id['id'])){
            $ret = $id['image'];
            parent::delete($id['id']);  
            return $ret;         
        }
    }
    
    
    public function _list($pid){
        return DB::fetch_all('SELECT id,pid,image,length,width,size,frontmark,origin FROM '. $this->_table. ' WHERE pid = '.$pid);
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
        $img = 'image';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }


}

?>