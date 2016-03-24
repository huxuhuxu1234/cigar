<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_culture_evaluates extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_culture_evaluates';
        $this->_pk    = 'ceid';

        parent::__construct();
    }


    public function fetch_data(){
        return DB::fetch_all('SELECT * FROM cigar_culture_evaluates ');
    }
    
    public function fetch_data_flag_admin(){
        $sql = <<<EOT
SELECT ceid,c.cid,title,ce.uid,username,is_up,`point`
FROM cigar_culture as c,cigar_culture_evaluates as ce,pre_common_member as m
WHERE c.cid = ce.cid AND ce.uid = m.uid
EOT;
        return DB::fetch_all($sql);
    }

    public function insert($cid,$uid,$is_up,$point){
        $data = array(
            'cid' => $cid,
            'uid' => $uid,
            'is_up' => $is_up,
            'point' => $point
        );
        return parent::insert($data,true);
    }

    public function update($id,$is_up,$point){
        $data = array(
            'is_up' => $is_up,
            'point' => $point
        );
        return parent::update($id,$data);
    }

    /**
     * 检测是否可以删除外键
     * @param unknown $value
     * @param unknown $type
     * @return string|boolean  true : 可以删除, false: 不能删除
     */
    public function check_delete($type,$value){
        $table = $this->_table;
        $pk = $this->_pk;
        $sql = <<<EOT
SELECT $pk FROM $table WHERE `$type` = $value
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
    
    public function delete_cultrue($cid){
        return DB::delete($this->_table, 'cid = ' . $cid);
    }

    /**
     * 获取一个用户的评价信息
     * @param number $uid
     * @param number $cid
     */
    public function evaluate_data($uid = 0, $cid = 0){
        return DB::fetch_first('SELECT is_up,point FROM cigar_culture_evaluates WHERE cid='.$cid.' AND uid='.$uid);
    }
    
    /**
     * 获取平均分和 评论次数
     * @param number $cid  文章id
     * @return unkown
     */
    public function evaluate_count_and_avg($cid = 0){
        return DB::fetch_first('SELECT count(1) as count,ifnull(round(avg(point),2),0) as point FROM cigar_culture_evaluates WHERE cid='.$cid);
    }

    
    public function ev_point($cid,$uid,$point,$ceid = -1){
        $command = '';
        $where = '';
        if ($ceid == -1){
            $command = 'INSERT INTO ';
        }else{
            $command = 'UPDATE ';
            $where = ' WHERE ceid=' . $ceid;
        }
        $sql = <<<EOT
cigar_culture_evaluates SET cid=$cid, uid=$uid, point=$point
EOT;
        return DB::query($command . $sql . $where);
    }
    
    public function _get_ceid($uid,$cid){
        $sql = <<<EOT
SELECT ceid FROM cigar_culture_evaluates WHERE cid=$cid AND uid=$uid
EOT;
        return DB::fetch_first($sql);
    }
    
    public function ev_up($op,$cid,$uid,$ceid = -1){
        if(!isset($cid) || $cid == -1 || !isset($uid) || $uid == -1){
            return FALSE;            
        }
        $command = '';
        $where = '';
        if ($ceid == -1){
            $command = 'INSERT INTO ';
        }else{
            $command = 'UPDATE ';
            $where = ' WHERE ceid=' . $ceid;
        }
        $sql = <<<EOT
cigar_culture_evaluates SET is_up = $op , cid = $cid , uid = $uid
EOT;
        return DB::query($command . $sql . $where);
    }
    
    
    
}

?>