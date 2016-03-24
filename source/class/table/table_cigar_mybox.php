<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_mybox extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_mybox';
        $this->_pk    = 'mid';

        parent::__construct();
    }


    /**
     * 后台显示
     * @return multitype:unknown
     */
    public function fetch_data_flag_admin(){
        $sql = <<<EOT
SELECT count(1) as count,p.pid,p.name,im.width,im.length,b.value as brand,o.value as origin,im.id as imid,frontmark
FROM cigar_mybox as m,cigar_products as p,cigar_brands as b,cigar_origins as o,cigar_products_images as im
WHERE m.pid = im.id AND p.brand = b.bid AND p.origin = o.oid AND im.pid = p.pid
GROUP BY imid
ORDER BY count DESC  
EOT;
        return DB::fetch_all($sql);
    }
    
    public function insert($uid,$pid){
        date_default_timezone_set('PRC');
        $now =  date('Y-m-d H:i:s',time());
        return parent::insert(array('uid' => $uid,'pid' => $pid,'add_time' => $now),true);
    }
    
    public function update($id,$uid,$pid){
        return parent::update($id,array('uid' => $uid,'pid' => $pid));
    }
    
    public function data($pid,$uid){
        return DB::fetch_first('SELECT * FROM ' . $this->_table . ' WHERE pid=' .$pid . ' AND uid=' .$uid);
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
    
    public function show_data($uid = 0,$order_by = 'point DESC'){
        $sql = <<<EOT
SELECT mid,b.uid,p.pid,pim.id as imid,p.name as name,o.value as oName,ifnull(round((e.taste + exterior + cost_performance) /3,2),0) as point
,pim.width,pim.length,pim.image,pim.size,pim.frontmark,pb.value as brand
FROM cigar_mybox as b
LEFT JOIN cigar_products_images as pim ON b.pid = pim.id
LEFT JOIN cigar_products as p ON pim.pid = p.pid
LEFT JOIN cigar_origins as o ON p.origin = o.oid
LEFT JOIN cigar_brands as pb ON p.brand = pb.bid
LEFT JOIN cigar_evaluates as e ON p.pid = e.pid AND e.uid = b.uid
WHERE 
b.uid = $uid
ORDER BY $order_by
EOT;
        return DB::fetch_all($sql);
    }
    
    public function simple_data($uid){
        
        $sql = <<<EOT
SELECT b.pid,im.frontmark as name,o.value as oName,im.width,im.length,im.image,make_mode,im.size
FROM cigar_mybox as b
LEFT JOIN cigar_products_images as im ON b.pid = im.id
LEFT JOIN cigar_products as p ON im.pid = p.pid
LEFT JOIN cigar_origins as o ON p.origin = o.oid
WHERE 
b.uid = $uid
EOT;
        return DB::fetch_all($sql);
    }

    
    public function _count($uid){
        $data = DB::fetch_first('SELECT count(1) as count FROM cigar_mybox WHERE uid =' . $uid);
        return $data && isset($data['count']) ? $data['count'] : 0;
            
    }
}

?>