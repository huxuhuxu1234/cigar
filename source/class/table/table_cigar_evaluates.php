<?php

if (! defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_evaluates extends discuz_table
{

    public function __construct()
    {
        $this->_table = 'cigar_evaluates';
        $this->_pk = 'eid';

        parent::__construct();
    }
    
    
    public function delete_pid_array($id_array){
        $ret = 0;
        foreach ($id_array as $id){
            $ret .= DB::delete($this->_table, DB::field('pid', $id), null);
        }
		return $ret;
    }
    
    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_evaluates');
    }
    
    public function fetch_data_flag_admin(){
        $sql = <<<EOT
SELECT eid,e.pid,p.`name`,p.type,e.uid,username,taste,exterior,cost_performance,content
FROM cigar_evaluates as e,cigar_products as p ,pre_common_member as m
WHERE e.pid = p.pid AND e.uid = m.uid
EOT;
        return DB::fetch_all($sql);
    }
    
    public function like_redwine($pid){
        $data = DB::fetch_first('SELECT count(1) as count FROM ' . $this->_table . ' WHERE content = \'1\' AND pid=' . $pid);
        if ($data && isset($data['count'])){
            return (int)$data['count'];
        }        
        return 0;
    }
    
    public function insert($pid,$uid,$taste,$exterior,$cost_performance,$content){
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
        $data = array(
            'pid' => $pid,
            'uid' => $uid,
            'taste' => $taste,
            'exterior' => $exterior,
            'cost_performance' => $cost_performance,
            'publish_time' => $now,
            'content' => $content 
        );
        return parent::insert($data,true);
    }
    
    public function update($id,$taste,$exterior,$cost_performance,$content){
        date_default_timezone_set("PRC");
        $now =  date('Y-m-d H:i:s',time());
        $data = array(
            'taste' => $taste,
            'exterior' => $exterior,
            'cost_performance' => $cost_performance,
            'content' => $content,
            'publish_time' => $now
        );
        return parent::update($id,$data);
    }
    
    public function _update($id,$key,$value){
        $sql = <<<EOT
UPDATE {$this->_table} SET $key = '$value',publish_time = now()
WHERE eid=$id
EOT;
        return DB::query($sql);
    }
    
    public function ev_data($pid,$uid){
        
        $sql = <<<EOT
SELECT * FROM {$this->_table} WHERE pid=$pid AND uid=$uid;
EOT;
        return DB::fetch_first($sql);
    }
    
    public function delete_pid($pid){
        return DB::delete($this->_table, 'pid = ' . $pid);
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
     * 获取某个总共个有多少页
     */
    public function pageCount($pid = 0){
        $count = self::_count($pid);
        return $count %5 == 0 ? $count / 5 : intval($count / 5 + 1);
    }
    
    
    public function _count($pid){
        $data = DB::fetch_first('SELECT count(1) as count FROM cigar_evaluates WHERE pid=' . $pid);
        if (!$data || !isset($data['count'])){
            return 0;
        }
        return $data['count'];
    }
    
    public function _avg($pid,$field){
        $sql = <<<EOT
SELECT ifnull(round( avg($field),2),0) as $field FROM cigar_evaluates WHERE pid=$pid
EOT;
        $data = DB::fetch_first($sql);
        if (!$data || !isset($data[$field])){
            return 0;
        }        
        return $data[$field];
    }
    
    /**
     * 获取某一页的大咖信息
     *
     * 注：  一页5个信息
     * @param number $index
     */
    public function page($index = 1,$pid = 0){
        //最小限制
        $s_limit = ($index-1) * 5;
        $sql = <<<EOT
SELECT username,content,publish_time,(taste+exterior+cost_performance) / 3 as point
FROM cigar_evaluates as e
left join pre_common_member as m on m.uid = e.uid
WHERE pid = $pid
ORDER BY publish_time DESC
LIMIT $s_limit,5
EOT;
        return DB::fetch_all($sql);
    }
}
?>