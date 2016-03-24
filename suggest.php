<?php

require_once 'source/class/class_core.php';

C::app()->init();

// header('Location: contact_us.php?tip=0');
if (!isset($_POST['name'])|| !isset($_POST['email'])|| !isset($_POST['title'])|| !isset($_POST['content']) ){
    header('Location: contact_us.php?tip=1');
    exit();
}

global $_G;
$uid = $_G['uid'];
$name = $_POST['name'];
$email = $_POST['email'];
$title = $_POST['title'];
$content = $_POST['content'];

//常见问题，举报不良信息，意见反馈，投诉侵权信息，商务合作，广告招商，品牌营销，新手上路，招聘求职
$type = '';
//exit($_POST['type'] == '9' . '');
switch($_POST['type']){
  case '1':
    $type = '常见问题';
    break;
  case '2':
    $type = '举报不良信息';
    break;
  case '3':
    $type = '意见反馈';
    break;
  case '4':
    $type = '投诉侵权信息';
    break;
  case '5':
    $type = '商务合作';
    break;
  case '6':
    $type = '广告招商';
    break;
  case '7':
    $type = '品牌营销';
    break;
  case '8':
    $type = '新手上路';
    break;
  case '9':
    $type = '招聘求职';
    break;

}

C::t('cigar_suggestions')->insert($uid,$name,$email,$title,$content,$type);

header('Location: contact_us.php?tip=0');

?>