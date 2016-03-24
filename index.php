<?php 
    require_once 'util.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $_MCONFIG['title'];?></title>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/top.css"/>
		<link rel="stylesheet" type="text/css" href="css/index.css"/>
		<link rel="stylesheet" type="text/css" href="css/foot.css"/>
		<link rel="stylesheet" href="css/index_cebianlan.css" />
		<?php echo_web_keywords_and_descr();?>
		<script>

		   var now_img;
			var list_left= 0;
					
			var total_num = 3;
			
				function _banner_click1(){
					if(now_img ==1){						
						list_left = -2000;
						$(".img_list").stop().animate({left:list_left},1000);						
						now_img=total_num;
						
					}
					else{
						list_left = -1000*(now_img-2);
						$(".img_list").stop().animate({left:list_left},1000)
						now_img --;
					}
				}
				
				function _banner_click2(){
					if(now_img ==total_num){
						list_left = 0;
						$(".img_list").stop().animate({left:list_left},1000)
						now_img =1;
					}
					else{
						list_left = -1000*now_img;
						$(".img_list").stop().animate({left:list_left},1000)
						now_img ++;
					}
				}
				
				
				$(function(){
					
					var aaa = $(".img_list").css("left");
					
					now_img =  -(parseInt(aaa)/1000)+1;
					
					total_num = $('.img_list a').length;
					$('.img_list').css('width',(total_num * 1100) + 'px');
					
				});


				// 输出自动轮播的脚本内容
				<?php echo_index_rolling_images_script(); ?>
		</script>
	

	
	</head>
	<body>
	
	   <?php echo_header(); ?>
	   
	   <?php echo_slide();?>

		
		
		<div class="banner_bag">
                    <div style="float: left; display: inline; width: 0px; margin-left: -42px; margin-top: 105px;">
                        <embed name="swfPlayer" style="width: 300px;" pluginspage="http://www.macromedia.com/go/getflashplayer" id="smoke" src="img/index/2222.swf" type="application/x-shockwave-flash" wmode="transparent" quality="high" swliveconnect="true" allowscriptaccess="sameDomain" autostart="true">
                    </div>
			<div class="banner">
				<div class="img_list">
				   <?php echo_index_rolling_images();?>
				</div>
				
				<div id="banner_left" onclick="_banner_click1()">
				</div>
				<div id="banner_right" onclick="_banner_click2()">
				</div>
			</div>
                   <div style="float: right; display: inline; width: 219px; margin-top: -500px;">
                        <embed name="swfPlayer" style="width: 300px;" pluginspage="http://www.macromedia.com/go/getflashplayer" id="smoke" src="img/index/2222.swf" type="application/x-shockwave-flash" wmode="transparent" quality="high" swliveconnect="true" allowscriptaccess="sameDomain" autostart="true">
                    </div>
		</div>
		
<!--		<div id="smoke_left" style="position:absolute; left:50%; top:50%; margin-left: -970px; margin-top: -220px; width:220px; height:800px; z-index:1"> 
			<div align="center"> 
				<object width="500" height="800" id="swfPlayer" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
					<param name="movie" value="img/index/2222.swf">
					<param name="quality" value="high"><param name="wmode" value="transparent">
					<param name="autoplay" value="true">
					<param name="LOOP" value="true" />
					<embed name="swfPlayer" width="500" height="800" pluginspage="http://www.macromedia.com/go/getflashplayer" id="smoke" src="img/index/2222.swf" type="application/x-shockwave-flash" wmode="transparent" quality="high" swliveconnect="true" allowscriptaccess="sameDomain" autostart="true">
				</object>
			</div>
		</div> 
		
		<div id="smoke_right" style="position:absolute; left:50%; top:50%; margin-left: 470px; margin-top: -220px; width:220px; height:800px; z-index:1"> 
			<div align="center"> 
				<object width="500" height="800" id="swfPlayer" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
					<param name="movie" value="img/index/3333.swf">
					<param name="quality" value="high"><param name="wmode" value="transparent">
					<param name="autoplay" value="true">
					<param name="LOOP" value="true" />
					<embed name="swfPlayer" width="500" height="700" pluginspage="http://www.macromedia.com/go/getflashplayer" id="smoke_2" src="img/index/3333.swf" type="application/x-shockwave-flash" wmode="transparent" quality="high" swliveconnect="true" allowscriptaccess="sameDomain" autostart="true">
				</object>
			</div>
		</div> -->
		
		<?php echo_footer();?>
		
		
		<script>
		  setInterval(function(){
			/*var _obj = document.getElementById('smoke');
			_obj.src = "";
			_obj.src = "img/index/2222.swf";
			_obj = document.getElementById('smoke_2');
			_obj.src = "";
			_obj.src = "img/index/3333.swf";*/
		  },3000);
		</script>
	</body>
</html>
