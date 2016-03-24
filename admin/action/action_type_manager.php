<?php
if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

if (! isset($_GET['handle'])) {
    exit('Parameter Error #0');
}

switch ($_GET['handle']) {
    case 'update':
        update_data();
        break;
}

function update_data(){
    
    if (! isset($_POST['name']) || !isset($_POST['flag'])) {
        exit('Parameter Error #1');
    }
    
    $name = $_POST['name'];
    $id = trim($_POST['flag']);
    
    if (!is_numeric($id)){
        exit('Parameter Error #2');
    }
    
    if (!record_exist('cigar_types', $id)){
        exit('Parameter Error #5');
    }
    
    //把数据保存到数据库
    C::t('cigar_types')->update($id,$name);
    header('Location: brand_manager.php');
}

?>