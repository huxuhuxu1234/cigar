<?php 
require_once 'util.php';
require_once 'salt.php';

global $_G;

if ($_G['uid'] == 0){
    echo <<<EOT
<html>
        <head>
            <script>
                alert('请登录后重试');        
                location = './';
            </script>
        </head>
        
        <body></body>
</html>
EOT;
    exit();
}

$uid = $_G['uid'];

$toggle_tab_script = '';

//雪茄盒数据
$box_order = FALSE;
if (isset($_GET['box_order'])){
    $box_order = $_GET['box_order'];
}
$box_data = null;
if ($box_order){
    $order = 'point DESC';
    switch ($box_order){
        case '1':
            $order = 'point DESC';
            break;
        case '2':
            $order = 'point';
            break;
        case '3':
            $order = 'add_time ';
            break;
        case '4':
            $order = 'add_time DESC';
            break;
    }
    $box_data = C::t('cigar_mybox')->show_data($uid,$order);
}else{
    $box_data = C::t('cigar_mybox')->show_data($uid);
}

$box_limit = box_limit();
$now_box_num = C::t('cigar_mybox')->_count($uid);

// error_log('' . $uid);

// print_r($box_data);
// exit();


//评级推荐
$groom_year_list = C::t('cigar_box_groom_year')->fetch_data();
$groom_comm_list = C::t('cigar_box_groom_commonage')->fetch_data();

$parm_year = -1;
$parm_comm = -1;
$parm_filter = -1;
$show_data = null;
if (!isset($_GET['year']) && !isset($_GET['comm']) && !isset($_GET['filter'])){
    //无参数
    $parm_year = $groom_year_list[0]['yid'];
    $show_data = C::t('cigar_box_groom_1')->data($parm_year);
}else{
    if (isset($_GET['comm'])){
        $parm_comm = $_GET['comm'];
        $show_data = C::t('cigar_box_groom_2')->data($parm_comm);
    }else if (isset($_GET['year'])){
        $parm_year = $_GET['year'];
        $show_data = C::t('cigar_box_groom_1')->data($parm_year);
    }else if (isset($_GET['filter'])){
        $parm_filter = $_GET['filter'];
        
        $data = C::t('cigar_filter')->fetch($parm_filter);
        if (!$data && !isset($data['condition'])){
            header('Location: ?');
            exit();
        }
        //     exit($data['condition']);
        $show_data = C::t('cigar_products')->_cigar_filter($data['condition']);
    }
    $toggle_tab_script = '$(\'div[ref=2]\').click();';
}




// 好友栏

if (isset($_GET['friend'])){
   $toggle_tab_script = '$(\'div[ref=3]\').click();';
}

$friend_data = C::t('home_friend')->friend_data($uid);
// print_r($friend_data);
// exit();


//筛选
$filter_data = C::t('cigar_filter')->fetch_data();
// print_r($filter_data);
// exit();


