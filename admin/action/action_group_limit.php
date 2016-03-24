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
    if (! isset($_POST['groupid']) || ! isset($_POST['limit'])) {
        exit('Parameter Error #1');
    }
    
    $groupid = $_POST['groupid'];
    $limit = $_POST['limit'];
    

    //把数据保存到数据库
    C::t('cigar_box_limit_group')->insert($groupid,$limit);
    header('Location: group_box_limit.php');
}

function del_data(){
    

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);

    
    echo C::t('cigar_box_limit_group')->delete_id_array($id_array);
    
}

function update_data(){

    if ( ! isset($_POST['limit']) || !isset($_POST['flag'])) {
        exit('Parameter Error #1');
    }

    $id = trim($_POST['flag']);
    $limit = $_POST['limit'];

    if (!is_numeric($id)){
        exit('Parameter Error #2');
    }


    //把数据保存到数据库
    C::t('cigar_box_limit_group')->update($id,$limit);
    header('Location: group_box_limit.php');
}

?>