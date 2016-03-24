<?php 

class salt{
    /**
     * 初始化，不用每次都call 这个方法
     */
    public function init(){
        define('IN_SALT', TRUE);
        
        require_once 'source/class/class_core.php';
        require 'salt.inc.php';
        
        C::app()->init();
        
        //$now = time();
        //if (($now - $lastUpdateKeyTime) / 60 / 60 / 24 > 7 ){
            //更新key值
            //$rand = md5(time() . mt_rand(0,1000));
            //self::update_inc_file(time(), substr($rand, 0,8));
            
            //清空salt表
            //C::t('cigar_salt')->truncate();
        //}
        
    }
    
    /**
     * 对 $id 进行加密
     * 
     * type:
     *   1 -> 产品,
     *   2 -> 雪茄大咖,
     *   3 -> 雪茄文化
     * @param number $type
     * @param number $id
     * @return string
     */
    public function encode($type = 0,$id = 0){
        self::init();
        require 'salt.inc.php';
        require_once 'source/class/class_core.php';
        
        C::app()->init();
        
        $code = substr(md5($type . $key . $id ), 0,8);
        if (C::t('cigar_salt')->_get_id($code) == -1){
            C::t('cigar_salt')->insert($id,$code);
        }
        return $code;
        
    }
    
    
    /**
     * 对$code 进行解密  解密失败则返回-1
     * @param string $code
     */
    public function decode($code = ''){
        require_once 'source/class/class_core.php';
        C::app()->init();
        
        return C::t('cigar_salt')->_get_id($code);
    }
    
    
    
    function update_inc_file($t,$k){
        $data = <<<EOT
<?php

if(!defined('IN_SALT')){
    header('Location: ./');
    exit(1);
}

\$lastUpdateKeyTime = $t;
\$key = '$k';

?>
EOT;
        file_put_contents('salt.inc.php', $data);
    }
}

$salt = new salt();

?>