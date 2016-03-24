<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_box_groom_2 extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_box_groom_2';
        $this->_pk    = 'id';

        parent::__construct();
    }


    public function fetch_data_flag_admin(){
        $sql = <<<EOT
SELECT b.id,b.pid,p.`name` as pName, y.name as yName,rank,frontmark
FROM cigar_box_groom_2 as b,cigar_products as p,cigar_box_groom_commonage as y,
cigar_products_images as im
WHERE b.pid = im.id AND `commonage` = cid
AND im.pid = p.pid
EOT;
        return DB::fetch_all($sql);
    }

    public function insert($pid,$commonage,$rank){
        $data =  array(
            'pid' => $pid,
            'commonage' => $commonage,
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
    public function check_delete($commonage){
        $sql = <<<EOT
SELECT id FROM cigar_box_groom_2 WHERE `commonage` = $commonage
EOT;
        if (DB::fetch_first($sql)){
            return false;
        }
        return true;
    }
    
    public function data($comm){
        $sql = <<<EOT
SELECT  c.commonage as  commonage,c.rank as rank,im.frontmark as name,im.width as width,
im.length as length,o.value as oName,im.image as image,p.pid as pid,im.id as imid,im.size
FROM {$this->_table} as c,cigar_products as p, cigar_origins as o,cigar_products_images as im
WHERE c.pid = im.id AND p.origin = o.oid
AND p.pid = im.pid
AND c.commonage = $comm
ORDER BY c.rank DESC
EOT;
        return DB::fetch_all($sql);
    }
}

?>