?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>我的雪茄盒  - <?php echo $_G['member']['username'];?> - <?php echo $_MCONFIG['title'];?></title>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/top.css" />
		<link rel="stylesheet" type="text/css" href="css/index.css" />
		<link rel="stylesheet" type="text/css" href="css/foot.css" />
		<link rel="stylesheet" type="text/css" href="css/friend.css" />
		<link rel="stylesheet" type="text/css" href="css/pingjituijian.css" />
		<link rel="stylesheet" type="text/css" href="css/My_cigar_box.css" />
		<link rel="stylesheet" href="css/index_cebianlan.css" />

		<?php echo_web_keywords_and_descr();?>

		<script>
			/////////////////////////标签页切换//////////////////////////////////
			$(function() {
				$(".item_body").hide();
				$("#itembody1").show();
				$(".fd_mianbaoxie .item,.item_active").click(function() {
					$(".fd_mianbaoxie .item,.item_active").attr("class", "item");
					$(this).attr("class", "item_active");
					$(".item_body").hide();
					var _num = $(this).attr("ref");
					$(".item_body").hide();
					$("#itembody" + _num).show();
				});
			});
		</script>

		<!-- 星星打分JS    !-->
		<script type="text/javascript">
			$(document).ready(function() {
				$(".star,.starshow").mouseover(function() {
					var flag = $(this).parent().attr("states");
					
					var num = parseInt($(this).attr("rel"));
					$(this).parent().find('.star,.starshow').each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow")
						} else {
							$(this).attr("class", "star")
						}
					});
				});


				$(".star,.starshow").click(function() {
					var num = parseInt($(this).attr("rel"));
					$(this).parent().find('#high-star').attr("value", num);
					$(this).parent().attr("states", "2");
					$(this).parent().find('.star,.starshow').each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow")
						} else {
							$(this).attr("class", "star")
						}
					});
					var string1 = $(this).attr("title");
					$('.star-content').html(string1);
				});
				
				
				$(".star,.starshow").mouseout(function() {
					$(this).parent().find(".starshow").each(function() {
						$(this).attr("class", "star");
					});
					var num = $(this).parent().find("#high-star").attr("value");
					$(this).parent().find('.star,.starshow').each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow")
						} else {
							$(this).attr("class", "star")
						}
					});
				});
				
				
				
				//
				$('select option').click(function(){
					//alert($(this).val());
					var type = $(this).parent().attr('name');
					if(type == 'year'){
						
					}else if(type == 'commonage'){
						type = 'comm';
					}else if(type == "box_order"){
						type="box_order";
					}else if(type == 'filter'){
					    type = 'filter';
					}
					else{
						return ;
					}
					location.href = '?' + type + '=' + $(this).val();
					
				});
				
				$('.tj_box2_ct_tj_bag,.tj_box2_content .item .tips_foot1').click(function(){
//					alert($(this).attr('id'));
					$.post('action.php?action=add_to_box',{'id':$(this).attr('id')},function(data){
						switch(data.errorCode){
							case '1':
							alert('登录超时，请重新登录');
							break;
							case '2':
							alert('请刷新页面后重试')
							break;
							case '3':
							alert('该雪茄已经在您的雪茄盒里面了')
							break;
							case '4':
								alert('您的雪茄盒已满，无法再添加更多的雪茄');
								break;
							case '0':
							alert('添加成功');
							history.go(0);
							break;
						}
					},'json');
				});
				
				
				<?php echo $toggle_tab_script;?>



				/*  按button加数字      */
				$(".tips_foot .left_key").click(function() {
					var num = parseInt($(this).parent().find('.num_content').val());
					if (num == 0) {
						$(this).parent().find('.num_content').val('0');
					} else {
						$(this).parent().find('.num_content').val(num - 1);
					}
				});
				$(".tips_foot .right_key").click(function() {
					var num = parseInt($(this).parent().find(".num_content").val());
					$(this).parent().find(".num_content").val(num + 1);
				});
				var _old_numw = 0;
				var _old_numx = 0;
				$(".num_content").keydown(function() {
					_old_numw = $(this).val();
				});
				$(".num_content").keyup(function() {
					var str = $(this).val();
					if (!(/^\d+$/.test(str))) {
						$(this).val(_old_numw)
					}
				})
				$(".num_content").focus(function() {
					_old_numx = $(this).val();
				});
				$(".num_content").blur(function() {
					var str = $(this).val();
					if (!(/^\d+$/.test(str))) {
						$(this).val(_old_numx)
					}
				})



				 /*         雪茄轮播             */

				$('.mcb_content1 .item:eq(4)').find('.tips').attr('class', 'tips_active')
				$(".mycigarbox2_left").stop().animate({
					opacity: 0.5
				}, 0);
				var _now_num = 1;
				var _sum = $(".mcb_content1").find(".item").length;
				$(".mcb_content1").css({
					'width': _sum * 260 + 'px'
				});
				$(".mycigarbox2_left").click(function() {
					_now_num--;
					if (_now_num <= 1) {
						_now_num = 1;
						$(this).stop().animate({
							opacity: 0.4
						}, 300);
					
						$(".mycigarbox2_right").stop().animate({
							opacity: 1
						}, 300);
					}
					move_content1();
				});
				$(".mycigarbox2_right").click(function() {
					_now_num++;
					if (_now_num >= (_sum - 4)) {
						_now_num = (_sum - 4);
						$(this).stop().animate({
							opacity: 0.4
						}, 300);
					
						$(".mycigarbox2_left").stop().animate({
							opacity: 1
						}, 300);
					}
					move_content1()
				});

				function move_content1() {
					var _aim = _now_num + 3;
					$(".mcb_content1").stop().animate({
						'left': (-((_now_num - 1) * 147).toString() + "px")
					}, 800);
					$(".mcb_content1 .tips,.mcb_content1 .tips_active").attr("class", "tips");
					$('.mcb_content1 .item:eq(' + _aim + ')').find('.tips').attr('class', 'tips_active');
				}


				//切换好友的雪茄
				$('.fd_fd1').click(function(){
					var uid = $(this).find('input:eq(0)').val();
					if(!uid){
						return false;
					}
					
					
					$.post('action.php?action=get_box_uid',{'id': uid},function(data){
						
						if(data.hasOwnProperty('errorCode')){
							switch(data.errorCode){
								case '1':
								case '2':
								alert('请登录后重试');
								break;
								case '3':
								alert('该用户并不是你的好友！');
								break;
								case '5':
								var h = '<div class="no_data_tip">' + 
				            '<img src="images/caution.png" width="48px" height="48px" />该好友的雪茄里并无雪茄' + 
				        '</div>';
								$('.fd_cigar_').html(h);
								break;
								case '4':
								default:
								alert('请刷新页面后重试');
								alert(data.errorCode);
								break;
								
							}
							return;
						}
						
						//ok 数据成功取得
						var p = $('.fd_cigar_');
						p.html('');
						var b_content = $('<div class="b_content"></div>');
						p.append(b_content);
						$(data).each(function(){
							
							var item = this;
							var size = parseInt(item.size);
							var style = '';
							if(size > 0 && size < 10){
								var tmp = size * 42;
								style = 'style="height: ' + tmp + 'px;width: 40px;"';
							}
							
							var i = '<div class="img1" id="right_img"> ' + 
							'<img class="img" src="'+item.image+'" '+ style+'/>' +
							'<div class="ftips">' +
								'<div class="tips_top">' +
									item.name +
								'</div>' +
						
								'<div class="tips_middle">' + 
									'产地：' + item.oName + 
									'<br />尺寸：'+item.length+'*' + item.width + 
									'<br />制作方式：' + item.make_mode + 
									'<br />' +
								'</div>' +
						
						       
								'<div class="tips_foot">' + 
									 '<a id="'+item.pid+'" >添加到雪茄盒</a>' + 
								'</div>' +
						        
							'</div>' +
						'</div>';							
							
							b_content.append(i);
							
						});
						
						//处理tips 的问题
						$('.fd_cigar_ .ftips:eq(3)').attr('class','ftips_active');
						$(".fd_cigar_ .ftips:eq(3)").attr("class","ftips_active");
						
						//添加到雪茄盒的事件绑定
						$('.fd_cigar_ .tips_foot a').click(function(){
//							alert('1');
							c_to_box(this);
						});
					},'json');
					
				});
				
				
				
				// 好友雪茄的轮播
				var b_n_id = 1;
				var b_sum = $('.fd_cigar_ .img1').length;
				
				$('.b_content').css({'width':b_sum*96+'px'})
				$(".fd_fds_left").click(function(){
					if(b_n_id>1)
					{
						b_n_id--;
					}
					else
					{
						b_n_id = b_sum - 4;
					}
					b_move(b_n_id);
				});
				
				$(".fd_fds_right").click(function(){
					if(b_n_id<(b_sum-4))
					{
						b_n_id++;
					}
					else
					{
						b_n_id = 1;
					}
					b_move(b_n_id);
				});
				
				
				
				//尝试等
				$('input[type=radio]').click(function(){
					
					$.post('action.php?action=cigar_taste',{'id': $(this).parent().attr('id'),'val': $(this).val() },function(data){
						if(data.hasOwnProperty('errorCode')){
							switch(data.errorCode){
								case '1':
								case '2':
								alert('请刷新页面后重试');
								break;
							}
						}else{
							alert('请刷新页面后重试');
						}
					},'json');
				
					
				});
				
				$('.mcb_ct_cigar .tips .tips_foot1').click(function(){
					
					$.post('action.php?action=cigar_taste',{'id': $(this).attr('id'),'num': $(this).parent().find('.num_content').val() },function(data){
						if(data.hasOwnProperty('errorCode')){
							switch(data.errorCode){
								case '1':
								case '2':
								alert('请刷新页面后重试');
								break;
								case '0':
								alert('更新成功');
								break;
							}
						}else{
							alert('请刷新页面后重试');
						}
					},'json');
					
				});


			});
			
			function c_to_box(src){
				
				$.post('action.php?action=add_to_box',{'id':$(src).attr('id')},function(data){
						switch(data.errorCode){
							case '1':
							alert('登录超时，请重新登录');
							break;
							case '2':
							alert('请刷新页面后重试')
							break;
							case '3':
							alert('该雪茄已经在您的雪茄盒里面了')
							break;
							case '4':
								alert('您的雪茄盒已满，无法再添加更多的雪茄');
								break;
							case '0':
							alert('添加成功');
//							history.go(0);
							break;
						}
					},'json').error(function(XMLHttpRequest, textStatus, errorThrown){
//						alert(XMLHttpRequest.responseText);
						alert('发生了一个未知的错误，请联系管理员');
				});
				
			}
				
			function b_move(id){
				var _left = -(id-1)*96;
				$('.fd_cigar_ .b_content').stop().animate({
					'left':_left+'px',
				},500);
				$('.fd_cigar_ .ftips_active').attr('class','ftips');
				$('.fd_cigar_ .ftips:eq('+(id + 2)+')').attr('class','ftips_active');
				$('.fd_cigar_ .ftips:eq('+(id + 2)+')').attr('class','ftips_active');
			}
			
			
			/*    评分雪茄     */
			function update_cigar(src,id){
				if(!src){
					return false;
				}
				var jSrc = $(src);
				//var id = jSrc.parent().attr('id');
				var point = jSrc.parent().parent().find('#high-star').val();
				if(!point || isNaN(point) || point == '0.00'){
					alert('更新成功');
					return false;
				}
				
//				alert(point);
				
				$.post('action.php?action=update_box_point',{'id': id,'point': point},function(data){
//					alert(data);
					switch(data.errorCode){
						case '0':
						alert('更新成功');
						break;
						case '1':
						alert('更新失败，请登录后重试');
						break;
						case '2':
						default:
						alert('更新失败，请刷新页面后重试');
						break;
					}
					
				},'json').error(function(XMLHttpRequest, textStatus, errorThrown){
//						alert(XMLHttpRequest.responseText);
						alert('发生了一个未知的错误，请联系管理员');
				});
				
				return false;
			}
			
			function delete_cigar(src,id){
				
				if(!src){
					return false;
				}
				var jSrc = $(src);
				//var id = jSrc.parent().attr('id');
				
				$.post('action.php?action=delete_cigar',{'id': id},function(data){
//					alert(data);
					switch(data.errorCode){
						case '0':
						alert('删除成功');
						history.go(0);
						break;
						case '1':
						alert('删除失败，请登录后重试');
						break;
						case '2':
						default:
						alert('删除失败，请刷新页面后重试');
						break;
					}
					
				},'json').error(function(XMLHttpRequest, textStatus, errorThrown){
//						alert(XMLHttpRequest.responseText);
						alert('发生了一个未知的错误，请联系管理员');
				});
				
				return false;
				
			}
			
		</script>

		
	</head>

	<body>
		
		<?php echo_header();?>

		<?php echo_slide();?>

		<div class="friend_body_bag">
			<div class="friend_bag">
				<div class="mianbaoxie">
					<a href="./">首页</a>&nbsp;&gt;&nbsp;
					<a href="#">我的雪茄盒</a>
				</div>
				<script>
					$(function() {
						$(".friend_huanying").click(function() {
							var _static = $(this).attr("static");
							if (_static == 0) {
								$(".friend_hy_detail").fadeIn(300);
								$(this).attr("static", 1);
								$(".friend_yindao").css({
									"height": "250px",
								});
							} else {
								$(".friend_hy_detail").fadeOut(300);
								$(this).attr("static", 0);
								$(".friend_yindao").css({
									"height": "60px",
								});
							}
						});
					});
				</script>
				<div class="friend_yindao">
					<div class="friend_huanying" id="fd_hy" static="1">
						欢迎来到我的雪茄盒
					</div>
					<div class="friend_hy_detail">
						<div class="friend_hy_dt_1">
							这里，你可以进行以下操作
						</div>
						<div class="friend_hy_dt_2">
							&bull;&nbsp;&nbsp;&nbsp;管理您的收藏清单</br>
							&bull;&nbsp;&nbsp;&nbsp;推荐雪茄给您的朋友</br>
							&bull;&nbsp;&nbsp;&nbsp;发布自己的评论和浏览其他爱好者的评论</br>
							&bull;&nbsp;&nbsp;&nbsp;根据专家建议完善您的收藏清单</br>
						</div>
					</div>
				</div>

				<div class="fd_mianbaoxie">

					<div class="item_active" ref="1">
						我的雪茄盒
					</div>
					<div class="item" ref="2">
						评级推荐
					</div>
					<div class="item" ref="3">
						好友栏
					</div>
				</div>
				<div class="fd_fg">

				</div>

				<div class="mycigarbox_bag item_body" id="itembody1">
					<div class="mycigarbox1">
						<div class="mycigarbox_px_font">
							排序：
						</div>

						<select class="mycigarbox_paixu mycigarbox_px_pf" name="box_order">
							<option value="1" <?php echo $box_order == '1' ? 'selected="selected"': '';?> >评分从高到低</option>
							<option value="2" <?php echo $box_order == '2' ? 'selected="selected"': '';?> >评分从低到高</option>
							<option value="3" <?php echo $box_order == '3' ? 'selected="selected"': '';?> >添加时间正序</option>
							<option value="4" <?php echo $box_order == '4' ? 'selected="selected"': '';?> >添加时间倒序</option>
							<div class="mycigarbox_px_jt">
								<img src="img/mycigarbox/mcb_px_jt.png" />
							</div>
						</select>
						
						<a href="home.php?mod=magic">
						<button class="mycigarbox_tj">
							扩充容量
						</button>
						</a>
						
						<div class="rongliang">
								雪茄盒容量：<?php echo $now_box_num.'/'.$box_limit;?>
						</div>
					</div>
					<div class="mycigarbox2">

						<div class="mycigarbox2_left"></div>
						<div class="mycigarbox2_right"></div>
						<div class="mcb_ct_bag">
							<div class="mcb_view">
								<div class="mcb_content mcb_content1">
								
								<?php 
								
								
								foreach ($box_data as $index => $row){

								    $id =$salt->encode(1,$row['pid']);
									$imid = $row['imid'];
									
									$size = $row['size'];
									$style = '';
									if($size > 0 && $size < 10){
										$tmp = $size * 42;
										$style = 'height: '.$tmp.'px;';
									}
								    $point = $row['point'];
								    
								    $i = 1;
								    $star_html = '';
								    for (;$i <= $row['point'];$i++){
								         $star_html .= '<div class="starshow" rel="'.$i.'" title="'.$i.'分"></div> ';
								    
								    }
								    	
								    for (;$i <= 5 ; $i++){
								        $star_html .= '<div class="star" rel="'.$i.'" title="'.$i.'分"></div> ';
								    }
								    
								    
								    
								    $taste_data = C::t('cigar_taste')->data($row['pid'],$uid);
								    
								    $have_num = $taste_data && isset($taste_data['num']) ? $taste_data['num']: 0;
								    $radio_html = '';
								    if ($taste_data && isset($taste_data['taste']) && $taste_data['taste'] == 1){
								        $radio_html = <<<EOT
                <input class="option" type="radio" name="options$index" value="1" checked="checked" />
				<div style="float: left;font-size: 12px;">我尝试过</div>
				<input class="option" type="radio" name="options$index" value="0" style="margin-left: 7px;"/>
				<div style="float: left;font-size: 12px;">我想尝试&nbsp;</div>
EOT;
								    }else{
								        $radio_html = <<<EOT
                <input class="option" type="radio" name="options$index" value="1" />
				<div style="float: left;font-size: 12px;">我尝试过</div>
				<input class="option" type="radio" name="options$index" value="0" checked="checked" />
				<div style="float: left;font-size: 12px;">我想尝试&nbsp;</div>
EOT;
								    }
								    
								    echo <<<EOT
<div class="item">
	<div class="mcb_ct_cigar">
	    <a href="product_show.php?id=$id" target="_blank">
		<img src="{$row['image']}" style="bottom: -12px;position:absolute;$style width: 40px;" /></a>
		<!-------tips-->
		<div class="tips">
			<div class="tips_top">
				{$row['name']} - {$row['brand']}
			</div>
			<div class="tips_middle">
				前标：{$row['frontmark']} <br />
				产地：{$row['oName']}
				<br /> 粗度：{$row['width']} &nbsp; &nbsp;长度：{$row['length']}
			</div>
			<div class="tips_foot" id="$id">
				$radio_html
				
				<div style="float: left;margin-right: 13px;">我有...</div>
				<div class="left_key"></div>
				<input type="text" class="num_content" value='$have_num' />
				<div class="right_key"></div>
			</div>
			<div class="tips_foot1" id="$id">
				更新雪茄盒
			</div>
		</div>
		<!--------tips结束-->

	</div>
	<div class="mcb_my_pingfen">
		<div class="mcb_mypf_font">
			我的评分
		</div>
		<div class="mcb_mypf_star">
			<!------------------星星控件-------------->
			<div class="star_all_content" states="1">
				$star_html
				<input type="hidden" value="$point" id="high-star">
			</div>

		</div>
		<button class="mcb_mypf_show">
			分享
		</button>
		<div class="mcb_mypf_update" id="$imid">
			<span onclick="update_cigar(this,'$id')" >更新</span>&nbsp;<span>|</span>&nbsp;
			<span onclick="delete_cigar(this,$imid)" >移除</span>
		</div>
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

				<div class="tj_bag item_body" id="itembody2">
					<div class="tj_box1">
						<div class="tj_niandu">
							年度排行榜：
						</div>

						<select class="tj_niandu1 tj_box1_font" name="year">
						    <?php 
						    foreach ($groom_year_list as $row){
        					   echo '<option value="'.$row['yid'].'" '.($row['yid'] == $parm_year ? 'selected="selected"' : '').'>'.$row['name'].'</option>';
						    }
						    
						    ?>
						</select>
						<div class="tj_dazong">
							大众排行榜：
						</div>
						<select class="tj_dazong1 tj_box1_font" name="commonage">
						    <?php 
						    foreach ($groom_comm_list as $row){
						        echo '<option value="'.$row['cid'].'" '.($row['cid'] == $parm_comm ? 'selected="selected"' : '').'>'.$row['name'].'</option>';
						        
						    }
						    
						    ?>
						</select>
						<div class="tj_shaixuan">
							筛选：
						</div>
						<script>
							$(function() {
								$(".tj_shaixuan1").focus(function() {
									var _length = $(this).find('option').length;
									$(this).stop().animate({
										"height": (_length * 19 + 2).toString() + 'px',
									}, 300)
								});
								$(".tj_shaixuan1").blur(function() {
									$(this).stop().animate({
										"height": '21px',
									}, 300)
								});
							});
							
						</script>

						<select class="tj_shaixuan1 tj_box1_font" style="height: 21px;position: relative;z-index: 99;" name="filter">
						    <?php 
						    foreach ($filter_data as $f){
						        $selected = $f['id'] == $parm_filter ? 'selected="selected"' : '';
						        echo <<<EOT
<option $selected value="{$f['id']}">{$f['word']}</option>
EOT;
						        
						    }
						    
						    
						    ?>
						</select>
					</div>
					<div class="tj_box2">
						<div class="arrow_left2">
							<img src="img/friend/fd_fds_left.png" class="tj_box2_left" />
						</div>
						<div class="arrow_right2">
							<img src="img/friend/fd_fds_lf.png" class="tj_box2_right" />
						</div>
						<div class="tj_box2_ct_bag">

							<script>
								 ///////////////////雪茄轮播2/////////////////////////
								$(function() {
									$(".arrow_left2").stop().animate({
										opacity: 0.5
									}, 0);
									var _now_num2 = 1;
									$(".tj_box2_content .item:eq(3) .tips").attr("class","tips_active")
									var _sum = $(".tj_box2_content").find(".item").length;
									$(".tj_box2_content").css({
										'width': _sum * 300 + 'px'
									});
									$(".arrow_left2").click(function() {
										_now_num2--;
										if (_now_num2 <= 1) {
											_now_num2 = 1;
											$(this).stop().animate({
												opacity: 0.4
											}, 300);
										} else {
											$(".arrow_right2").stop().animate({
												opacity: 1
											}, 300);
										}
										move_content();
									});
									$(".arrow_right2").click(function() {
										_now_num2++;
										if (_now_num2 >= (_sum - 3)) {
											_now_num2 = (_sum - 3);
											$(this).stop().animate({
												opacity: 0.4
											}, 300);
										} else {
											$(".arrow_left2").stop().animate({
												opacity: 1
											}, 300);
										}
										move_content()
									});

									function move_content() {
										var _aim = _now_num2 + 2;
										$(".tj_box2_content").stop().animate({
											'left': (-((_now_num2 - 1) * 190).toString() + "px")
										}, 800);
										$(".tj_box2_content .tips,.tj_box2_content .tips_active").attr("class", "tips");
										$('.tj_box2_content .item:eq(' + _aim + ')').find('.tips').attr('class', 'tips_active');
									}
								});
							</script>

							<div class="tj_box2_view">
								<div class="tj_box2_content">
                                    
                                    
                                    <?php 
                                    
                                    $i = 1;
                                    foreach ($show_data as $index => $row){
                                        $id = $salt->encode(1,$row['pid']);
										
										$imid = $row['imid'];
										$size = $row['size'];
										$style = '';
										if($size > 0 && $size < 10){
											$tmp = $size * 42;
											$style = 'height: '.$tmp.'px;';
										}
										
                                        $taste_data = C::t('cigar_taste')->data($row['pid'],$uid);
								
                                        
                                        $radio_html = '';
                                        if ($taste_data && isset($taste_data['taste']) && $taste_data['taste'] == 1){
                                            $radio_html = <<<EOT
                <input type="radio" name="options_ev$index" value="1" checked="checked" />我尝试过
				<input type="radio" name="options_ev$index" value="0" />我想尝试
EOT;
                                        }else{
                                            $radio_html = <<<EOT
                <input type="radio" name="options_ev$index" value="1" />我尝试过
				<input type="radio" name="options_ev$index" value="0" checked="checked" />我想尝试
EOT;
                                        }
                                        
                                        echo <<<EOT
<div class="item">
                                        
	<div class="tj_box2_ct_tianjia">
		<button class="tj_box2_ct_tj_bag" id="$imid">
			<div class="tj_box2_ct_tj_font">
				添加到
				<br />雪茄盒
			</div>
		</button>
		<div class="tj_box2_ct_no">
			No Thanks
		</div>
	</div>
	<div class="tj_box2_ct_mingci">
		第 $i 名
		<br />{$row['rank']}分
	</div>
	<div class="tj_box2_ct_cigar">
	
		<img src="{$row['image']}" style="width: 40px;$style" />
                                        
		<!-------tips-->
		<div class="tips">
			<div class="tips_top">
				{$row['name']}
			</div>
			<div class="tips_middle">
				产地：{$row['oName']}
				<br /> 粗度：{$row['width']} 长度：{$row['length']}
			</div>
			<div class="tips_foot" id="$id">
				$radio_html
			</div>
			<div class="tips_foot1" id="$id">
				添加到雪茄盒
			</div>
		</div>
		<!--------tips结束-->
	</div>
                                        
</div>
EOT;
                                        $i++;
                                        
                                    }
                                    
                                    ?>
									

								</div>

							</div>
						</div>

					</div>
				</div>

				<div class="fd_content item_body" id="itembody3">
					<div class="fd_ct_1">
						<div class="fd_ct_1_left">
							点击你的好友，看看他都有什么
						</div>
						<div class="fd_ct_1_right">
							<div class="fd_fds">
								查看好友</br>
								的雪茄盒
							</div>
						</div>
					</div>
					<div class="fd_ct_2">
						
						<div class="fd_list">
						<?php 
						
						foreach ($friend_data as $row){
						    
						    $name = $row['note'] == '' ? $row['fusername'] : $row['note'];
						    $sign = $row['sightml'] == '' ? '该用户很懒,并没有签名' : $row['sightml'];
						    if (strlen($sign) > 9){
						        $sign = substr($sign, 0,31);
						    }
						    
						    echo <<<EOT
<div class="fd_fd1">
    <input type="hidden" name="uid" value="{$row['fuid']}" />
	<div class="fd_fd1_head">
		<img style="width: 60px;height: 60px;" src="uc_server/avatar.php?uid={$row['fuid']}&size=small"/>
	</div>
	<div class="fd_fd1_jiejian">
	   
		<div class="fd_fd1_name">
			<a href="home.php?mod=space&uid={$row['fuid']}" style="color: black;" >$name</a>
		</div>
		
		<div class="fd_fd1_qianming">
			$sign
		</div>
	</div>
</div>
EOT;
						}
						
						
						
						?>

					</div>


                    <div class="fd_cigar_"> 
                    
				        <div class="no_data_tip">
				            <img src="images/caution.png" width="48px" height="48px" />请点击左侧好友查询他们的雪茄盒
				        </div>
					
					</div>
					
					
			    	<div class="fd_fds_left"> </div>
					<div class="fd_fds_right"> </div>
					
				</div>

			</div>
		</div>

        <?php echo_footer();?>
	</body>

</html>