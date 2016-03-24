<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_culture_ad extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_culture_ad';
        $this->_pk    = 'caid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_culture_ad ');
    }
    
    public function insert($url,$image,$startTime,$endTime,$position){
        $data = array(
            'url' => $url,
            'image' => $image,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'position' => $position
        );
        return parent::insert($data,true);
    }
    
    public function update($id,$url,$image,$startTime,$endTime,$position){
        $data = array(
            'url' => $url,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'position' => $position
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
        $sql = <<<EOT
SELECT image FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)['image'];
    }
    
    public function ad($position = 0){
        $sql = <<<EOT
SELECT url,image,position FROM cigar_culture_ad WHERE now() > startTime AND now() < endTime 
AND position=$position ORDER BY caid desc LIMIT 1
EOT;
        return DB::fetch_first($sql);
    }
    
}


?>