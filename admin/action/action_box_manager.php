<?php
if (! defined('IN_ACTION')) {
    exit('Access Denied');
}

if (! isset($_GET['handle'])) {
    exit('Parameter Error #0');
}

switch ($_GET['handle']) {
    case 'add':
        add_data();
        break;
    case 'del':
        del_data();
        break;
    case 'update':
        update_data();
        break;
}

function add_data()
{
    if (! isset($_POST['uid']) || !isset($_POST['cigar'])) {
        exit('Parameter Error #1');
    }
    
    $uid = $_POST['uid'];
    $pid = $_POST['cigar'];
    

    //把数据保存到数据库
    C::t('cigar_mybox')->insert($uid,$pid);
    header('Location: box_manager.php');
}

function del_data(){
    
    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    
    echo C::t('cigar_mybox')->delete_id_array($id_array);
    
}

function update_data()
{
    if (! isset($_POST['uid']) || !isset($_POST['cigar'])  || !isset($_POST['flag'])) {
        exit('Parameter Error #1');
    }

    $uid = $_POST['uid'];
    $pid = $_POST['cigar'];
    $id = trim($_POST['flag']);
    
    if (!is_numeric($id)){
        exit('Parameter Error #2');
    }
    

    if (!record_exist('cigar_mybox', $id)){
        exit('Parameter Error #5');
    }

    //把数据保存到数据库
    C::t('cigar_mybox')->update($id,$uid,$pid);
    header('Location: box_manager.php');
}

?>