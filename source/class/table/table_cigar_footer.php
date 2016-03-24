<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_footer extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_footer';
        $this->_pk    = 'fid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_footer ');
    }
    
    public function fetch_data_left(){
        return DB::fetch_all('SELECT url,image FROM cigar_footer WHERE postion =  -1 LIMIT 1');
    }
    
    public function fetch_data_right(){
        return DB::fetch_all('SELECT url,image FROM cigar_footer WHERE postion =  1 LIMIT 1');
    }
    
    public function fetch_data_middle(){
        return DB::fetch_all('SELECT url,image FROM cigar_footer WHERE postion =  0');
    }

    public function insert($url,$image,$pos){
        $data = array(
            'url' => $url,
            'image' => $image,
            'postion' => $pos
        );
        return parent::insert($data,true);
    }
    
    public function update($id,$url,$image,$pos){
        $data = array(
            'url' => $url,
            'postion' => $pos
        );
        if (isset($image) && $image){
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
    
}

?>