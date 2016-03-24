<?php

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

require_once DISCUZ_ROOT . './source/class/class_core.php';
require_once DISCUZ_ROOT . 'util.php';

$most_point_members = C::t('common_member')->fetch_all_stat_memberlist('','credits','desc',0,7);
$newest_member = C::t('common_member')->fetch_all_stat_memberlist('','regdate','desc',0,7);



?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta name="keywords" content="<?php if(!empty($metakeywords)) { echo dhtmlspecialchars($metakeywords); } ?>" />
<meta name="description" content="<?php if(!empty($metadescription)) { echo dhtmlspecialchars($metadescription); ?> <?php } if(empty($nobbname)) { ?>,<?php echo $_G['setting']['bbname'];?><?php } ?>" />

<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?> - <?php } if(empty($nobbname)) { ?> <?php echo $_G['setting']['bbname'];?> - <?php } ?> 雪茄中国</title>
<!-- 雪茄中国部分  -->
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/top.css"/>
<link rel="stylesheet" type="text/css" href="css/discuz.css"/>
<link rel="stylesheet" type="text/css" href="css/foot.css"/>


<script type="text/javascript">

var flag = 1;

$(function(){
	$(".first_part_middle .first_line ul li").click(function(){
		var flag = parseInt($(this).attr("rel")) ;
		switch (flag){
			case 0:
				$(".index1").show();
				$(".index2").hide();
				$(".index3").hide();
				$(".index4").hide();
				$(".index5").hide();
				$(".xiahuaxian").animate({
					left: '0px'
				}, 100);
				$(".first_part_middle .first_line .biaotiactive,.first_part_middle .first_line .biaoti").attr("class","biaoti");
				$(this).attr("class","biaotiactive");
				break;
			case 1:
				$(".index1").hide();
				$(".index2").show();
				$(".index3").hide();
				$(".index4").hide();
				$(".index5").hide();
				$(".xiahuaxian").animate({
					left: '81px'
				}, 100);
				$(".first_part_middle .first_line .biaotiactive,.first_part_middle .first_line .biaoti").attr("class","biaoti");
				$(this).attr("class","biaotiactive");
				break;
			case 2:
				$(".index1").hide();
				$(".index2").hide();
				$(".index3").show();
				$(".index4").hide();
				$(".index5").hide();
				$(".xiahuaxian").animate({
					left: '162px'
				}, 100);
				$(".first_part_middle .first_line .biaotiactive,.first_part_middle .first_line .biaoti").attr("class","biaoti");
				$(this).attr("class","biaotiactive");
				break;
			case 3:
				$(".index1").hide();
				$(".index2").hide();
				$(".index3").hide();
				$(".index4").show();
				$(".index5").hide();
				$(".xiahuaxian").animate({
					left: '243px'
				}, 100);
				$(".first_part_middle .first_line .biaotiactive,.first_part_middle .first_line .biaoti").attr("class","biaoti");
				$(this).attr("class","biaotiactive");
				break;
			case 4:
				$(".index1").hide();
				$(".index2").hide();
				$(".index3").hide();
				$(".index4").hide();
				$(".index5").show();
				$(".xiahuaxian").animate({
					left: '324px'
				}, 100);
				$(".first_part_middle .first_line .biaotiactive,.first_part_middle .first_line .biaoti").attr("class","biaoti");
				$(this).attr("class","biaotiactive");
				break;
			default:
				break;
		}
	})



	$(".first_part_right .top .top_left,.first_part_right .top .top_left_bad").click(function(){
		$(".first_part_right .top .top_left_bad").attr("class","top_left");
		$(".first_part_right .top .top_right_active").attr("class","top_right");
		$(".first_part_right .middle .middle_index1").show();
		$(".first_part_right .middle .middle_index2").hide();
	})
	
	
	$(".first_part_right .top .top_right,.first_part_right .top .top_right_active").click(function(){
		$(".first_part_right .top .top_right").attr("class","top_right_active");
		$(".first_part_right .top .top_left").attr("class","top_left_bad");
		$(".first_part_right .middle .middle_index1").hide();
		$(".first_part_right .middle .middle_index2").show();
	})



	setInterval(move,5000);
	$(".first_part_left .lunbo_tupian,.first_part_left .lunbo_tupian_ac").click(function(){
		flag = parseInt($(this).attr("rel"));
		$(".lunbo").stop().animate({
			left: -300 * (flag-1) + "px"
		}, 1000);
		$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
		$(this).attr("class","lunbo_tupian_ac");
		$('#roll_img_text').html(word_array[flag]);
	});


	$('#roll_img_text').html(word_array[flag]);
	
});

