<?php
    
//     print '1';
    //检测用户的有效性
    require_once '../source/class/class_core.php';
    
    $discuz = C::app();
    $discuz->init();
    
    global $_G;
    if ($_G['uid'] == 0 || $_G['adminid'] != 1){
        to_index();
    }
    
    function to_index(){
        header('Location: index.php');
        exit;
    }
    
?>