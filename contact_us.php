<?php 

require_once 'util.php';

require 'admin/contact.inc.php';

if (isset($_GET['tip'])){
    if ($_GET['tip'] == 0){
        echo <<<EOT
    <html><head><script>alert('提交成功');location='contact_us.php'</script></head><body></body></html>
EOT;
    }else{
        echo <<<EOT
    <html><head><script>alert('提交失败，请确认你输入的内容');location='contact_us.php'</script></head><body></body></html>
EOT;
    }

    exit();
}

global $_MCONFIG;

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>联系我们  - <?php echo $_MCONFIG['title'];?></title>
		<?php echo_web_keywords_and_descr();?>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/top.css"/>
		<link rel="stylesheet" type="text/css" href="css/lianxiwomen.css"/>
		<link rel="stylesheet" type="text/css" href="css/foot.css"/>
		<link rel="stylesheet" href="css/index_cebianlan.css" />
		
		<script type="text/javascript" src="js/jquery-1.9.1.min.js" ></script>
		
	
			<script>
			$(document).ready(function(){

				//表单提交
				$('form[name=sug]').submit(function(){
					
					var name = $('input[name=name]');
					var email = $('input[name=email]');
					var title= $('input[name=title]');
					var content = $('textarea[name=content]');
					
					if(!name.val() || !email.val() || !title.val() || !content.val()){
						alert('请输入全部的内容');
						return false;
					}
					
					var reg = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
				　　if (!reg.test(email.val())) {
					　　	alert("请输入正确的邮箱格式");
						email.focus();
						return false;
				　　}
				
					return true;
				});
			});
		</script>
	
	</head>
	<body>
		
		<?php echo_header();?>
		
		<?php echo_slide();?>
		
		
		<!------------------------主体部分--------------------->
		<div class="banner_bag">
			<div class="banner_bag_top">
				<div class="banner_bag_top_list">
					<a href="./" class="banner_bag_top_a">首页</a>&nbsp;>&nbsp;
					<a href="#" class="banner_bag_top_a">联系我们</a>
				</div>
			</div>
			
			<div class="banner_bag_main">
				<div class="content">
					<div class="content_left">
						<form name="sug" action="action.php?action=sug_commit" method="post">
						<div class="content_left_second">
							<!--<div class="content_left_second_1"></div>-->
							<input type="text" class="content_left_second_1" name="name"></input>
							<div class="content_left_second_2">姓名</div>
						</div>
						<div class="content_left_second">
							<input type="text" class="content_left_second_1" name="email"></input>
							<div class="content_left_second_2">邮箱</div>
						</div>
						<textarea class="content_left_third" name="content" style="resize:none">请输入内容</textarea>
						<button style="border: 0px;" type="submit" class="content_left_four">意见提交</button>
						</form>
					</div>
					<div class="content_right">
						<div class="content_right_first">联系方式</div>
						<div class="content_right_second">
							<div class="content_right_second_1"></div>
							<div class="content_right_second_2">&nbsp;QQ：<?php echo $_CINFO['qq'];?></div>
						</div>
						
						<div class="content_right_third">
							<div class="content_right_third_1"></div>
							<div class="content_right_third_2">电话：<?php echo $_CINFO['tel'];?></div>
						</div>
						
						<div class="content_right_five">
							<div class="content_right_five_1"></div>
							<div class="content_right_five_2">微博：<?php echo $_CINFO['weibo'];?></div>
						</div>
						
						<div class="content_right_six">
							<div class="content_right_six_1"></div>
							<div class="content_right_six_2">微信：<?php echo $_CINFO['weixin'];?></div>
						</div>
						
						<div class="content_right_seven">
							<div class="content_right_seven_1"></div>
							<div class="content_right_seven_2">邮箱：<?php echo $_CINFO['mail'];?></div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		
		<?php echo_footer();?>

	</body>
</html>