var word_array = new Array();

<?php 
	    
	    $now_i = 1;
	    
	    if(is_array($grids['slide']))
	        foreach ($grids['slide'] as $thread){
	    
	        echo <<<EOT
word_array[$now_i] = '{$thread['subject']}';
EOT;
	    
	        if (++$now_i > 8){
	            break;
	        }
	    
	    }
	    
	    
?>



function move() {
	var num = $(".content_body").length;
	if (flag <= num) {
		$(".lunbo").stop().animate({
			left: -300 * flag + "px"
		}, 1000);
		flag = flag +1 ;
	}  else {
		flag = 1;
		$(".lunbo").css("left","0px");
	}
	$('#roll_img_text').html(word_array[flag]);
	switch (flag){
		case 1:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned1").attr("class","lunbo_tupian_ac");
			break;
		case 2:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned2").attr("class","lunbo_tupian_ac");
			break;
		case 3:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned3").attr("class","lunbo_tupian_ac");
			break;
		case 4:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned4").attr("class","lunbo_tupian_ac");
			break;
		case 5:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned5").attr("class","lunbo_tupian_ac");
			break;
		case 6:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned6").attr("class","lunbo_tupian_ac");
			break;
		case 7:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned7").attr("class","lunbo_tupian_ac");	
			break;
		case 8:
			$(".lunbo_tupian,.lunbo_tupian_ac").attr("class","lunbo_tupian");
			$("#special_ned8").attr("class","lunbo_tupian_ac");
			break;
		default:
			break;
	}
}

</script>

</head>

