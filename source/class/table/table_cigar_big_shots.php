<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_big_shots extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_big_shots';
        $this->_pk    = 'bid';

        parent::__construct();
    }


    public function fetch_data_flag_admin(){
        $sql = <<<EOT
SELECT bid,img,b.`name`,cigar_stations.`name` as station,b.pid
FROM cigar_big_shots as b,cigar_stations 
WHERE b.station = cigar_stations.sid 
EOT;
        return DB::fetch_all($sql);
    }
    
    /**
     * 获取某个大咖的全部内容
     * @param number $id
     */
    public function data($id = 0){
        return DB::fetch_first('SELECT img,b.name as bName,s.name as sName,content FROM cigar_big_shots as b ,cigar_stations as s WHERE b.station = s.sid AND b.bid=' . $id);
    }
    
    public function insert($img,$name,$station,$pid,$content){
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
        $data = array(
            'img' => $img,
            'name' => $name,
            'station' => $station,
            'pid' => $pid,
            'content' => $content,
            'publish_time' => $now
        );
        return parent::insert($data,true);
    }
    
    public function update($id,$img,$name,$station,$pid,$content){
        $data = array(
            'name' => $name,
            'station' => $station,
            'pid' => $pid,
            'content' => $content
        );
        if ($img){
            $data['img'] = $img;
        }
        return parent::update($id, $data);
    }

    
    public function delete_pid_array($id_array){
        $ret = 0;
        foreach ($id_array as $id){
            $ret .= DB::delete($this->_table, DB::field('pid', $id), null);
        }
        return $ret;
    }
    
    /**
     * 检测是否可以删除外键
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete_pid($pid){
        $table = $this->_table;
        $pk = $this->_pk;
        $sql = <<<EOT
SELECT $pk FROM $table WHERE pid = $pid
EOT;
        //         exit(DB::fetch_first($sql));
        if (DB::fetch_first($sql)){
            return false;
        }
        return true;
    }
    
    /**
     * 检测是否可以删除外键
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete($type, $value){
        $table = $this->_table;
        $pk = $this->_pk;
        $sql = <<<EOT
SELECT $pk FROM $table WHERE $type = $value
EOT;
        //         exit(DB::fetch_first($sql));
        if (DB::fetch_first($sql)){
            return false;
        }
        return true;
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
        $img = 'img';
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
        $s_limit = ($index-1) * 8;
        $sql = <<<EOT
SELECT bid,img,b.name as name,s.name as sName,b.pid as pName
FROM cigar_big_shots as b 
left join cigar_stations as s on b.station = s.sid
ORDER BY publish_time DESC
LIMIT $s_limit,8
EOT;
        return DB::fetch_all($sql);
    }
    
    
    /**
     * 获取某个总共个有多少页
     */
    public function pageCount(){
        $count = parent::count();
        return $count %8 == 0 ? $count / 8 : intval($count / 8 + 1);
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
    
    
}

?>