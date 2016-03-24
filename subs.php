<?php

require_once 'rss.class.php';
require_once 'util.php';
require_once 'salt.php';
require_once 'source/class/class_core.php';

$webtitle = '雪茄文化 - ';
$webtitle .= $_MCONFIG['title'];
$rss = new RSS($webtitle, 'http://www.cigarcn.com/culture.php' ,$_MCONFIG['description']);

if(!isset($_GET['id'])){
	$rss->Display(); 
	exit('');
}

$id = $_GET['id'];


$data = C::t('cigar_culture')->fetch($id);

//exit($id . '');

if(!$data){
	$rss->Display(); 
	exit('');
}

$rss->AddItem($data['title'], "http://www.cigarcn.com/culture_content.php?id=" . $salt->encode(3,$id), 
	$data['description'], $data['publish_time']); 

$rss->Display(); 


?>