<body>
<?php echo_header();?>

		<div class="banner_bag">
			<div class="banner_bag_top">
				<div class="banner_bag_top_list">
					<a href="./" class="banner_bag_top_a">首页</a>&nbsp;>&nbsp;
					<a href="discuz.php" class="banner_bag_top_a">论坛</a>
				</div>
			</div>
			
			
			<div class="banner_bag_main">
			
			
			<div class="first_part">
					<div class="first_part_left">
						<!--第一行图片模块上方数字-->
						<div class="lunbo">
						    <?php 
						    
						    $now_i = 1;
						    
						    if(is_array($grids['slide']))
						        foreach ($grids['slide'] as $thread){
						    
						        echo <<<EOT
<a href="{$thread['url']}"><img class="content_body" width="300px" height="280px" src="{$thread['image']}" /></a>
EOT;
						    
						        if (++$now_i > 8){
						            break;
						        }
						    
						    }
						    
						    
						    ?>
							
						</div>
						
						<ul>
							<li class="lunbo_tupian_ac" id="special_ned1" rel="1">1</li>
							<li class="lunbo_tupian" id="special_ned2" rel="2">2</li>
							<li class="lunbo_tupian" id="special_ned3" rel="3">3</li>
							<li class="lunbo_tupian" id="special_ned4" rel="4">4</li>
							<li class="lunbo_tupian" id="special_ned5" rel="5">5</li>
							<li class="lunbo_tupian" id="special_ned6" rel="6">6</li>
							<li class="lunbo_tupian" id="special_ned7" rel="7">7</li>
							<li class="lunbo_tupian" id="special_ned8" rel="8">8</li>
						</ul>
						<div class="first_part_left_bottom" id="roll_img_text">1</div>
					</div>
					<div class="first_part_middle">
						<div class="first_line">
							<ul>
								<li class="biaotiactive" rel="0">最新帖子</li>
								<li class="biaoti" rel="1">最新回复</li>
								<li class="biaoti" rel="2">精华主题</li>
								<li class="biaoti" rel="3">热门主题</li>
								
							</ul>
							<div class="bottom1">
								<img class="xiahuaxian" src="img/luntan/xiahuaxian3.png" />
							</div>
						</div>
						<div class="second_line">
							<div>
								<ul class="index1">
								    
								    <?php 
								    $now_i = 1;
								    
								    if(is_array($grids['newthread']))
								        foreach ($grids['newthread'] as $thread){
								            
								            echo <<<EOT
<li>
	<div class="second_line_content_1">$now_i</div>
	<a href="forum.php?mod=viewthread&tid={$thread['tid']}">
		<div class="second_line_content_2">{$thread['subject']}</div>
	</a>
	<div class="second_line_content_3"><a href="home.php?mod=space&uid={$thread['authorid']}">{$thread['author']}</a></div>
</li>
EOT;
								        
								            if (++$now_i > 8){
								                break;
								            }
								        
								        }
								    
								    
								    ?>
									
								</ul>
							
								<ul class="index2">
								
								    <?php 
								    
								    //newreply
								    $now_i = 1;
								    
								    if(is_array($grids['newreply']))
								        foreach ($grids['newreply'] as $thread){
								    
								        echo <<<EOT
<li>
	<div class="second_line_content_1">$now_i</div>
	<a href="forum.php?mod=viewthread&tid={$thread['tid']}">
		<div class="second_line_content_2">{$thread['subject']}</div>
	</a>
	<div class="second_line_content_3"><a href="home.php?mod=space&uid={$thread['authorid']}">{$thread['author']}</a></div>
</li>
EOT;
								    
								        if (++$now_i > 8){
								            break;
								        }
								    
								    }
								    
								    
								    ?>
									
								</ul>
								
								<ul class="index3">
								    <?php 
								    
								    //digest
								    $now_i = 1;
								    
								    if(is_array($grids['digest']))
								        foreach ($grids['digest'] as $thread){
								    
								        echo <<<EOT
<li>
	<div class="second_line_content_1">$now_i</div>
	<a href="forum.php?mod=viewthread&tid={$thread['tid']}">
		<div class="second_line_content_2">{$thread['subject']}</div>
	</a>
	<div class="second_line_content_3"><a href="home.php?mod=space&uid={$thread['authorid']}">{$thread['author']}</a></div>
</li>
EOT;
								    
								        if (++$now_i > 8){
								            break;
								        }
								    
								    }
								    
								    ?>
									
								</ul>
								
								<ul class="index4">
								
								    <?php 
								    //hot
								    $now_i = 1;
								    
								    if(is_array($grids['hot']))
								        foreach ($grids['hot'] as $thread){
								    
								        echo <<<EOT
<li>
	<div class="second_line_content_1">$now_i</div>
	<a href="forum.php?mod=viewthread&tid={$thread['tid']}">
		<div class="second_line_content_2">{$thread['subject']}</div>
	</a>
	<div class="second_line_content_3"><a href="home.php?mod=space&uid={$thread['authorid']}">{$thread['author']}</a></div>
</li>
EOT;
								    
								        if (++$now_i > 8){
								            break;
								        }
								    
								    }
								    
								    
								    ?>
								
								</ul>
							
								<ul class="index5">
									
								</ul>
							
								
							</div>
							
						</div>
					</div>
					<div class="first_part_right">
						<div class="top">
                                                        <div class="top_left">会员排行</div>
							<div class="top_right">最新会员</div>
						</div>
						<div class="middle">
							<ul class="middle_index2">
							     <?php 
							     
							     $num_2 =0;
							     foreach ($newest_member as $key=> $member){
							         
							         $num_2++;
							         echo <<<EOT
<li>
<a href="home.php?mod=space&uid={$member['uid']}" title="{$member['username']}" c="1" target="_blank" >
<div class="middle_content_left" id="middle_content_left1">{$num_2}</div>
<div class="middle_content_middle">{$member['username']}</div>
<div class="middle_content_right">积分:{$member['credits']}</div>
</a>
</li>
EOT;
							         
							     }
							     
							     ?>
									
							</ul>
							
							
							<ul class="middle_index1">
							
							     <?php 
							     
							     $num_1 =0;
							     foreach ($most_point_members as $member){
							         
							         $num_1++;
							         echo <<<EOT
<li>
<a href="home.php?mod=space&uid={$member['uid']}" title="{$member['username']}" c="1" target="_blank" >
<div class="middle_content_left" id="middle_content_left1">{$num_1}</div>
<div class="middle_content_middle">{$member['username']}</div>
<div class="middle_content_right">积分:{$member['credits']}</div>
</a>
</li>
EOT;
							         
							     }
							     
							     ?>
							     
							</ul>
							
						</div>
					</div>
				</div>
				
				
				
			
			<div class="second_part">
				<div class="second_part_content">今日：<div style="color: #ec6941;display: inline;">&nbsp;<?php echo $todayposts;?></div></div>
				<div class="second_part_content">昨日：<div style="color: #ec6941;display: inline;">&nbsp;<?php echo $postdata['0'];?></div></div>
				<div class="second_part_content">帖子：<div style="color: #ec6941;display: inline;">&nbsp;<?php echo $posts;?></div></div>
				<div class="second_part_content">会员：<div style="color: #ec6941;display: inline;">&nbsp;<?php echo $_G['cache']['userstats']['totalmembers'];?></div></div>
				<div class="second_part_content5">欢迎新会员：<div style="color: #ec6941;display: inline;">&nbsp;<a href="home.php?mod=space&amp;username=<?php echo rawurlencode($_G['cache']['userstats']['newsetuser']); ?>" target="_blank" class="xi2"><?php echo $_G['cache']['userstats']['newsetuser'];?></a></div></div>
				<div class="second_part_content6"><a href="forum.php?mod=guide&amp;view=new" title="最新回复" class="xi2">最新回复</a></div>
			</div>
			
			
			<div class="third_part">
					<div class="container">
						<div class="line1">
						    <?php 
						    //输出雪茄天地的信息
						    $current_forum = reset($catlist);
						    
						    echo <<<EOT
