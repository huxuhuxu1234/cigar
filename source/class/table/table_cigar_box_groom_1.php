<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_box_groom_1 extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_box_groom_1';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function fetch_data_flag_admin(){
        $sql = <<<EOT
SELECT b.id,b.pid as imid,p.`name` as pName, y.name as yName,rank,frontmark
FROM cigar_box_groom_1 as b,cigar_products as p,cigar_box_groom_year as y,
cigar_products_images as im
WHERE b.pid = im.id AND im.pid = p.pid AND b.year = y.yid
EOT;
        return DB::fetch_all($sql);
    }

    public function insert($pid,$year,$rank){
        $data =  array(
            'pid' => $pid,
            'year' => $year,
            'rank' => $rank
        );
        return parent::insert($data,true);
    }

    public function update($id,$rank){
        $data =  array(
            'rank' => $rank
        );
        return parent::update($id,$data);
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
     * 检测是否可以删除外键
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete($year){
        $sql = <<<EOT
SELECT id FROM cigar_box_groom_1 WHERE `year` = $year
EOT;
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
    

    public function data($year){
        $sql = <<<EOT
SELECT y.year as year,y.rank as rank,im.frontmark as name,im.width as width,im.length as length,
o.value as oName,im.image as image,p.pid as pid,im.size,im.id as imid
FROM {$this->_table} as y,cigar_products as p, cigar_origins as o,cigar_products_images as im
WHERE y.pid = im.id AND p.origin = o.oid
AND p.pid = im.pid
AND y.year = $year
ORDER BY y.rank DESC
EOT;
        return DB::fetch_all($sql);
    }
    
    
}

?>