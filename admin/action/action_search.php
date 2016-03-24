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
    if (!isset($_POST['word']) || !isset($_POST['condition'])) {
        exit('Parameter Error #1');
    }

    $name = $_POST['word'];
    $type = $_POST['condition'];

    //把数据保存到数据库
    C::t('cigar_search')->insert($name,$type);
    header('Location: search_.php');
}

function del_data(){

    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }

    $id_array = split(',', $_POST['id_array']);

    echo C::t('cigar_search')->delete_id_array($id_array);
}

function update_data(){

    if (! isset($_POST['word']) || !isset($_POST['flag']) || !isset($_POST['condition'])) {
        exit('Parameter Error #1');
    }

    $name = $_POST['word'];
    $id = trim($_POST['flag']);
    $type = $_POST['condition'];

    if (!is_numeric($id)){
        exit('Parameter Error #2');
    }

    //把数据保存到数据库
    C::t('cigar_search')->update($id,$name,$type);
    header('Location: search_.php');
}


?>