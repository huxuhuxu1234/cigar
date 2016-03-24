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
    if (! isset($_POST['rank']) || !isset($_POST['cigar']) || !isset($_POST['year']) ) {
        exit('Parameter Error #1');
    }
    
    $rank = $_POST['rank'];
    $pid = $_POST['cigar'];
    $year = $_POST['year'];
    

    //把数据保存到数据库
    C::t('cigar_box_groom_1')->insert($pid,$year,$rank);
    header('Location: box_groom_manager.php');
}

function del_data(){
    
    if (!isset($_POST['id_array'])){
        exit('Parameter Error #1');
    }
    
    $id_array = split(',', $_POST['id_array']);
    
    echo C::t('cigar_box_groom_1')->delete_id_array($id_array);
    
}

function update_data()
{
    if (! isset($_POST['rank']) || !isset($_POST['flag'])) {
        exit('Parameter Error #1');
    }

    $rank = $_POST['rank'];
    $id = trim($_POST['flag']);
    
    if (!is_numeric($id)){
        exit('Parameter Error #2');
    }
    

    if (!record_exist('cigar_box_groom_1', $id)){
        exit('Parameter Error #5');
    }

    //把数据保存到数据库
    C::t('cigar_box_groom_1')->update($id,$rank);
    header('Location: box_groom_manager.php');
}

?>