<p><a href="forum.php?gid={$current_forum['fid']}">{$current_forum['name']}</a></p>
<div class="right_img">
	<img src="img/luntan/bg3.png" />
</div>
<div class="right">分区版主：<font style="color: #6a3906;">{$current_forum['moderators']}</font></div>
</div>

<div class="xiahuaxian"></div>
EOT;
						    
						    
						    
						    $now_i = 1;
						    foreach ($current_forum['forums'] as $sub_forum){
						        //输出子论坛
						        $style = '';
						        switch ($now_i){
						            case 1:
						                $style = 'float: left;margin-right: 40px;margin-bottom: 28px;';
						                break;
						            case 2:
						                $style = 'float: left;margin-bottom: 28px;';
						                break;
						            case 3:
						                $style = 'float: left;margin-right: 40px;';
						                break;
						            case 4:
						                $style = 'float: left;';
						                break;
						        }
						        $forum = $forumlist[$sub_forum];
						        $icon = $forum['icon'];
						        if (empty($icon)){
// 						            $icon = "<a href=\"forum.php?mod=forumdisplay&fid={$forum['fid']}\" ><img src=\"123.gif" alt=\"{$forum['name']}\" /></a>";
                                    $icon = '<a href="forum.php?mod=forumdisplay&fid='.$forum['fid'].'"><img src="static/image/common/forum.gif" align="left" alt="" /></a>';
						        }
						        
						        $last_post = $forum['lastpost'];
						        $subject = '<a href="forum.php?mod=redirect&tid='.$last_post['tid'].'&goto=lastpost#lastpost"><span style="width: 140px;display: inline-block; overflow: hidden;color: #6a3906;white-space: nowrap;text-overflow: ellipsis;">'.$last_post['subject'].'</span></a>';
						        if (empty($last_post)){
						            $subject = '<span style="width: 160px; overflow: hidden;color: #6a3906;display: inline-block;">从未</span>';
						        }
						        
						        echo <<<EOT
<div class="scontainer" style="$style">
	$icon
	<div class="index">
		<p style="margin-bottom: 20px;">
			<a style="font-size: 16px;font-weight: bold;color: #6a3906;" href="forum.php?mod=forumdisplay&fid={$forum['fid']}">{$forum['name']} </a><font style="font-size: 16px;color: #e60012;font-weight: normal;">({$forum['todayposts']})</font>
		</p>
		<p style="color: black;font-size: 14px;margin-bottom: 10px;">
			主题数 ：{$forum['threads']} ,帖子数 ：{$forum['posts']}
		</p>
		<p style="color: #6A3906;font-size: 14px;">
			 $subject <font color="black">{$last_post['dateline']} <span class="span2" style="overflow: hidden;color: #6a3906;white-space: nowrap;text-overflow: ellipsis;width:60px;display:inline-block;"  >{$last_post['author']}</span></font> 
		</p>
	</div>
</div>
EOT;
						        
						        
						        $now_i++;
						    }
						    
						    ?>
						
						
					</div>
				
					<div class="container2" style="margin-bottom: 28px;">
					
					<?php 
					   
					   $current_forum = next($catlist);
					   
					   echo <<<EOT
