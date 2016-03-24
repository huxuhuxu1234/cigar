<?php

if(!defined('IN_CIGAR_UTIL')){
    header('Location: ../');
    exit();
}

global $_MCONFIG;

?>




		<style>
		.foot .foot_top a:hover{ text-decoration: underline; color: #ffba6d; }
		</style>	
		
		<div class="foot">
			<div class="foot_top">
				<img class="foot_top_img" src="img/foot/me.png"/>
				<div class="meshare">
					<div class="me1" id="me_share1">
						<?php echo_foot_left_img();?>
					</div>
					
					<div id="me_left" onclick="_me_click1()" >
					</div>
					<div class="me1" id="me_share2">
						<div class="me_img_list">
						  <?php echo_foot_middle_img();?>
						</div>
					</div>	
				
					<div id="me_right"  onclick="_me_click2()" >
					</div>
					<div class="me1" id="me_share3">
						<?php echo_foot_right_img();?>
					</div>
				</div>
				<div class="me_jianbian">
					<a href="my_box.php"><img class="me_font1" id="me_font1" src="img/foot/me_font1.png"/></a>
					<a href="zhenwo.php"><img class="me_font1" id="me_font2" src="img/foot/me_font2.png"/></a>
					<a href="discuz.php"><img class="me_font1" id="me_font3" src="img/foot/me_font3.png"/></a>	
				</div>
				<div class="me_font11">
					<div class="me_font_font1">
							 <a href="my_box.php">管理并且分享你所收藏的雪茄。</a>
					</div>
					<div class="me_font_font2">
							 <a href="zhenwo.php">分享你收藏的雪茄与故事。</a>
					</div>
					<div class="me_font_font3">
							 <a href="discuz.php">留下你对我们想说的话。</a>
					</div>
				</div>
			</div>
			
			<div class="foot_foot">
				<div class="foot_foot_left">
					<div class="foot_foot_left_middle">
						<img class="foot_foot_left_middle_line" src="img/foot/fengexian.png" />
					</div>
					<div class="foot_foot_left_top">
						<div class="foot_foot_left_top_4">
							<a id="help" href="#">商务合作</a><br />
								<a class="help" href="#">招聘</a><br />
								<a class="help" href="#">广告招商</a><br />
								<a class="help" href="#">品牌营销</a><br />
						</div>
						<div class=" foot_foot_left_top_1">
							<a id="help" href="#">帮助中心</a>
								<a class="help" href="#">联手上路</a>
								<a class="help" href="#">常见问题</a>
								<a class="help" href="#">客服帮助</a>
						</div>
						<div class="foot_foot_left_top_2">
								<a id="help" href="contact_us.php">投诉建议</a><br />
								<a class="help" href="contact_us.php">举报不良信息</a>
								<a class="help" href="contact_us.php">意见反馈</a><br />
								<a class="help" href="contact_us.php">投诉侵权信息</a><br />
						</div>
						<div class="foot_foot_left_top_3">
							<a id="help" href="#">公司信息</a><br />
								<a class="help" href="#">关于我们</a><br />
								<a class="help" href="#">微信公众号：<?php echo $_MCONFIG['weixin_number'];?></a><br />
								<a class="help" href="#">最专业的在线门户</a><br />
						</div>
					</div>
					<div class="foot_foot_left_middle">
						<img class="foot_foot_left_middle_line" src="img/foot/fengexian.png" />
					</div>
					<div class="foot_warnning">
						<div style="margin-left:-280px; font-size: 12px;line-height:24px;">“1. 吸烟有害健康，本站含有烟草内容，不欢迎未成年人浏览</br>　　2.本站为烟民交流网站而非商城，不出售任何烟草制品　　3. 友情提醒，2011年起公共场所禁止吸烟”
						</div>
					</div>
					<div class="foot_foot_left_foot">
						<div class="foot_foot_left_foot_font">
							© 2015 General Cigar Company Inc. All rights reserved. 津ICP备15005929号
						</div>
					</div>
				</div>
				<div class="foot_foot_right">
					<img class="foot_foot_right_erweima" src="<?php echo substr($_MCONFIG['2d_code_image'], 3);?>" width="300px" height="300px"/>
				</div>
			</div>
		</div>
		<script>

		var now_me_img = 1;
		var me_list_left = 0;
		
		function _me_click1(){
			if(now_me_img ==1){						
				me_list_left = -550;
				$(".me_img_list").stop().animate({left:me_list_left},1000);						
				now_me_img=3;
				
			}
			else{
				me_list_left = -275*(now_me_img-2);
				$(".me_img_list").stop().animate({left:me_list_left},1000)
				now_me_img --;
			}
		}
		
		function _me_click2(){
			if(now_me_img ==3){
				me_list_left = 0;
				$(".me_img_list").stop().animate({left:me_list_left},1000)
				now_me_img =1;
			}
			else{
				me_list_left = -275*now_me_img;
				$(".me_img_list").stop().animate({left:me_list_left},1000)
				now_me_img ++;
			}
		
		
		}
		
		$(function(){
			$('#me_font1').hover(function(){
				$("#me_font1").attr('src','img/foot/me_font11.png'); 
			});
			$('#me_font1').mouseout(function(){
				$("#me_font1").attr('src','img/foot/me_font1.png');
			})
			$('#me_font2').hover(function(){
				$("#me_font2").attr('src','img/foot/me_font22.png'); 
			});
			$('#me_font2').mouseout(function(){
				$("#me_font2").attr('src','img/foot/me_font2.png');
			})
			$('#me_font3').hover(function(){
				$("#me_font3").attr('src','img/foot/me_font33.png'); 
			});
			$('#me_font3').mouseout(function(){
				$("#me_font3").attr('src','img/foot/me_font3.png');
			})
		});
		</script>