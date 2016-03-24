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
    if (! isset($_POST['name']) || !isset($_POST['order'])) {
        exit('Parameter Error #1');
    }
    
    $name = $_POST['name'];
    $order = $_POST['order'];
    
    if (!is_numeric($order)){
        exit('Parameter Error #2');
    }

    //把数据保存到数据库
    C::t('cigar_culture_header')->insert($name,$order);
    header('Location: culture_header_manager.php');
}

function del_data(){
    

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    foreach ($id_array as $id){
        if(!C::t('cigar_culture')->check_delete('hid',$id)){
            exit('-1');
        }
    }
    
    echo C::t('cigar_culture_header')->delete_id_array($id_array);
    
}

function update_data()
{
    if (! isset($_POST['name']) || !isset($_POST['order']) || !isset($_POST['flag'])) {
        exit('Parameter Error #1');
    }

    $id = trim($_POST['flag']);
    $name = $_POST['name'];
    $order = $_POST['order'];

    if (!is_numeric($order) || !is_numeric($id)){
        exit('Parameter Error #2');
    }
    
    if (!record_exist('cigar_culture_header', $id)){
        exit('Parameter Error #5');
    }
    
    //把数据保存到数据库
    C::t('cigar_culture_header')->update($id,$name,$order);
    header('Location: culture_header_manager.php');
}

?>