<div class="line1">
	<p><a href="forum.php?gid={$current_forum['fid']}">{$current_forum['name']}</a></p>
	<div class="right_img">
		<img src="img/luntan/bg3.png" />
	</div>
	<div class="right">分区版主：<font style="color: #6a3906;">{$current_forum['moderators']}</font></div>
</div>

<div class="xiahuaxian"></div>
EOT;
					   
					   
					   
					   foreach ($current_forum['forums'] as $sub_forum){
					       
					       $forum = $forumlist[$sub_forum];
					       
					       $last_post = $forum['lastpost'];
					       $subject = '<a href="forum.php?mod=redirect&tid='.$last_post['tid'].'&goto=lastpost#lastpost"><span style="width: 160px;display: inline-block; overflow: hidden;color: #6a3906;">'.$last_post['subject'].'</span></a>';
					       if (empty($last_post)){
					           $subject = '<span style="width: 160px; overflow: hidden;color: #6a3906;display: inline-block;">从未</span>';
					       }
					       
					       echo <<<EOT
<div class="scontainer" style="margin-bottom: 12px;">
	<div class="left">
		<img src="img/luntan/bg11.png">
		<p style="color: #6A3906;font-size: 16px;font-weight: bold;margin-top: 14px;float: left;width: 570px;margin-bottom: 5px;">
			<a style="font-size: 16px;font-weight: bold;color: #6a3906;" href="forum.php?mod=forumdisplay&fid={$forum['fid']}">{$forum['name']}</a>
		</p>
		<p style="font-size: 14px;color: black;float: left;width: 480px;margin-bottom: 5px;">
			{$forum['description']}
		</p>
		<p style="color: black;font-size: 14px;float: left;margin-bottom: 5px;width: 80px;">
			<font style="color: #81511c;">{$forum['todayposts']} / </font>{$forum['posts']}
		</p>
		<p style="color: black;margin-bottom: 8px;">
			版主: <font style="color: #6A3906;">{$forum['moderators']}</font> 
		</p>
	</div>
	<div class="right">
		<p style="color: #81511c;margin-top: 25px;margin-bottom: 10px;">
			{$subject}
		</p>
		<p style="color: black;">
			{$last_post['dateline']} <font style="color: #81511c;">{$last_post['author']}</font> 
		</p>
	</div>
	
</div>
EOT;
					       
					       
					   }
					
					
					   
					   
					
					?>

						
					</div>
					
					<div class="container2" style="margin-bottom: 28px;">
					
					<?php 
					//雪茄鉴赏
					
					$current_forum = next($catlist);
					
					echo <<<EOT
<div class="line1">
	<p><a href="forum.php?gid={$current_forum['fid']}">{$current_forum['name']}</a></p>
	<div class="right_img">
		<img src="img/luntan/bg3.png" />
	</div>
	<div class="right">分区版主：<font style="color: #6a3906;">{$current_forum['moderators']}</font></div>
</div>
					
<div class="xiahuaxian"></div>
EOT;
					
					

					foreach ($current_forum['forums'] as $sub_forum){
					
					    $forum = $forumlist[$sub_forum];
					
					    $last_post = $forum['lastpost'];
					    $subject = '<a href="forum.php?mod=redirect&tid='.$last_post['tid'].'&goto=lastpost#lastpost"><span style="width: 160px;display: inline-block; overflow: hidden;color: #6a3906;">'.$last_post['subject'].'</span></a>';
					    if (empty($last_post)){
					        $subject = '<span style="width: 160px; overflow: hidden;color: #6a3906;display: inline-block;">从未</span>';
					    }
					
					    echo <<<EOT
<div class="scontainer" style="margin-bottom: 12px;">
	<div class="left">
		<img src="img/luntan/bg11.png">
		<p style="color: #6A3906;font-size: 16px;font-weight: bold;margin-top: 14px;float: left;width: 570px;margin-bottom: 5px;">
			<a style="font-size: 16px;font-weight: bold;color: #6a3906;" href="forum.php?mod=forumdisplay&fid={$forum['fid']}">{$forum['name']}</a>
		</p>
		<p style="font-size: 14px;color: black;float: left;width: 480px;margin-bottom: 5px;">
			{$forum['description']}
		</p>
		<p style="color: black;font-size: 14px;float: left;margin-bottom: 5px;width: 80px;">
			<font style="color: #81511c;">{$forum['todayposts']} / </font>{$forum['posts']}
		</p>
		<p style="color: black;margin-bottom: 8px;">
			版主: <font style="color: #6A3906;">{$forum['moderators']}</font>
		</p>
	</div>
	<div class="right">
		<p style="color: #81511c;margin-top: 25px;margin-bottom: 10px;">
			{$subject}
		</p>
		<p style="color: black;">
			{$last_post['dateline']} <font style="color: #81511c;">{$last_post['author']}</font>
		</p>
	</div>
					
</div>
EOT;
					
					
					}
					
					?>
						
					</div>
					
					<div class="container3" style="margin-bottom: 28px;">
					
					   <?php 
					   //休闲周边

					   $current_forum = next($catlist);
					   	
					   echo <<<EOT
