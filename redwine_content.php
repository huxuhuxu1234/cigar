<?php 

require_once 'util.php';
require_once 'salt.php';


$id = -1;

if (isset($_GET['id'])){
    $id = $salt->decode($_GET['id']);
}

if ($id == -1){
    header('Location: product.php' );
    exit();
}

$data = C::t('cigar_redwine_detail')->fetch($id);
if (!$data || !isset($data['pid'])){
    header('Location: product.php' );
    exit();
}

$base_data = C::t('cigar_products')->fetch($id);


//需要找到 要显示的第一张图片
$show_images = array();
if ($data['image1']){
    $show_images[] = $data['image1'];
}
	
if ($data['image2']){
    $show_images[] = $data['image2'];
}

if ($data['image3']){
    $show_images[] = $data['image3'];
}
	
if ($data['image4']){
    $show_images[] = $data['image4'];
}
	
if ($data['image5']){
    $show_images[] = $data['image5'];
}

$real_count = C::t('cigar_evaluates')->_count($id);
$detail = C::t('cigar_products_detail')->pid_data($id);

$like_num = isset($data['up_count']) ? $data['up_count'] : 0;
$like_num += C::t('cigar_evaluates')->like_redwine($id);

//我的评分数据
$uid = $_G['uid'];
if ($uid != 0){
    $my_ev_data = C::t('cigar_evaluates')->ev_data($id,$uid);
}
$my_ev_data_script = '';
if ($my_ev_data && isset($my_ev_data['taste']))    {
    $t_ = $my_ev_data['taste'] - 1;
    if ($t_ >= 0){
        $my_ev_data_script .= '$(".star,.starshow")['.$t_.'].click();';
    }
    $e_ = $my_ev_data['exterior'] - 1;
    if ($e_ >= 0){
        $my_ev_data_script .= '$(".star1,.starshow1")['.$e_.'].click();';
    }
    $c_ = $my_ev_data['cost_performance'] - 1;
    if ($c_ >= 0){
        $my_ev_data_script .= '$(".star2,.starshow2")['.$c_.'].click();';
    }
}

