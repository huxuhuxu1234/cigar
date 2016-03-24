<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_culture extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_culture';
        $this->_pk    = 'cid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_culture ');
    }
    
    public function fetch_data_flag_admin(){
        return DB::fetch_all('SELECT cid,`name` as header,title,source,up_count,view,author,publish_time FROM cigar_culture,cigar_culture_header where hid=chid');
    }
    
    public function insert($hid,$title,$source,$description,$content,$image,$up_count,$view,$author){
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
        $data = array(
            'hid' => $hid,
            'title' => $title,
            'source' => $source,
            'description' => $description,
            'content' => $content,
            'image' => $image,
            'up_count' => $up_count,
            'view' => $view,
            'publish_time' => $now,
            'author' => $author
        );
        return parent::insert($data,true);
    }
    
    public function update($id,$hid,$title,$source,$description,$content,$image,$up_count,$view,$author){
        $data = array(
            'hid' => $hid,
            'title' => $title,
            'source' => $source,
            'description' => $description,
            'content' => $content,
            'up_count' => $up_count,
            'view' => $view,
            'author' => $author
        );
        if($image){
            $data['image'] = $image;
        }
        return parent::update($id,$data);
    }
    
    /**
     * 检测是否可以删除外键
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete($type,$value){
        $table = $this->_table;
        $pk = $this->_pk;
        $sql = <<<EOT
SELECT $pk FROM $table WHERE `$type` = $value
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
        $img = 'image';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }
    
    /**
     * 查询热门阅读
     */
    public function hot_read(){
        $sql = 'SELECT cid,title,description,image,view,publish_time FROM cigar_culture ORDER BY view DESC LIMIT 3';
        return DB::fetch_all($sql);
    }
    
    /**
     * 查询内容页的热门阅读
     */
    public function hot_read_content(){
        $sql = 'SELECT cid,title,description,image FROM cigar_culture ORDER BY view DESC LIMIT 5';
        return DB::fetch_all($sql);
    }
    
    /**
     * 搜索某个特定头部的一页数据
     * @param number $header
     * @param number $index
     */
    public function page($header = 0,$index = 1){
        $s_limit = ($index-1) * 7;
        $sql = <<<EOT
SELECT cid,title,author,description,image,view,publish_time FROM cigar_culture 
WHERE hid = $header ORDER  BY publish_time DESC LIMIT $s_limit,7
EOT;
        return DB::fetch_all($sql);
    }
    
    
    /**
     * 获取某个头部总共个有多少页
     */
    public function pageCount($header = 0){
        $count = (int) DB::fetch_first('SELECT count(1) as count FROM cigar_culture WHERE hid='.$header)['count'];
        return $count %7 == 0 ? $count / 7 : intval($count / 7 + 1);
    }
    
    /**
     * 获取某个id 的另外一个id ， 如果没有则返回-1
     * @param number $id
     * @return number
     */
    public function _next_id($id = 0){
        $id = DB::fetch_first('SELECT cid FROM cigar_culture WHERE cid>'.$id.' ORDER BY cid ASC LIMIT 1');
        if ($id){
            return intval($id['cid']);
        }
        return -1;
    }
    
    
    public function _prev_id($id = 0){
        $id = DB::fetch_first('SELECT cid FROM cigar_culture WHERE cid<'.$id.' ORDER BY cid DESC LIMIT 1');
        if ($id){
            return intval($id['cid']);
        }
        return -1;
    }
    
    public function up_count_plus($cid = -1 , $op = '+'){
        return DB::query('UPDATE cigar_culture SET up_count = up_count ' . $op. ' 1 WHERE cid = ' . $cid);
    }
    
    
}

?>