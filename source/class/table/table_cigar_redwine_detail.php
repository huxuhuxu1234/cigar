<?php

if (! defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_redwine_detail extends discuz_table
{

    public function __construct()
    {
        $this->_table = 'cigar_redwine_detail';
        $this->_pk = 'pid';

        parent::__construct();
    }
    
    public function insert(
        $pid,$type,$regions,$level,$grape_varieties,$score1,$score2,$score3,$score4,$score5,$score6,
        $capacity,$chateau,$drinktemp,$ext1_title,$ext1_content,$ext2_title,$ext2_content,$up_count,
        $image1='',$image2='',$image3='',$image4='',$image5=''){
        $data = array(
            'pid' => $pid,
            'type' => $type,
            'regions' => $regions,
            'level' => $level,
            'grape_varieties' => $grape_varieties,
            'score1' => $score1,
            'score2' => $score2,
            'score3' => $score3,
            'score4' => $score4,
            'score5' => $score5,
            'score6' => $score6,
            'capacity' => $capacity,
            'chateau' => $chateau,
            'drinktemp' => $drinktemp,
            'ext1_title' => $ext1_title,
            'ext1_content' => $ext1_content,
            'ext2_title' => $ext2_title,
            'ext2_content' => $ext2_content,
            'up_count' => $up_count,
            'image1' => $image1,
            'image2' => $image2,
            'image3' => $image3,
            'image4' => $image4,
            'image5' => $image5
        );
        
        return parent::insert($data,true);
        
    }
    
    
    public function update(
        $pid,$type,$regions,$level,$grape_varieties,$score1,$score2,$score3,$score4,$score5,$score6,
        $capacity,$chateau,$drinktemp,$ext1_title,$ext1_content,$ext2_title,$ext2_content,$up_count,
        $image1='',$image2='',$image3='',$image4='',$image5=''){
        $data = array(
            'type' => $type,
            'regions' => $regions,
            'level' => $level,
            'grape_varieties' => $grape_varieties,
            'score1' => $score1,
            'score2' => $score2,
            'score3' => $score3,
            'score4' => $score4,
            'score5' => $score5,
            'score6' => $score6,
            'capacity' => $capacity,
            'chateau' => $chateau,
            'drinktemp' => $drinktemp,
            'ext1_title' => $ext1_title,
            'ext1_content' => $ext1_content,
            'ext2_title' => $ext2_title,
            'ext2_content' => $ext2_content,
            'up_count' => $up_count,
            'image1' => $image1,
            'image2' => $image2,
            'image3' => $image3,
            'image4' => $image4,
            'image5' => $image5
        );
    
        return parent::update($pid,$data);
    
    }
    
    /**
     * 检测是否可以删除外键
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete_pid($pid){
        $sql = <<<EOT
SELECT pid FROM cigar_redwine_detail WHERE pid = $pid
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
    public function getImage1Path($id){
        $table = $this->_table;
        $pk = $this->_pk;
        $img = 'image1';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }
    
    public function getImage2Path($id){
        $table = $this->_table;
        $pk = $this->_pk;
        $img = 'image2';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }
    
    public function getImage3Path($id){
        $table = $this->_table;
        $pk = $this->_pk;
        $img = 'image3';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }
    
    public function getImage4Path($id){
        $table = $this->_table;
        $pk = $this->_pk;
        $img = 'image4';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }
    
    public function getImage5Path($id){
        $table = $this->_table;
        $pk = $this->_pk;
        $img = 'image5';
        $sql = <<<EOT
SELECT `$img` FROM $table WHERE $pk = $id;
EOT;
        return DB::fetch_first($sql)[$img];
    }

}

?>