<div class="line1">
	<p><a href="forum.php?gid={$current_forum['fid']}">{$current_forum['name']}</a></p>
	<div class="right_img">
		<img src="img/luntan/bg3.png" />
	</div>
	<div class="right">分区版主：<font style="color: #6a3906;">{$current_forum['moderators']}</font></div>
</div>
			
<div class="xiahuaxian"></div>
EOT;
					   
					   
					   
					   $now_i = 1;
					   foreach ($current_forum['forums'] as $sub_forum){
					       	
					       $forum = $forumlist[$sub_forum];
					       	
					       $last_post = $forum['lastpost'];
					       $subject = '<a href="forum.php?mod=redirect&tid='.$last_post['tid'].'&goto=lastpost#lastpost"><span style="width: 160px;display: inline-block; overflow: hidden;color: #6a3906;">'.$last_post['subject'].'</span></a>';
					       if (empty($last_post)){
					           $subject = '<span style="width: 160px; overflow: hidden;color: #6a3906;display: inline-block;">从未</span>';
					       }
					       
					       $style = '';
					       switch ($now_i){
					           case 1:
					           case 2:
					           case 4:
					           case 5:
					               $style = 'margin-right: 60px;';
					               break;
					       }
					       
					       if ($now_i == 1 || $now_i == 4){
					           echo '<div class="scontainer" >';
					       }
					       
					       echo <<<EOT
<div class="left" style="$style">
	<img src="img/luntan/bg11.png">
	<p style="color: #6A3906;font-size: 16px;font-weight: bold;margin-top: 14px;float: left;width: 130px;margin-bottom: 5px;">
		<a style="font-size: 16px;font-weight: bold;color: #6a3906;" href="forum.php?mod=forumdisplay&fid={$forum['fid']}">{$forum['name']}</a><font style="color: #e60012;font-weight: normal;">({$forum['todayposts']})</font> 
	</p>
	<p style="font-size: 14px;color: black;float: left;margin-bottom: 5px; width: 150px;">
		主题: {$forum['threads']}, 帖数: {$forum['posts']}
	</p>
	<p style="color: black;float: left;">
		最后发表: {$last_post['dateline']} 
	</p>
</div>
EOT;
					   			
                			if ($now_i == 3 || $now_i == 6){
                			    echo '</div>';
                			}
                			$now_i++;
					   }
					   
					   ?>

						
					</div>
					
					<div class="container3" style="margin-bottom: 28px;">
						<?php 
					   //体验生活

					   $current_forum = next($catlist);
					   	
					   echo <<<EOT
<div class="line1">
	<p><a href="forum.php?gid={$current_forum['fid']}">{$current_forum['name']}</a></p>
	<div class="right_img">
		<img src="img/luntan/bg3.png" />
	</div>
	<div class="right">分区版主：<font style="color: #6a3906;">{$current_forum['moderators']}</font></div>
</div>
			
