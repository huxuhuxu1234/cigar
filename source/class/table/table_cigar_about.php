<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_about extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_about';
        $this->_pk    = 'aid';

        parent::__construct();
    }


    /**
     * 后台显示
     * @return multitype:unknown
     */
    public function fetch_data_flag_admin(){
        return DB::fetch_all('SELECT aid,header,`order`,right_header,right_img FROM cigar_about ');
    }
    
    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_about ORDER BY `order` ');
    }
    
    
    
    public function insert($header,$order,$content,$right_header,$right_img,$right_content){
        $data = array(
            'header' => $header,
            'order' => $order,
            'content' => $content,
            'right_header' => $right_header,
            'right_img' => $right_img,
            'right_content' => $right_content
        );
        return parent::insert($data,true);        
    }
    
    public function update($id,$header,$order,$content,$right_header,$right_img,$right_content){
        $data = array(
            'header' => $header,
            'order' => $order,
            'content' => $content,
            'right_header' => $right_header,
            'right_content' => $right_content
        );
        if (isset($right_img) && $right_img){
            $data['right_img'] = $right_img;
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
        $img = 'right_img';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }

}

?>