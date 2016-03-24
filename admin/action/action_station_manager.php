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
    if (! isset($_POST['name'])) {
        exit('Parameter Error #1');
    }
    
    $name = $_POST['name'];
    

    //把数据保存到数据库
    C::t('cigar_stations')->insert($name);
    header('Location: station_manager.php');
}

function del_data(){
    

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    foreach ($id_array as $id){
        if(!C::t('cigar_big_shots')->check_delete('station',$id)){
            exit('-1');
        }
    }
    
    echo C::t('cigar_stations')->delete_id_array($id_array);
    
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


    if (!record_exist('cigar_stations', $id)){
        exit('Parameter Error #5');
    }

    //把数据保存到数据库
    C::t('cigar_stations')->update($id,$name);
    header('Location: station_manager.php');
}

?>