<div class="xiahuaxian"></div>
EOT;
					   
					   
					   
					   $now_i = 1;
					   foreach ($current_forum['forums'] as $sub_forum){
					       	
					       $forum = $forumlist[$sub_forum];
					       	
					       $last_post = $forum['lastpost'];
					       $subject = '<a href="forum.php?mod=redirect&tid='.$last_post['tid'].'&goto=lastpost#lastpost"><span style="width: 160px;display: inline-block; overflow: hidden;color: #6a3906;">'.$last_post['subject'].'</span></a>';
					       if (empty($last_post)){
					           $subject = '<span style="width: 160px; overflow: hidden;color: #6a3906;display: inline-block;">从未</span>';
					       }
					       
					       $style = '';
					       switch ($now_i){
					           case 1:
					           case 2:
					           case 4:
					           case 5:
					               $style = 'margin-right: 70px;';
					               break;
					       }
					       
					       if ($now_i == 1 || $now_i == 4){
					           echo '<div class="scontainer" >';
					       }
					       
					       echo <<<EOT
<div class="left" style="$style">
	<img src="img/luntan/bg11.png">
	<p style="color: #6A3906;font-size: 16px;font-weight: bold;margin-top: 14px;float: left;width: 130px;margin-bottom: 5px;">
		<a style="font-size: 16px;font-weight: bold;color: #6a3906;" href="forum.php?mod=forumdisplay&fid={$forum['fid']}">{$forum['name']}</a><font style="color: #e60012;font-weight: normal;">({$forum['todayposts']})</font> 
	</p>
	<p style="font-size: 14px;color: black;float: left;margin-bottom: 5px; width: 150px;">
		主题: {$forum['threads']}, 帖数: {$forum['posts']}
	</p>
	<p style="color: black;float: left;">
		最后发表: {$last_post['dateline']} 
	</p>
</div>
EOT;
					   			
                			if ($now_i == 3 || $now_i == 6){
                			    echo '</div>';
                			}
                			$now_i++;
					   }
					   
					   ?>
						
						
					</div>
					<div class="container4" style="margin-bottom: 28px;display:none">
					
					   <?php 
					   //站务管理
					   $current_forum = next($catlist);
					   	
					   echo <<<EOT
<div class="line1">
	<p><a href="forum.php?gid={$current_forum['fid']}">{$current_forum['name']}</a></p>
	<div class="right_img">
		<img src="img/luntan/bg3.png" />
	</div>
	<div class="right">分区版主：<font style="color: #6a3906;">{$current_forum['moderators']}</font></div>
</div>
		
<div class="xiahuaxian"></div>
EOT;
					   
					   
					   foreach ($current_forum['forums'] as $sub_forum){
					       
					       $forum = $forumlist[$sub_forum];
					       
					       $last_post = $forum['lastpost'];
					       $subject = '<a href="forum.php?mod=redirect&tid='.$last_post['tid'].'&goto=lastpost#lastpost"><span style="width: 160px;display: inline-block; overflow: hidden;color: #6a3906;">'.$last_post['subject'].'</span></a>';
					       if (empty($last_post)){
					           $subject = '<span style="width: 160px; overflow: hidden;color: #6a3906;display: inline-block;">从未</span>';
					       }
					       
					       echo <<<EOT
<div class="scontainer" style="margin-bottom: 12px;">
	<div class="left">
		<img src="img/luntan/bg11.png">
		<p style="color: #6A3906;font-size: 16px;font-weight: bold;margin-top: 14px;float: left;width: 570px;margin-bottom: 5px;">
			<a style="font-size: 16px;font-weight: bold;color: #6a3906;" href="forum.php?mod=forumdisplay&fid={$forum['fid']}">{$forum['name']}</a>
		</p>
		<p style="font-size: 12px;color: black;float: left;width: 510px;margin-bottom: 5px;">
			{$forum['description']}
		</p>
		<p style="color: black;font-size: 14px;float: left;margin-bottom: 5px;width: 80px;">
			<font style="color: #81511c;">{$forum['todayposts']}  / </font>{$forum['posts']}
		</p>
		<p style="color: black;margin-bottom: 8px;float: left;">
			版主: <font style="color: #6A3906;">{$forum['moderators']}</font>
		</p>
	</div>
	<div class="right">
		<p style="color: #81511c;margin-top: 25px;margin-bottom: 10px;">
			{$subject}
		</p>
		<p style="color: black;">
			{$last_post['dateline']} <font style="color: #81511c;">{$last_post['author']}</font> 
		</p>
	</div>
	
</div>
EOT;
					       
					   }
					   
					   
					   ?>
						
					</div>
				</div>
			</div>
		</div>
		
	</div>

<?php echo_footer();?>
</body>

</html>