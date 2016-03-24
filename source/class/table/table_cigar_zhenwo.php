<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_zhenwo extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_zhenwo';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function fetch_data_flag_admin(){
        $sql = <<<EOT
SELECT * FROM {$this->table}
EOT;
        return DB::fetch_all($sql);
    }
    
    /**
     * 获取某个大咖的全部内容
     * @param number $id
     */
    public function data($id = 0){
        return DB::fetch_first('SELECT * FROM cigar_zhenwo WHERE id=' . $id);
    }
    
    public function insert($name,$image,$link){
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
        $data = array(
            'name' => $name,
            'image' => $image,
            'link' => $link,
            'insertTime' => $now
        );
        return parent::insert($data,true);
    }
    
    public function update($id,$name,$image,$link){
        $data = array(
            'name' => $name,
            'link' => $link
        );
        if ($image){
            $data['image'] = $image;
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
        $img = 'image';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }
    
    
    /**
     * 获取某一页的大咖信息
     * 
     * 注：  一页8个信息
     * @param number $index
     */
    public function page($index = 1){
        //最小限制
        $s_limit = ($index-1) * 16;
        $sql = <<<EOT
SELECT * FROM {$this->table}
ORDER BY insertTime DESC
LIMIT $s_limit,16
EOT;
        return DB::fetch_all($sql);
    }
    
    
    /**
     * 获取某个总共个有多少页
     */
    public function pageCount(){
        $count = parent::count();
        return $count %16 == 0 ? $count / 16 : intval($count / 16 + 1);
    }
   
    
    /**
     * 获取某个id 的另外一个id ， 如果没有则返回-1
     * @param number $id
     * @return number
     */
    public function _next_id($id = 0){
        $id = DB::fetch_first('SELECT bid FROM cigar_big_shots WHERE bid>'.$id.' ORDER BY bid ASC LIMIT 1');
        if ($id){
            return $id['bid'];
        }
        return -1;
    }
    
    
    public function _prev_id($id = 0){
        $id = DB::fetch_first('SELECT bid FROM cigar_big_shots WHERE bid<'.$id.' ORDER BY bid DESC LIMIT 1');
        if ($id){
            return $id['bid'];
        }
        return -1;
    }
    
	
	public function  searchName($name){
        return DB::fetch_all('SELECT * FROM cigar_zhenwo WHERE name like \'%'.$name.'%\'');
    }
    
}

?>