?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title><?php echo $base_data['name'];?> - 产品 - <?php echo $_MCONFIG['title'];?></title>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/top.css" />
		<link rel="stylesheet" type="text/css" href="css/hongjiuxiangqing.css" />
		<link rel="stylesheet" type="text/css" href="css/foot.css" />

		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/imageZoom.js" ></script>
		
		<?php echo_web_keywords_and_descr();?>

		<!-- 星星打分JS    !-->	
		<script type="text/javascript">
			$(document).ready(function() {
				$(".star,.starshow").mouseover(function() {
					var flag = $(this).parent().attr("states");
					if (flag==1) {
						var num = parseInt($(this).attr("rel"));
						$(".star,.starshow").each(function() {
							if (parseInt($(this).attr("rel")) <= num) {
								$(this).attr("class", "starshow")
							} else {
								$(this).attr("class", "star")
							}
						});
					} else {
					}
				});
				
				$(".star1,.starshow1").mouseover(function() {
					var flag = $(this).parent().attr("states");
					if (flag==1) {
						var num = parseInt($(this).attr("rel"));
						$(".star1,.starshow1").each(function() {
							if (parseInt($(this).attr("rel")) <= num) {
								$(this).attr("class", "starshow1")
							} else {
								$(this).attr("class", "star1")
							}
						});
					} else {
					}
				});
				
				$(".star2,.starshow2").mouseover(function() {
					var flag = $(this).parent().attr("states");
					if (flag==1) {
						var num = parseInt($(this).attr("rel"));
						$(".star2,.starshow2").each(function() {
							if (parseInt($(this).attr("rel")) <= num) {
								$(this).attr("class", "starshow2")
							} else {
								$(this).attr("class", "star2")
							}
						});
					} else {
					}
				});
				
				$(".star,.starshow").click(function() {
					var num = parseInt($(this).attr("rel"));
					$('#high-star').attr("value",num);
					$(this).parent().attr("states","2");
					$(".star,.starshow").each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow")
						} else {
							$(this).attr("class", "star")
						}
					});
					var string1 = $(this).attr("title");
					$('.star-content').html(string1);
				});
				
				$(".star1,.starshow1").click(function() {
					var num = parseInt($(this).attr("rel"));
					$('#high-star1').attr("value",num);
					$(this).parent().attr("states","2");
					$(".star1,.starshow1").each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow1")
						} else {
							$(this).attr("class", "star1")
						}
					});
					var string1 = $(this).attr("title");
					$('.star-content1').html(string1);
				});
				
				$(".star2,.starshow2").click(function() {
					var num = parseInt($(this).attr("rel"));
					$('#high-star2').attr("value",num);
					$(this).parent().attr("states","2");
					$(".star2,.starshow2").each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow2")
						} else {
							$(this).attr("class", "star2")
						}
					});
					var string1 = $(this).attr("title");
					$('.star-content2').html(string1);
				});
			
				/*$(".star,.starshow").mouseout(function(){
					$(".star,.starshow").each(function() {
						$(this).attr("class","star");
					};
				});*/
				$(".star,.starshow").mouseout(function(){
					$(".starshow").each(function(){
						$(this).attr("class","star");
					});
					var num = $("#high-star").attr("value");
					$(".star,.starshow").each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow")
						} else {
							$(this).attr("class", "star")
						}
					});
				});
				
				$(".star1,.starshow1").mouseout(function(){
					$(".starshow1").each(function(){
						$(this).attr("class","star1");
					});
					var num = $("#high-star1").attr("value");
					$(".star1,.starshow1").each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow1")
						} else {
							$(this).attr("class", "star1")
						}
					});
				});
				
				$(".star2,.starshow2").mouseout(function(){
					$(".starshow2").each(function(){
						$(this).attr("class","star2");
					});
					var num = $("#high-star2").attr("value");
					$(".star2,.starshow2").each(function() {
						if (parseInt($(this).attr("rel")) <= num) {
							$(this).attr("class", "starshow2")
						} else {
							$(this).attr("class", "star2")
						}
					});
				});
			
			});
		</script>

		
		<!-- 点击小图片切换大图片JS    !-->	
		<script>
			$(document).ready(function(){

			    //点击左右切换按钮，切换小图标backgroundJS
				$(".first_line_left_img2_content:first").css({
					"background":'url(img/hongjiuxiangqing/firstimg_background.png)',
				})
			    
				
				$(".first_line_left_img2_content img").click(function(){
					$(".first_line_left_img2_content").css({
						"background":'',
					});
					$(this).parent().css({
						"background":'url(img/hongjiuxiangqing/firstimg_background.png)',
					});
					var _src = $(this).attr('src');
// 					_src = _src.substring(0,(_src.length-4))+"2.png";
					$(".first_line_left_img").attr("src",_src);
					$(".large").css({
						"background":"url(" + _src + ") no-repeat",
					});
				});


				<?php 
				//修改默认的图
				if (count($show_images) == 0){
				    //没有需要显示的图片
				    echo '$(".large").css("background","none");';
				}else{
				    echo '$(".large").css("background","url('.$show_images[0].') no-repeat");';
				}
				
				
				
				//输出评分脚本
				echo $my_ev_data_script;
				?>

				// Uses default setting.
				$(".magnify").imageZoom();
				
				
				//我喜欢它 按钮
				$('.text4_img').click(function(){
					$.post('action.php?action=redwine_like',{"id": '<?php echo $_GET['id'];?>'},function(data){
						switch(data.errorCode){
							case '1':
							alert('请登录后重试');
							return;
							case '2':
							alert('请刷新页面后重试');
							return;
							case '3':
							alert('您已经为这款红酒点过赞了');
							return;
							case '0':
							alert('点赞成功');
							history.go(0);
							return;
							
						}						
					},'json');
				});
				
				//防止红酒内容过多 元素下滑
				var limit = 175;
				var now_l = $('.fivith_line').height() + $('.third_line').height();
				if(now_l > limit){
					//调整
					var ret = now_l - limit;
					$('.banner_bag').css('height',(ret+$('.banner_bag').height()) + 'px');
					$('.banner_middle').css('height',(ret+$('.banner_middle').height()) + 'px');
				}
			});
		</script>
	
	</head>

	<body>
		
		<?php echo_header();?>
		
		<div class="banner_bag">
			<div class="banner_bag_top">
				<div class="banner_bag_top_list">
					<a href="./" class="banner_bag_top_a">首页</a>&nbsp;>&nbsp;
					<a href="product.php" class="banner_bag_top_a">产品</a>&nbsp;>&nbsp;
					<a href="" class="banner_bag_top_a">红酒品味</a>&nbsp;>&nbsp;
					<a href="" class="banner_bag_top_a"><?php echo $base_data['name'];?></a>
				</div>
			</div>

			<div class="banner_middle">
				<div class="first_line">
					<div class="first_line_left">
						<!--first_line_left_img1-->
						<div class="first_line_left_img1">
							<div class="magnify">		
								<div class="large" >
				
								</div>
								<img class="first_line_left_img" src="<?php echo $data['image1'];?>" width="400px" height="400px"/>
							</div>
						</div>
						
						
						
						
						<div class="first_line_left_img2">
							
							<?php 
							//输出底部图片
							if ($data['image1']){
							    echo <<<EOT
<div class="first_line_left_img2_content" >
	<img src="{$data['image1']}" width="45px" height="44px"/>
</div>
EOT;
							}
							
							if ($data['image2']){
							    echo <<<EOT
<div class="first_line_left_img2_content" >
	<img src="{$data['image2']}" width="45px" height="44px"/>
</div>
EOT;
							}
							
							
							if ($data['image3']){
							    echo <<<EOT
<div class="first_line_left_img2_content" >
	<img src="{$data['image3']}" width="45px" height="44px"/>
</div>
EOT;
							}
							
							if ($data['image4']){
							    echo <<<EOT
<div class="first_line_left_img2_content" >
	<img src="{$data['image4']}" width="45px" height="44px"/>
</div>
EOT;
							}
							
							if ($data['image5']){
							    echo <<<EOT
<div class="first_line_left_img2_content" >
	<img src="{$data['image5']}" width="45px" height="44px"/>
</div>
EOT;
							}
							
							?>
							
						</div>
					</div>
					
					<div class="first_line_right">
						<div class="first_line_right_text1">
							<?php echo nl2br($base_data['name']);?>
						</div>
						<div class="first_line_right_text2">
							<div class="text2_1_left"><?php echo '类型：'.$data['type'].'容量：' . $data['capacity'];?></div>
							<div class="text2_1_right">产地：<?php echo $data['regions'];?> </div>
							<div class="text2_2_left">酒庄：<?php echo $data['chateau'];?></div>
							<div class="text2_2_right">级别：<?php echo $data['level'];?></div>
							<div class="text2_3_left">适饮温度：<?php echo $data['drinktemp']?> </div>
							<div class="text2_3_right">葡萄品种：<?php echo $data['grape_varieties']; ?></div>
						</div>
						<div class="first_line_right_text3">
							<div class="text3_1">评分:</div>
							<?php 
							echo <<<EOT
