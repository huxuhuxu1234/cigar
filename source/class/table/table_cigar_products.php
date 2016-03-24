<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_products extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_products';
        $this->_pk    = 'pid';

        parent::__construct();
    }


    public function fetch_data_flag_admin($type){
    	if(!isset($type)){
    		$type = 1;
    	}
        $sql = <<<EOT
SELECT pid,cigar_types.`value` as `type`,cigar_products.type as tid,cigar_brands.`value` as brand,`name`,
width,`length`,cigar_origins.`value` as origin,make_mode,ext_prop 
FROM cigar_products,cigar_types,cigar_brands,cigar_origins 
where cigar_products.`type` = cigar_types.tid and cigar_products.brand = cigar_brands.bid and cigar_products.origin = cigar_origins.oid AND 
cigar_products.`type` = {$type}
EOT;
        return DB::fetch_all($sql);
    }
    
    public function fetch_cigar_name_by_pid($pid){
        if (!is_numeric($pid)){
            return '-1';
        }
        $sql = <<<EOT
SELECT `name` FROM cigar_products WHERE pid = $pid AND `type` = 1 
EOT;
        return DB::fetch_all($sql);
    }
    
    public function fetch_type_by_pid($pid){
        if (!is_numeric($pid)){
            return '-1';
        }
        $sql = <<<EOT
SELECT `type` FROM cigar_products WHERE pid = $pid
EOT;
        return DB::fetch_first($sql)['type'];
    }
    
    public function fetch($id){
        $sql = <<<EOT
SELECT pid,cigar_products.`type` as tid,cigar_products.brand as bid,`name`,width,`length`,cigar_products.origin as oid,
make_mode,ext_prop,image,price,consistence,
cigar_types.`value` as `type`,cigar_brands.`value` as brand,cigar_origins.`value` as origin
FROM cigar_products,cigar_types,cigar_brands,cigar_origins 
where cigar_products.`type` = cigar_types.tid and cigar_products.brand = cigar_brands.bid and cigar_products.origin = cigar_origins.oid 
AND pid = $id
EOT;
        return DB::fetch_first($sql);
    }
    
  public function insert($type,$brand,$name,$width,$length,$origin,$make_mode,$image,$ext_p,$price,$consistence = ''){
        $data = array(
            'type' => $type,
            'brand' => $brand,
            'name' => $name,
            'width' => $width,
            'length' => $length,
            'origin' => $origin,
            'make_mode' => $make_mode,
            'image' => $image,
            'ext_prop' => $ext_p,
            'price' => $price,
            'consistence' => $consistence
        );
        return parent::insert($data,true);
    }
    
    public function update($id,$type,$brand,$name,$width,$length,$origin,$make_mode,$image,$ext_p,$price,$consistence = ''){
        $data = array(
            'type' => $type,
            'brand' => $brand,
            'name' => $name,
            'width' => $width,
            'length' => $length,
            'origin' => $origin,
            'make_mode' => $make_mode,
            'ext_prop' => $ext_p,
            'price' => $price,
            'consistence' => $consistence
        );
        if ($image){
            $data['image'] = $image;
        }
        return parent::update($id,$data);
    }
    
    
    public function simple_cigar_data(){
        
        $tid = C::t('cigar_types')->first_id()['tid'];
        $sql = <<<EOT
SELECT p.pid as pid,p.`name` as `name`,b.`value` as brand,o.`value` as origin
FROM cigar_products as p,cigar_brands as b,cigar_origins as o
WHERE p.brand = b.bid AND p.origin = o.oid
AND p.`type` = $tid
EOT;
        
        return DB::fetch_all($sql);
        
    }
	
    public function simple_cigar_data_with_image(){
        
        $tid = C::t('cigar_types')->first_id()['tid'];
        $sql = <<<EOT
SELECT im.id as imid,p.pid as pid,p.`name` as `name`,b.`value` as brand,o.`value` as origin,
im.frontmark
FROM cigar_products as p,cigar_brands as b,cigar_origins as o,
cigar_products_images as im
WHERE p.brand = b.bid AND p.origin = o.oid
AND im.pid = p.pid
AND p.`type` = $tid
EOT;
        
        return DB::fetch_all($sql);
        
    }
    
    
    /**
     * 检测是否可以删除外键 
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete($type,$value){
        $sql = <<<EOT
SELECT pid FROM cigar_products WHERE `$type` = $value 
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
            $t = DB::delete($this->_table, 'pid = ' .$id );
            if ($t){
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
    
    public function _count($field = '',$v){
        $data = DB::fetch_first('SELECT count(1) as count FROM cigar_products WHERE ' . $field . ' = ' . $v);
        if ($data && isset($data['count'])){
            return $data['count'];
        }
        return 0;
    }
    
    public function page($page = 1,$brand = 0){
        $start_i = ($page - 1) * 8;
        
        $sql = <<<EOT
SELECT pid,name,image,ifnull(ext_prop,'') as ext_prop FROM cigar_products WHERE brand = $brand
LIMIT $start_i,8
EOT;
        return DB::fetch_all($sql);
    }
    
    public function select($type,$value){
        $sql = <<<EOT
        SELECT pid,cigar_types.`value` as `type`,`name`,width,`length`,cigar_origins.`value` as origin,make_mode,image,ifnull(ext_prop,'') as ext_prop,consistence
FROM cigar_products,cigar_types,cigar_origins
where cigar_products.`type` = cigar_types.tid and cigar_products.origin = cigar_origins.oid 
AND $type = $value
EOT;
        return DB::fetch_all($sql);
    }
    
    
    public function _cigar_filter($con){
        
        $sql = <<<EOT
SELECT pid,cigar_types.`value` as `type`,`name`,width,`length`,cigar_origins.`value` as origin,make_mode,image,ifnull(ext_prop,'') as ext_prop,consistence
FROM cigar_products,cigar_types,cigar_origins
WHERE cigar_products.`type` = cigar_types.tid AND cigar_products.origin = cigar_origins.oid AND cigar_products.`type` = 1
AND $con
EOT;
        return DB::fetch_all($sql);
    }
}


?>