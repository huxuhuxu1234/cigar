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
    if (! isset($_POST['uid']) || !isset($_POST['culture'])
        || !isset($_POST['is_up'])
        || !isset($_POST['point'])) {
        exit('Parameter Error #1');
    }
    
    $uid = $_POST['uid'];
    $culture = $_POST['culture'];
    $is_up = $_POST['is_up'];
    $point = $_POST['point'];
    
    if (!is_numeric($is_up) || !is_numeric($point) || !is_numeric($uid)|| !is_numeric($culture)){
        exit('Parameter Error #2');
    }
    
    //把数据保存到数据库
    C::t('cigar_culture_evaluates')->insert($culture,$uid,$is_up,$point);
    header('Location: culture_evaluates.php');
}

function del_data(){
    
    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    
    echo C::t('cigar_culture_evaluates')->delete_id_array($id_array);
    
}

function update_data()
{

        
        if (!isset($_POST['is_up'])
            || !isset($_POST['flag'])
            || !isset($_POST['point'])) {
                exit('Parameter Error #1');
        }

        $id = trim($_POST['flag']);
        $is_up = $_POST['is_up'];
        $point = $_POST['point'];

        if (!is_numeric($is_up) || !is_numeric($point) || !is_numeric($id)){
            exit('Parameter Error #2');
        }

        if (!record_exist('cigar_culture_evaluates', $id)){
            exit('Parameter Error #5');
        }
        


        //把数据保存到数据库
        C::t('cigar_culture_evaluates')->update($id,$is_up,$point);
        header('Location: culture_evaluates.php');
}

?>