<div class="text3_2_left">{$data['score1']}</div>
<div class="text3_2_right">{$data['score2']}</div>
<div class="text3_3_left">{$data['score3']}</div>
<div class="text3_3_right">{$data['score4']}</div>
<div class="text3_4_left">{$data['score5']}</div>
<div class="text3_4_right">{$data['score6']}</div>
EOT;
							
							?>
							

						</div>
						<div class="first_line_right_text4">
							<div class="text4_1">
								有<div class="text4_1_num"><?php echo $like_num;?></div>个人喜欢他
							</div>
							<img class="text4_img" src="img/hongjiuxiangqing/i-like-it.png" />
						</div>
					</div>

				</div>

				<?php 
				$ext1 = $data['ext1_content'];
				$ext2 = $data['ext2_content'];
				
				echo <<<EOT
<div class="second_line">
	{$data['ext1_title']}
</div>

<div class="third_line">
    $ext1
</div>

<div class="fourth_line">
	{$data['ext2_title']}
</div>

<div class="fivith_line">
	$ext2
</div>
EOT;
				?>
				

				<div class="sixth_line">
					会员评价
				</div>

				<div class="seven_line">
					<div class="seven_line_left">
						<div class="seven_line_left_first"> 
							<div class="seven_line_left_first_part1">各项指标得分</div> (&nbsp;已有<?php echo $real_count + $detail['evaluate_count'];?>人参与评分，<div class="seven_line_left_first_part2">可信度<?php echo $detail['reliability'];?>%</div>）
						</div>
						<div class="seven_line_left_second">口味：</div>
						<div class="seven_line_left_img">
						
						<?php 
						
						//口味得分
						$taste = (int)C::t('cigar_evaluates')->_avg($id,'taste');
						if ($real_count == 0){
						    $taste = $detail['taste'];
						}
						$i = 0;
						$star_html = '';
						for (;$i < $taste;$i++){
						    $star_html .= '<img src="img/protect_show/show_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
						
						}
							
						for (;$i < 5 ; $i++){
						    $star_html .= '<img src="img/protect_show/hide_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
						    	
						}
						
						echo <<<EOT
$star_html
<div class="star-content3" >{$taste}&nbsp;分</div>
EOT;
						
						?>
						
						</div>

						<div class="seven_line_left_third">外观：</div>
						<div class="seven_line_left_img">
						<?php 
							
							         //外观得分
    			              $exterior = (int)C::t('cigar_evaluates')->_avg($id,'exterior');
    			              if ($real_count == 0){
    			                  $exterior = $detail['exterior'];
    			              }
							$i = 0;
							$star_html = '';
							for (;$i < $exterior;$i++){
							    $star_html .= '<img src="img/protect_show/show_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
							}
								
							for (;$i < 5 ; $i++){
							    $star_html .= '<img src="img/protect_show/hide_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
							}    
								
							         echo <<<EOT
$star_html							        
<div class="star-content4" > {$exterior}&nbsp;分</div>
EOT;
							
							
							     ?>
						</div>

						<div class="seven_line_left_four">性价比：</div>
						<div class="seven_line_left_img">
						    
						    <?php 
							
    				             //性价比得分
    				              $cost_p = (int)C::t('cigar_evaluates')->_avg($id,'cost_performance');
    				              if ($real_count == 0){
    				                  $cost_p = $detail['cost_performance'];
    				              }
								$i = 0;
								$star_html = '';
								for (;$i < $cost_p;$i++){
								    $star_html .= '<img src="img/protect_show/show_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
								}
									
								for (;$i < 5 ; $i++){
								    $star_html .= '<img src="img/protect_show/hide_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
								}    
								
							         echo <<<EOT
$star_html							        
<div class="star-content5" > {$cost_p}&nbsp;分</div>
EOT;
							
							
						     ?>
						</div>

						<div class="seven_line_left_five">综合：</div>
						<div class="seven_line_left_img">
						<?php 
							
							         //综合得分
							    $p = (int) (($taste + $cost_p + $exterior) / 3);
								$i = 0;
								$star_html = '';
								for (;$i < $p;$i++){
								    $star_html .= '<img src="img/protect_show/show_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
								}
									
								for (;$i < 5 ; $i++){
								    $star_html .= '<img src="img/protect_show/hide_star.png" width="18px" height="17px" style="margin-right: 5px;"/>';
								}    
								
							         echo <<<EOT
$star_html							        
<div class="star-content6" >{$p}&nbsp;分</div>
EOT;
							
							
							     ?>
						</div>
					</div>
					
					<div class="pingfen_fenge1">
						
					</div>

					<div class="seven_line_right">
						<div class="seven_line_right_first">
							<div class="wodepingfen">
								我的评分
							</div>(&nbsp;如有疑问请到<a href="discuz/" ><div class="seven_line_right_first_part1">论坛</div></a>提出&nbsp;)
						</div>
						
						<form action="action.php?action=ev_point" method="post">

						<div class="seven_line_right_second">口味：</div>
						<div class="seven_line_right_img"  states = "1">
							<div class="star" rel="1" title="1分"></div>
							<div class="star" rel="2" title="2分"></div>
							<div class="star" rel="3" title="3分"></div>
							<div class="star" rel="4" title="4分"></div>
							<div class="star" rel="5" title="5分"></div>
							<div class="star-content" ></div>
							<input type="hidden" value="0" name="taste" id="high-star">	
						</div>

						<div class="seven_line_right_third">外观：</div>
						<div class="seven_line_right_img" states = '1'>
							<div class="star1" rel="1" title="1分"></div>
							<div class="star1" rel="2" title="2分"></div>
							<div class="star1" rel="3" title="3分"></div>
							<div class="star1" rel="4" title="4分"></div>
							<div class="star1" rel="5" title="5分"></div>
							<div class="star-content1" ></div>
							<input type="hidden" value="0" name="exterior"  id="high-star1">	
						</div>

						<div class="seven_line_right_four">性价比：</div>
						<div class="seven_line_right_img" states = "1">
							<div class="star2" rel="1" title="1分"></div>
							<div class="star2" rel="2" title="2分"></div>
							<div class="star2" rel="3" title="3分"></div>
							<div class="star2" rel="4" title="4分"></div>
							<div class="star2" rel="5" title="5分"></div>
							<div class="star-content2" ></div>
							<input type="hidden" value="0" name="cost_p"  id="high-star2">	
						</div>

						<div class="seven_line_right_five">请在上方评分区选择你的评分</div>
						<div class="seven_line_right_last">
							<input type="image" src="img/hongjiuxiangqing/tijiaopingfen.png" />
						</div>
						<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"  />
						</form>
					</div>
				</div>
			</div>

		</div>

		
	<?php echo_footer();?>
		
	</body>

</html>