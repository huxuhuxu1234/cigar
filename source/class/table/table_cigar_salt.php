<?php

//cigar_salt

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_cigar_salt extends discuz_table
{

    public function __construct() {

        $this->_table = 'cigar_salt';

        parent::__construct();
    }


    public function insert($id,$code){
        $data = array(
            'id' => $id,
            'salt' => $code
        );
        parent::insert($data);
    }


    /**
     * 根据key 查询Id   如果搜索不到这个code 则返回-1
     * @param string $code
     * @return number
     */
    public function _get_id($code = ''){
        $id = DB::fetch_first('SELECT id FROM cigar_salt WHERE salt=\''.$code.'\'');
        if ($id){
            return (int)$id['id'];
        }
        return -1;
    }


}

?>