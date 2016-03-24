<?php
// 处理各种后台操作 

/* header('Content-type: text/plain;charset=utf-8');
 echo '<pre>';
 print_r($_POST);
 print_r($_FILES);
 exit();*/

//检测用户的有效性
require 'check_user_avail.php';

require_once 'util.php';

if (!isset($_GET['action'])){
    header('Location: index.php');
    exit;
}

define('IN_ACTION', true);

$action = $_GET['action'];
// print $action;

switch ($action){
    case 'update_base_set':
    case 'index_images':
    case 'foot_images':
    case 'brand_manager':
    case 'origin_manager':
    case 'culture_header':
    case 'box_groom_year':
    case 'box_commonage':
    case 'box_groom_1_manager':
    case 'box_groom_2_manager':
    case 'station_manager':
    case 'shots_manager':
    case 'type_manager':
    case 'culture_groom':
    case 'culture_evaluates':
    case 'about_us':
    case 'evaluates':
    case 'filter':
    case 'activity':
    case 'search':
    case 'culture':
    case 'culture_ad':
    case 'products_manager':
    case 'contact':
    case 'group_limit':
    case 'zhenwo_manage':
    case 'box_manager':
    case 'suggestions_manager':
        include 'action/action_' .$action . '.php';
        break;
    default:
        exit('Action Error.');
}


?>