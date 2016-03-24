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
    if (!isset($_POST['title']) || !isset($_POST['url']) || !isset($_POST['content'])) {
        exit('Parameter Error #1');
    }

    $url = $_POST['url'];
    $name = $_POST['title'];
    $type = $_POST['content'];

    
    //把数据保存到数据库
    C::t('cigar_activity')->insert($name,$url,$type);
    header('Location: activity.php');
}

function del_data(){

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }

    $id_array = split(',', $_POST['id_array']);

    echo C::t('cigar_activity')->delete_id_array($id_array);
}

function update_data(){

    if (!isset($_POST['title']) || !isset($_POST['url']) || !isset($_POST['content'])) {
        exit('Parameter Error #1');
    }

    $url = $_POST['url'];
    $name = $_POST['title'];
    $id = trim($_POST['flag']);
    $type = $_POST['content'];

    if (!is_numeric($id)){
        exit('Parameter Error #2');
    }

    //把数据保存到数据库
    C::t('cigar_activity')->update($id,$name,$url,$type);
    header('Location: activity.php');
}


?>