<?php

define('IN_CIGAR_UTIL', TRUE);

require_once 'source/class/class_core.php';
require_once 'admin/config.inc.php';

C::app()->init();

// 声明一些全局变量
$_TEMP = array();


/**
 * 输出 头部， 内容为 body标签下的
 */
function echo_header(){
    
    require 'template/header.php';
    
}

/**
 * 输出底部，内容为body标签下的
 */
function echo_footer(){
    
    require 'template/foot.php';
    
}

function echo_slide(){
    require 'template/slide.php';
}



/**
 * 输出首页转动的图片 内容大概为 <img src="**" w='**' h='**'/>
 * @param string $dir_prefix 目录前缀 默认为空
 */
function echo_index_rolling_images($dir_prefix = ''){

    $data = C::t('cigar_images_index')->fetch_data_path();
    
    foreach ($data as $row){
        $src = $dir_prefix . $row['path'];
        echo <<< EOT
     <a href="{$row['url']}" target="_blank" >
     <img class="item" id="item1" width="1000px" height="612px" src="$src"/>   </a>
EOT;
    }
    
}

/**
 * 输出首页轮播图的脚本内容  不包括 <script>标签
 */
function echo_index_rolling_images_script(){
    
    $data = C::t('cigar_images_index')->fetch_data_time();
    $time_map = array();
    $i = 0;
    foreach ($data as $row){
        $time_map[$i++] = $row['show_time'];
    }
    
    echo <<<EOT
    var time_map = new Array();
	time_map[0] = {$time_map[0]} * 1000;
	time_map[1] = {$time_map[1]} * 1000;
	time_map[2] = {$time_map[2]} * 1000;
	
	var img__index= 0; 
	var time_out_f = undefined;
	var next_turn = true;
	
	function roll(){
		
		if(!next_turn){
			return;
		}
		if(img__index >= time_map.length){
			img__index = 0;
		}
		
		time_out_f = setTimeout(function(){
			_banner_click2();
			next_turn = true;
		},time_map[img__index]);
		
		next_turn = false;
		img__index++;
	}
	var rolling = setInterval(roll,100);
	
	$(function(){

		$('div[class=img_list] .item').each(function(){
			//鼠标放上去就停止滑动
			$(this).mousemove(function(){
				if(rolling){
					clearInterval(rolling);
					rolling = undefined;
				}
				if(time_out_f){
					clearTimeout(time_out_f);
					time_out_f = undefined;
				}
			});
			$(this).mouseout(function(){
				rolling = setInterval(roll,100);
				next_turn = true;
			});
		});
	});	
EOT;
    
}



/**
 * 输出底部坐标的图片  带链接
 * @param string $dir_prefix  目录前缀
 */
function  echo_foot_left_img($dir_prefix = ''){
    
    $data = C::t('cigar_footer')->fetch_data_left()[0];
    $path = $dir_prefix . $data['image'];
    echo <<<EOT
    <a href="{$data['url']}"><img src="$path" width="275px" height="175px"/></a>
EOT;
}

function  echo_foot_right_img($dir_prefix = ''){
    $data = C::t('cigar_footer')->fetch_data_right()[0];
    $path = $dir_prefix . $data['image'];
    echo <<<EOT
    <a href="{$data['url']}"><img src="$path" width="275px" height="175px"/></a>
EOT;
}


function echo_foot_middle_img($dir_prefix = ''){
    
    $data = C::t('cigar_footer')->fetch_data_middle();
    foreach ($data as $row){
        $path = $dir_prefix . $row['image'];
        echo <<<EOT
    <a href="{$row['url']}"><img class="me_img" id="me_img1" src="$path" width="275px" height="175px"/></a>
EOT;
    }
}


function echo_web_keywords_and_descr(){
    global $_MCONFIG;
    echo <<<EOT
    <meta name="keywords" content="{$_MCONFIG['keywords']}" />
    <meta name="description" content="{$_MCONFIG['description']}" />
EOT;
}


function get_about_us_(){
    return C::t('cigar_about')->fetch_data();
}


/**
 * 查询用户的 雪茄盒数量限制
 * @return number
 */
function box_limit(){
  global $_G;
//   error_log(print_r($_G,true));
  if ($_G['uid'] == 0){
      return 0;
  }
  $num = 0;
  $data = C::t('cigar_box_limit_group')->fetch($_G['groupid']);
  $num += ($data && isset($data['limit']) ? $data['limit'] : 0);
  $data = C::t('cigar_box_limit')->fetch($_G['uid']);
  $num += $data && isset($data['limit']) ? $data['limit'] : 0;
  return $num;  
}

function data_count($data,$pageNum){
    if (!is_array($data)){
        return  -1;
    }
    $count = count($data);
    //exit('count: ' . $count);
    return $count % $pageNum == 0 ? $count / $pageNum : intval($count / $pageNum + 1);
}

function util_page($data,$page,$pageNum){
    if (!is_array($data)){
        return  FALSE;
    }
    $ret = array();
    $start = ($page-1) * $pageNum;
    $count = count($data);
    for ($i = 0; $i < $pageNum; $i++){
        $t = $start + $i;
        if ($t >= $count){
            break;
        }
        $ret[$i] = $data[$t];
    }
    return $ret;
}

/**
 * 字符串截取
 *
 */
function sub_str($str, $length = 0)
{
    $newstr = mb_strlen($str, 'utf-8') > $length ? mb_substr($str, 0, $length, 'utf-8').'....' : $str;
 
    return $newstr;
}

?>