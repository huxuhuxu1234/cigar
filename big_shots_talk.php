<?php 
require_once 'util.php';
require_once 'salt.php';
require_once 'source/class/class_core.php';


//真实的id
$id = -1;
if (isset($_GET['id'])){
    $id = $salt->decode($_GET['id']);
}

if ($id == -1){
    header('Location: big_shots.php');
    exit();
}

//页面数据
$data = C::t('cigar_big_shots')->data($id);

if (!$data){
    echo <<<EOT
    <html><head><script>alert('请求失败，请重试');location='big_shots.php'</script></head><body></body></html>
EOT;
    exit();
}

//上一个，下一个的链接
$next_url = 'big_shots.php';
$prev_url = 'big_shots.php';
//上一个id
$p_id = C::t('cigar_big_shots')->_prev_id($id);
//下一个id
$n_id = C::t('cigar_big_shots')->_next_id($id);

$_to_list_confirm_script_prev = '';
$_to_list_confirm_script_next = '';

// exit('p: ' . $p_id . '#####n: ' . $n_id);
if ($p_id == -1){
    // 没有上一个
    $_to_list_confirm_script_prev = 'onclick="return confirm(\'已经没有上一个了，要返回首页么？\');"';
}else{
    $prev_url = '?id='.$salt->encode(3,$p_id);
}

if ($n_id == -1){
    // 没有下一个
    $_to_list_confirm_script_next = 'onclick="return confirm(\'已经没有下一个了，要返回首页么？\');"';
}else{
    $next_url = '?id='.$salt->encode(3,$n_id);
}

global $_MCONFIG;

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $data['bName']?> - 雪茄大咖  - <?php echo $_MCONFIG['title'];?></title>
		<?php echo_web_keywords_and_descr();?>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/top.css"/>
		<link rel="stylesheet" type="text/css" href="css/dakaxiangqing.css"/>
		<link rel="stylesheet" type="text/css" href="css/foot.css"/>
		
		<script type="text/javascript" src="js/jquery-1.9.1.min.js" ></script>
			
			<script>
				$(document).ready(function(){
					var g = $(".right_part").css("height");
					var j = $(".banner_bag_main").css("height");
					if(parseInt(g) < 500){
					    g = '500px';
					    $(".right_part_top").css("height",'300px')
					}
					$(".banner_bag_main").css({
						"height":g ,
					});
					var b = $(".banner_bag_main").css("height");
				});
			</script>
	</head>
	<body>
		
		<?php echo_header();?>
		
		<!------------------------主体部分--------------------->
		<div class="banner_bag">
			<div class="banner_bag_top">
				<div class="banner_bag_top_list">
					<a href="./" class="banner_bag_top_a">首页</a>&nbsp;>&nbsp;
					<a href="big_shots.php" class="banner_bag_top_a">雪茄大咖</a>&nbsp;>&nbsp;
					<a href="#" class="banner_bag_top_a"><?php echo $data['bName']?></a>
				</div>
			</div>
			
			<div class="banner_bag_main">				<div class="banner_bag_main_bg">
					<div class="left_part">
						<div class="left_part_top">
							<img src="<?php echo $data['img'];?>" width="352px" height="250px"/>
						</div>
						<div class="left_part_bottom">
							<div style="font-size: 30px;margin-bottom: 15px;width:370px;text-align:center;"><?php echo $data['bName']?></div>
							<div style="width:320px;text-align:center;"><?php echo $data['sName']?></div>
						</div>
					</div>
					
					<div class="right_part">
						<div class="right_part_top" style="width:545px;margin-top:10px;">
							
							<?php echo nl2br($data['content']);?>
			
						</div>
						<div class="right_part_bottom">
							<a href="<?php echo $prev_url;?>" <?php echo $_to_list_confirm_script_prev; ?> class="right_part_bottom_left">上一个</a>
							<a href="<?php echo $next_url;?>" <?php echo $_to_list_confirm_script_next; ?> class="right_part_bottom_right">下一个</a>
						</div>
					</div>				</div>
			</div>
		</div>
		
		
		<?php echo_footer();?>
	</body>
</html>
