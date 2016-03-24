<?php
if (! defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_products_detail extends discuz_table
{

    public function __construct()
    {
        $this->_table = 'cigar_products_detail';
        $this->_pk = 'pid';
        
        parent::__construct();
    }

    public function insert($pid, $description, $reliability, $evaluate_count, $taste, $exterior, $cost_performance, $image)
    {
        $data = array(
            'pid' => $pid,
            'description' => $description ,
            'reliability' => $reliability,
            'evaluate_count' => $evaluate_count,
            'taste' => $taste,
            'exterior' => $exterior,
            'cost_performance' => $cost_performance,
            'image' => $image 
        );
        return parent::insert($data,true);
    }
    
    public function update($pid, $description, $reliability, $evaluate_count, $taste, $exterior, $cost_performance,$image)
    {
        $data = array(
            'description' => $description ,
            'reliability' => $reliability,
            'evaluate_count' => $evaluate_count,
            'taste' => $taste,
            'exterior' => $exterior,
            'cost_performance' => $cost_performance,
        );
        if (isset($image) && !empty($image)){
            $data['image'] = $image; 
        }
        return parent::update($pid,$data);
    }
    
    public function pid_data($pid = 0){

        return DB::fetch_first('SELECT * FROM ' . $this->_table . ' WHERE pid=' . $pid);
        
    }
    
    
    /**
     * 检测是否可以删除外键
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete_pid($pid){
        $sql = <<<EOT
SELECT pid FROM cigar_products_detail WHERE pid = $pid
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
}

?>