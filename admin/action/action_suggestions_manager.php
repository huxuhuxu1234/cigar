<?php
if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

if (! isset($_GET['handle'])) {
    exit('Parameter Error #0');
}

switch ($_GET['handle']) {
    case 'del':
        del_data();
        break;
}

function del_data(){

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    
    
    $id_array = split(',', $_POST['id_array']);
    
    echo C::t('cigar_suggestions')->delete_id_array($id_array);
    
}

?>