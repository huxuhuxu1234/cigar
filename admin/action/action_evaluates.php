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
    if (! isset($_POST['uid']) || !isset($_POST['pid'])
        || !isset($_POST['taste'])
        || !isset($_POST['cost_performance'])
        || !isset($_POST['exterior'])) {
        exit('Parameter Error #1');
    }
    
    $uid = $_POST['uid'];
    $pid = $_POST['pid'];
    $taste = $_POST['taste'];
    $exterior = $_POST['exterior'];
    $cost_performance = $_POST['cost_performance'];
    
    if (!is_numeric($pid) || !is_numeric($taste) || !is_numeric($uid)|| !is_numeric($exterior) || !is_numeric($cost_performance)){
        exit('Parameter Error #2');
    }
    
    //把数据保存到数据库
    C::t('cigar_evaluates')->insert($pid,$uid,$taste,$exterior,$cost_performance,$_POST['content']);
    header('Location: evaluates.php');
}

function del_data(){
    
    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    
    echo C::t('cigar_evaluates')->delete_id_array($id_array);
    
}

function update_data()
{

        
        if (!isset($_POST['taste'])
            || !isset($_POST['flag'])
            || !isset($_POST['cost_performance'])
            || !isset($_POST['content'])
            || !isset($_POST['exterior'])) {
                exit('Parameter Error #1');
        }
    
        $taste = $_POST['taste'];
        $exterior = $_POST['exterior'];
        $content = $_POST['content'];
        $cost_performance = $_POST['cost_performance'];
        $id = trim($_POST['flag']);
        

        if ( !is_numeric($taste) || !is_numeric($exterior) || !is_numeric($cost_performance) ){
            exit('Parameter Error #2');
        }

        if (!record_exist('cigar_evaluates', $id)){
            exit('Parameter Error #5');
        }

        //把数据保存到数据库
        C::t('cigar_evaluates')->update($id,$taste,$exterior,$cost_performance,$content);
        header('Location: evaluates.php');
}

?>