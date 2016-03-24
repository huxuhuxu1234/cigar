<?php

if(!defined('IN_CIGAR_UTIL')){
    header('Location: ../');
    exit();
}

global $_G;

$show_or_hide_script = '';
$uid = $_G['uid'];
if ($uid == 0){
    $show_or_hide_script = '$(".cebianlan").hide();';
    return ;
}else{
    
}

$announcement = $_G['cache']['announcements_forum'];
// error_log(print_r($announcement,true));

$announcedata = C::t('forum_announcement')->fetch_all_by_date($_G['timestamp']);

$ann_extra_html = '';
if(!count($announcedata)) {
    $ann_extra_html = '<span style="color: #f19149;font-size: 15px;">当前没有公告</span>';
}

$announcelist = array();
foreach ($announcedata as $announce) {
    $announce['authorenc'] = rawurlencode($announce['author']);
    $tmp = explode('.', dgmdate($announce['starttime'], 'Y.m'));
    $months[$tmp[0].$tmp[1]] = $tmp;
    if(!empty($_GET['m']) && $_GET['m'] != dgmdate($announce['starttime'], 'Ym')) {
        continue;
    }
    $announce['starttime'] = dgmdate($announce['starttime'], 'd');
    $announce['endtime'] = $announce['endtime'] ? dgmdate($announce['endtime'], 'd') : '';
    $announce['message'] = $announce['type'] == 1 ? "[url]{$announce[message]}[/url]" : $announce['message'];
    
    $announcelist[] = $announce;
}

// error_log(print_r($announcelist,true));

$activity = C::t('cigar_activity')->fetch_data();

$no_read_msg_count = 0;
$no_read_tip_count = 0;

//echo '1';
$user_data = C::t('common_member')->fetch($uid);
//exit('2');

if(isset($user_data['newpm'])){
	$no_read_msg_count = $user_data['newpm'];
}

if(isset($user_data['newprompt'])){
	$no_read_tip_count = $user_data['newprompt'];
}


?>

<!--                侧边栏JS                -->
<script>
	$(document).ready(function(){
		$(".top").click(function(){
			$(".cebianlan").stop().animate({left:'-420px'},1000);
			$(".cebianlan_button").attr("ref",0);
		});
		
		$(".banner_bag").click(function(){
			$(".cebianlan").stop().animate({left:'-420px'},1000);
			$(".cebianlan_button").attr("ref",0);
		});
		
		$(".foot").click(function(){
			$(".cebianlan").stop().animate({left:'-420px'},1000);
			$(".cebianlan_button").attr("ref",0);
		});
		
		$(".cebianlan_button").click(function(){
			var flag = parseInt($(".cebianlan_button").attr("ref"));
			if(flag == 0){
				$(".cebianlan").stop().animate({left:'0px'},1000);
				$(".cebianlan_button").attr("ref",1);
			} else {
				$(".cebianlan").stop().animate({left:'-420px'},1000);
				$(".cebianlan_button").attr("ref",0);
			};
		});

		<?php echo $show_or_hide_script;?>
	});
</script>



<!--           侧边栏                                                        -->
		<div class="cebianlan">
			<div class="cebianlan_button" ref="0">

			</div>
			<div class="cebianlan_first_part">
				<div class="touxiang"><img alt="" height="110px" src="uc_server/avatar.php?uid=<?php echo $uid;?>&size=middle" /></div>
				<div class="self_infor" style="width: 200px;">
					<br />
					<!--欢迎回来前面的空白，不要改动-->
					欢迎回来， <br/>
					<div class="cebianlan_self">
						<?php echo '<a href="home.php?mod=space&uid='.$uid.'" >'.$_G['username'].'</a>';?>
					</div>
					<a href="home.php?mod=spacecp&ac=usergroup" ><?php echo $_G['group']['grouptitle'];?></a>
				</div>
			</div>
			
			<div class="cebianlan_second_part" style="height: 80px;">

			未读消息数目： <a href="home.php?mod=space&do=pm" target="_blank" > <?php echo $no_read_msg_count;?>条 </a> <br/> <br/>
			未读提醒数目： <a href="home.php?mod=space&do=notice" target="_blank" > <?php echo $no_read_tip_count;?>条 </a>  <br/>

			</div>
			

			<div class="cebianlan_second_part">
				<div class="second_part_first_line" style="font-size: 18px;font-family: 微软雅黑;">
					最新推广活动
				</div>
				<?php 
				
				foreach ($activity as $a){
				    
				    echo <<<EOT
<div class="second_part_second_line">
	<div class="second_line_right">
	    <a href="{$a['url']}" target="_blank"><p>{$a['title']}</p></a>
        <a href="{$a['url']}" target="_blank">{$a['content']}</a>
	</div>
</div>
EOT;
				    
				}
				
				
				?>
				

			</div>

			<div class="cebianlan_third_part">
				<div class="third_part_first_line" style="font-size: 18px;font-family: 微软雅黑;">
					论坛公告
				</div>
				<div id="ann_content">
				    <?php 
				    
				    if (!empty($ann_extra_html)){
				        echo $ann_extra_html;
				    }else{
				        //循环显示所有的公告信息
				        foreach ($announcelist as $ann){
				            
				            echo <<<EOT
<a href="forum.php?mod=announcement&id={$ann['id']}#{$ann['id']}">
<div class="third_part_second_line">
	{$ann['subject']}
</div>
</a>
EOT;
				            
				            
				        }
				        
				        
				        
				    }
				    
				    
				    ?>

				</div>
				

			</div>

		</div>

		<!--                侧边栏结束                                                  -->
