<?php

require_once '../source/class/class_core.php';
C::app()->init();

global $_G;
if ($_G['uid'] == 0 || $_G['adminid'] != 1){
    exit('# 00000000');
}

// -1  错误退出
if (!isset($_POST['info'])){
    exit('-1');
}

switch ($_POST['info']){
    case 'name':
        show_name();
        break;
    case 'pname':
        show_pName();
        break;
    case 'uid':
        show_username();
        break;
    case 'username':
        show_uid();
        break;
    case 'culture_name':
        show_culture_name();
        break;
    case 'update':
        echo json_encode(get_update_value());
        break;
    default:
        exit('-1');
        break;
}

function show_name(){
    if (!isset($_POST['pid']) || !is_numeric($_POST['pid'])){
        exit('-1');
    }
    $result = C::t('cigar_products')->fetch_cigar_name_by_pid($_POST['pid']);
    echo $result[0]['name'];
}

function show_username(){
    if (!isset($_POST['uid']) || !is_numeric($_POST['uid'])){
        exit('-1');
    }
    
    $uid = $_POST['uid'];
    if (!is_numeric($uid)){
        exit('-1');
    }
    
    $result = C::t('common_member')->fetch_all_username_by_uid(array($uid));
    echo $result[$uid];
}

function show_uid(){
    
    if (!isset($_POST['username'])){
        exit('-1');
    }
    $result = C::t('common_member')->fetch_uid_by_username($_POST['username']);
    echo $result;
}

function get_update_value(){
    $map = array(
        'index_images' => 'cigar_images_index',
        'brand_manager' => 'cigar_brands',
        'about_us' => 'cigar_about',
        'shots_manager' => 'cigar_big_shots',
        'zhenwo_manage' => 'cigar_zhenwo',
        'culture' => 'cigar_culture',
        'culture_ad' => 'cigar_culture_ad',
        'culture_header' => 'cigar_culture_header',
        'evaluates' => 'cigar_evaluates',
        'box_manager' => 'cigar_mybox',
        'origin_manager' => 'cigar_origins',
        'products' => 'cigar_products',
        'box_groom_1_manager' => 'cigar_box_groom_1',
        'box_groom_2_manager' => 'cigar_box_groom_2',
        'products_detail' => 'cigar_products_detail',
        'redwine_detail' => 'cigar_redwine_detail',
        'station_manager' => 'cigar_stations',
        'box_groom_year' => 'cigar_box_groom_year',
        'box_commonage' => 'cigar_box_groom_commonage',
        'type_manager' => 'cigar_types',
        'culture_evaluates' => 'cigar_culture_evaluates',
        'foot_images' => 'cigar_footer',
        'filter' => 'cigar_filter',
        'group_limit' => 'cigar_box_limit_group',
        'search' => 'cigar_search',
        'activity' => 'cigar_activity',
        'suggestions_manager' => 'cigar_suggestions'
    );
    if (!isset($_POST['type']) || !isset($_POST['id']) || !isset($map[$_POST['type']])){
        return array('result' => '-1');
    }
    $type = $_POST['type'];
    
//     exit('' .$_POST['id']);
    $ret = C::t($map[$type])->fetch($_POST['id']);
    if (!$ret){
        return array('result' => '-2');
    }
    return $ret;
}

function show_culture_name(){
    
    if (!isset($_POST['cid'])){
        exit('-1');
    }
    $result = C::t('cigar_culture')->fetch($_POST['cid'])['title'];
    echo $result;
}

function show_pName(){
    if (!isset($_POST['pid'])){
        exit('-1');
    }
    $result = C::t('cigar_products')->fetch($_POST['pid'])['name'];
    echo $result;
}
?>