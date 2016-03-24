<?php

define('IMAGE_INDEX_PATH', 'img/index/');
define('IMAGE_FOOT_PATH', 'img/foot/');
define('IMAGE_ABOUT_US', 'img/guanyuwomen/');
define('IMAGE_PRODUCT_PATH', 'img/product/');
define('IMAGE_REDWINE_PATH', 'img/product/redwine/');
define('IMAGE_SHOTS_PATH', 'images/big_shots/');
define('IMAGE_CULTURE_PATH', 'img/culture/');
/**
 * 雪茄文化 - 广告图文件夹
 * @var unknown
 */
define('IMAGE_CAD_PATH', 'images/ad/');

date_default_timezone_set('prc');
/**
 * 
 * @param unknown $filename
 * @param unknown $to  将在前面添加 '../' 前缀
 */
function upload_file($filename,$to){
    $to = '../' . $to;
    if ($_FILES[$filename]['error'] > 0){
        exit('#1144  Parameter Error: ' . $_FILES[$filename]['error']);
    }
    if (!empty($_FILES[$filename]['tmp_name'])){
        if (file_exists($to)){
//             @unlink($to);
            $path = $to;
            
            $fName = now_file_name();
            
            $dir = substr($path, 0,strrpos($path, '/')+1);
            
            $dir .= $fName;
            
            $dir .= substr($path, strrpos($path, '.'));
            $to = $dir;
        }
        if (!move_uploaded_file($_FILES[$filename]['tmp_name'], $to)){
            exit('ERROR #1145');
        }
    }else{
        exit('Parameter Error. #1146');
    }
    // 去掉最前面的 '../'
    return substr($to, 3);
}

/**
 * 
 * @return string
 */
function now_file_name(){
    return date('YmdHis',time());
}


/**
 * 
 */
function delete_action_image($path_array){
    foreach ($path_array as $path){
        if (!$path){
            continue;
        }
        $path = '../' . $path;
        if (file_exists($path)){
            @unlink($path);
        }
    }
}

/**
 * 检测是否存在这样一个主键值
 * @param string $table  表名
 * @param string $pk   主键值
 * @return boolean  true  存在，  false 不存在
 */
function record_exist($table,$pk){
    return count(C::t($table)->fetch($pk)) != 0 ;
}


function simple_query($post_data){

    
    $postdata = http_build_query($post_data);
    
    $opts = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context = stream_context_create($opts);
    $result = file_get_contents(dirname("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) . '/simple_query.php', true, $context);
//     return $result;
    return json_decode($result);
}



?>