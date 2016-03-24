<?php 

require_once 'util.php';
require_once 'salt.php';

//固定数据
//获得所有的类别信息
$type_data = C::t('cigar_types')->_list();



//获取所有的品牌
$t1_brands = C::t('cigar_brands')->_list($type_data[0]['tid']);
$t2_brands = C::t('cigar_brands')->_list($type_data[1]['tid']);
$t3_brands = C::t('cigar_brands')->_list($type_data[2]['tid']);
$t4_brands = C::t('cigar_brands')->_list($type_data[3]['tid']);


// 获取高级搜索的具体子项
$_search = C::t('cigar_search')->fetch_data();


$show_brand = 0;
$type = 0;
$search = FALSE;
if (isset($_GET['key'])){
    if ($_GET['key'] == 'search'){
        $search = TRUE;
    }
}

if (isset($_GET['brand']) && isset($_GET['type'])){
    $show_brand = $_GET['brand'];
    $type = $_GET['type'];
    if (!is_numeric($show_brand) || !is_numeric($type)){
        $show_brand = $t1_brands[0]['bid'];
        $type = 0;
    }
    if(!C::t('cigar_brands')->check_type($type_data[$type]['tid'],$show_brand)){
        header('Location: ./');
    }
}else{
    $show_brand = $t1_brands[0]['bid'];
}

if ($type < 0 || $type > 4){
    $type = 0;
}

$show_type_script = '$(".banner_bag_main_all_left_img1_name:eq('.$type.')").click();';
if ($search){
    $type = 0;
    $show_type_script = '$(".banner_bag_main_all_left_img1_name:eq(4)").click();';
}



$show_data = FALSE;
//先判断search
if ($search){
    $id = 0;
    if ($_GET['id']){
        $id = $_GET['id'];
    }
    $data = C::t('cigar_search')->fetch($id);
    if (!$data && !isset($data['condition'])){
        header('Location: ?');
        exit();
    }
//     exit($data['condition']);
    $show_data = C::t('cigar_products')->_cigar_filter($data['condition']);
}else
if ($type == 0){
    $show_data = C::t('cigar_products')->select('brand',$show_brand);
}else{
    $_t_count = C::t('cigar_products')->_count('brand',$show_brand);
    $total_page = $_t_count % 8 == 0 ? $_t_count/ 8 : (int)($_t_count / 8) + 1;

    $now_page = 0;
    if (isset($_GET['page'])){
        if (is_numeric($_GET['page'])){
            $now_page = $_GET['page'];
        }
    }
    if ($now_page <= 0 || $now_page > $total_page){
        $now_page = 1;
    }
    
    $show_data = C::t('cigar_products')->page($now_page,$show_brand);
    //翻页信息
    $index_page = '';
    $pri_page = '';
    if($now_page != 1){
        $index_page = '<a href="?type='.$type.'&brand='.$show_brand.'&page=1" class="right_line3_first" rel="1">首页 </a>';
//         $index_page = '<a href="?page=1" class="second_part_left_second_content1">首页 </a>';
        $pri_page = '<a href="?type='.$type.'&brand='.$show_brand.'&page='.($now_page-1).'" class="right_line3_content" rel="2" id="bottom_content2" style="width: auto;">上一页</a>';
//         $pri_page = '<a href="?page='.($now_page-1).'"class="second_part_left_second_content1" style="margin-left: 0px;">上一页</a>';
    }
    
    $end_page = '';
    $next_page = '';
    if($now_page != $total_page){
//         $end_page = '<a href="?page='.$total_page.'" class="second_part_left_second_content9">尾页</a>';
//         $next_page = '<a href="?page='.($now_page + 1).'" class="second_part_left_second_content10" >下一页</a>';
        $end_page = '<a href="?type='.$type.'&brand='.$show_brand.'&page='.$total_page.'" class="right_line3_last ">尾页</a>';
        $next_page = '<a href="?type='.$type.'&brand='.$show_brand.'&page='.($now_page + 1).'" class="right_line3_weiye" rel="1">下一页</a>';
    }
    
}


//调整ui尺寸的Js脚本
$resize_ui_js_ = <<<EOT
$('.banner_bag').css('height','750px');
$('.banner_bag_main_all_right').css('height','690px');
$('.banner_bag_main_all_left').css('height','410px');
EOT;

?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>产品 - <?php echo $_MCONFIG['title'];?></title>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/top.css" />
		<link rel="stylesheet" type="text/css" href="css/product.css" />
		<link rel="stylesheet" type="text/css" href="css/foot.css" />
		<link rel="stylesheet" href="css/index_cebianlan.css" />
		
		<?php echo_web_keywords_and_descr();?>
		
		<style type="text/css">
    
        .brand_content{ scrollbar-track-color: #201716; scrollbar-base-color: #533e35;height: 220px; overflow: auto; display: block; overflow-x: hidden; display: none;}
		
		.right_line1_img_middle a:hover{text-decoration: underline; color: black;}
        </style>

		<!--   轮播JS     -->

		<script>
			//轮播页面
			$(function() {
				var _sum = $(".list_content").find('.img').length;

				var _n_id = 1;

				$('.list_content .img1:eq(4)').find('.tips').attr('class', 'tips_active');

				$(".list_content").css({
					'width': _sum * 132 + 'px'
				});

				$(".right_img").click(function() {
					if (_n_id < (_sum - 4)) {
						_n_id++;
					} else {
						_n_id = 1;
					}
					_list_move((_n_id - 1) * 132, _n_id, _sum);

				});

				$(".left_img").click(function() {
					if (_n_id <= 1) {
						_n_id = (_sum - 4);
					} else {
						_n_id--;
					}
					_list_move((_n_id - 1) * 132, _n_id, _sum);
				});

				$('.right_part2').click(function() {
					var x = event.offsetX - 20;
					if (x < 0) {
						_n_id = 1;
					}
					if (x > 700) {
						_n_id = (_sum - 4);
					}

					var _sg_wth = 700 / (_sum - 5);

					_n_id = Math.ceil(x / _sg_wth + 0.5)

					_list_move((_n_id - 1) * 132, _n_id, _sum);

				});
				
				
				$('.img').click(function(){
					var top = $(this).css('top');
					if( !top ){
						return ;
					}
					if( top != '-40px'){
						$(this).animate({top: '-40px'});
					}else{
						$(this).animate({top: '0px'});
					}
				});
			});

			function _list_move(_left, id, sum) {
				$(".list_content").stop().animate({
					'margin-left': -_left + 'px',
				});

				var _btn_lf = Math.ceil((id - 1) / (sum - 5) * 680) + 'px';

				$('.gundongtiao').stop().animate({
					'left': _btn_lf
				}, 500);

				$('.list_content .tips,.list_content .tips_active').attr('class', 'tips');

				$('.list_content .img1:eq(' + (id + 3).toString() + ')').find('.tips').attr('class', 'tips_active')
			}
		</script>
		

		<script>
			$(document).ready(function() {
				$(".banner_bag_main_all_left_img1_name").click(function() {
					$(".banner_bag_main_all_left_img1 .text").hide();
					$(".banner_bag_main_all_left_img1").css("background", "url(img/product/img1.png) no-repeat");
					$(".banner_bag_main_all_left_img1 .left_list_search").hide();
					$(".banner_bag_main_all_left_img1 .brand_content").hide();
					var flag1 = parseInt($(this).parent().attr("flag"));
					if (flag1 == 0) {
						$(".banner_bag_main_all_left_img1").attr("flag", 0);
						$(this).parent().find(".text").show();
						$(this).parent().find('.brand_content').show();
						$(this).parent().find(".left_list_search").show();
						$(this).parent().attr("flag", 1);
					} else {
						$(".banner_bag_main_all_left_img1").attr("flag", 0);
						$(this).parent().find(".text").hide();
						$(this).parent().find(".left_list_search").hide();
						$(this).parent().find('.brand_content').hide();
						$(this).parent().attr("flag", 0);
					}
					var flag2 = parseInt($(this).parent().attr("flag"));
					if (flag2 == 1) {
						$(this).parent().css("background", "url(img/product/title_down.png) no-repeat");
					} else {
						$(this).parent().css("background", "url(img/product/img1.png) no-repeat")
					}
				});

				<?php echo $show_type_script; ?>
			});
		</script>

	
		
		<script>
			$(document).ready(function() {
				
				$(".right_line1_img_bottom").each(function(index){
					$(this).click(function(){
						var pre = '#tool_tip' + (index+1);
						$(pre).show();
						$('#tool_tip').show();
					});
				});
				
				$(".tool_tip_detil_bottom").each(function(index){
					$(this).click(function(){
						var pre = '#tool_tip' + (index+1);
						$(pre).hide();
						$('#tool_tip').hide();
					});
				});
				
				


				// 调整尺寸
				<?php 
                    //如果不是雪茄的话就调整尺寸
				    if ($type != 0){ echo $resize_ui_js_;}
                   
                ?>
                
                var h = $('body').height();
                var w = $('width').width();
                var t = $('#tool_tip');
                t.css('height',h+'px');
                t.css('width',w+'px');
			});
			
			
		</script>

	</head>

	<body>
		
		<?php echo_header(); ?>
		
		<?php echo_slide();?>
		
		
		<div class="banner_bag">
			<div class="banner_bag_top">
				<div class="banner_bag_top_list">
					<a href="./" class="banner_bag_top_a">首页</a>&nbsp;>&nbsp;
					<a href="product.php" class="banner_bag_top_a">产品</a>
				</div>
			</div>

			<div class="banner_bag_main">
				<div class="banner_bag_main_all">
					<div class="banner_bag_main_all_left">

						<!--左侧五个导航标题，品牌，雪茄用具等------->
						<div class="banner_bag_main_all_left_img1" id="name1" flag="0">
							<!-------第一行，即名字---------->
							<div class="banner_bag_main_all_left_img1_name">
								<?php echo $type_data[0]['value'];?>
							</div>
							
							
							<div class="brand_content">
							<?php 
							//输出所有品牌
							
							foreach ($t1_brands as $brand){
							    $c = C::t('cigar_products')->_count('brand',$brand['bid']);
							    
							    echo <<<EOT
<a href="?type=0&brand={$brand['bid']}">
<div class="text" id="text1" title="{$brand['value']}">
	{$brand['value']} ($c)
</div>	</a>			    
EOT;
							    
							}
							
							?>
							</div>

						</div>

						<div class="banner_bag_main_all_left_img1" id="name2" flag="0">

							<div class="banner_bag_main_all_left_img1_name">
								<?php echo $type_data[1]['value'];?>
							</div>
							
							
							<div class="brand_content">
							<?php 
							//输出所有品牌
							
							foreach ($t2_brands as $brand){
							    $c = C::t('cigar_products')->_count('brand',$brand['bid']);
							    
							    echo <<<EOT
<a href="?type=1&brand={$brand['bid']}">
<div class="text" id="text1" title="{$brand['value']}">
	{$brand['value']} ($c)
</div>		</a>			    
EOT;
							    
							}
							
							?>
							</div>

				
						</div>

						<div class="banner_bag_main_all_left_img1" id="name3" flag="0">

							<div class="banner_bag_main_all_left_img1_name">
								<?php echo $type_data[2]['value'];?>
							</div>

							
							<div class="brand_content">
							<?php 
							//输出所有品牌
							
							foreach ($t3_brands as $brand){
							    $c = C::t('cigar_products')->_count('brand',$brand['bid']);
							    
							    echo <<<EOT
<a href="?type=2&brand={$brand['bid']}">
<div class="text" id="text1" title="{$brand['value']}">
	{$brand['value']} ($c)
</div>				</a>	    
EOT;
							    
							}
							
							?>
							</div>
							
						</div>

						<div class="banner_bag_main_all_left_img1" id="name4" flag="0">
							<div class="banner_bag_main_all_left_img1_name">
								<?php echo $type_data[3]['value'];?>
							</div>
							
							<div class="brand_content">
							
							<?php 
							//输出所有品牌
							
							foreach ($t4_brands as $brand){
							    $c = C::t('cigar_products')->_count('brand',$brand['bid']);
							    
							    echo <<<EOT
<a href="?type=3&brand={$brand['bid']}">
<div class="text" id="text1" title="{$brand['value']}">
	{$brand['value']} ($c)
</div>					    </a>
EOT;
							    
							}
							
							?>
							</div>

						</div>

						<div class="banner_bag_main_all_left_img1" id="name5" flag="0">
							<div class="banner_bag_main_all_left_img1_name">
								<?php echo $type_data[4]['value'];?>
							</div>

							<!-------------------------------------高级搜索end-------------------------------->
							<div class="left_list_search">
								
								<?php 
								
								foreach ($_search as $s){
								    echo <<<EOT
<a href="?key=search&id={$s['id']}" >{$s['word']}</a>
EOT;
								    
								}
								
								?>
								
							</div>

						</div>
					</div>

					<div class="banner_bag_main_all_right">

							
							<?php 
							//显示雪茄数据
							if ($type == 0){
							    //雪茄
							    echo <<<EOT
<div class="right_part1">
    
<div class="left_img">
	<img src="img/product/me_left.png" />
</div>
EOT;
							    echo '<div class="list_view" style="height: 403px;"><div class="list_content">';
							    
							    if (!$show_data){
							        echo '<p class="no_data_cigar"><img src="images/caution.png" width="48px" height="48px"/><span>无数据可用于展示</span> <p>';
							    }else {
							        //输出数据
							        $i = 1;
							        foreach ($show_data as $row){
							            $id = $salt->encode(1,$row['pid']);
							            
							            echo <<<EOT
<div class="img1" id="right_img$i">
	<img class="img" src="{$row['image']}" />
	<div class="tips">
		<div class="tips_top">
			{$row['name']}
		</div>

		<div class="tips_middle">
			制造产地：{$row['origin']}
			<br />浓度：{$row['consistence']}
			<br />制作方式：{$row['make_mode']}
			<br />
		</div>

        <a href="product_show.php?id=$id">
		<div class="tips_foot">
			了解更多
		</div>
        </a>
	</div>
</div>
EOT;
			if (++$i > 4){
			    $i = 1;
			}
							            
							        }
							        
							    }
							    
							    echo <<<EOT
</div></div> 
	<div class="right_img">
		<img src="img/product/me_right.png" />
	</div>
</div>

<div class="right_part2">
	<div class="gundongtiao">
	</div>
</div>
EOT;
							}else{
							    //其他的
							    
							    //雪茄用具，  红酒，等等
        
							    if (!$show_data){
							        echo '<p class="no_data"><img src="images/caution.png" width="48px" height="48px"/><span>无数据可用于展示</span> <p>';
							        
							    }else{
							        // 1 - 4
							        echo '<div class="right_line1">';
							        	
							        for ($i = 0; $i < 4; $i++){
							             
							            if (!isset($show_data[$i])){
							                continue;
							            }
							             
							            $row = $show_data[$i];
							            $i_plus_1 = $i+1;

							            $quick_see = '<button class="right_line1_img_bottom"></button>';
										$href = 'href="javascript:void(0);"';
							            if ($type == 3){
							                //红酒跳转
											$href='href="redwine_content.php?id='.$salt->encode(1,$row['pid']).'"';
							                $quick_see = '<a style="display: inline-block;" href="javascript:void(0);" class="right_line1_img_bottom"></a>';
							            }
										
										$desc_exp = strip_tags($row['ext_prop']);
							            
							            echo <<<EOT
<div class="right_line1_img" id="right_line1_$i_plus_1">
							        
	<div class="right_line1_img_top">
		<a $href><img src="{$row['image']}" width="116px" height="127px"/> </a>
	</div>
	<div class="right_line1_img_middle">
		<a $href>
		<div style="color: black;font-weight: bold;margin-left: 12px; text-align: center; height: 20px; overflow: hidden;">
			{$row['name']}
		</div>
		</a>
		<div style="margin-left: 15px;color: black;font-size: 12px;overflow: hidden;height:95px; padding-top: 5px;">$desc_exp</div>
	</div>
	$quick_see
</div>
EOT;
							 
    							    }
    							    echo '</div>';
    						
    						
    						
    							    // 5-8
    						
    							    echo '<div class="right_line2">';
    							    for($i = 4; $i < 8; $i++){
    							        if (!isset($show_data[$i])){
    							            continue;
    							        }
    							        
    							        $row = $show_data[$i];
    							        
    							        $_t = $i - 3;
    							        
    							        echo <<<EOT
	<div class="right_line1_img" id="right_line2_$_t">
		<div class="right_line1_img_top">
			<img src="{$row['image']}" width="116px" height="127px"/>
		</div>
		<div class="right_line1_img_middle">
			<div style="color: black;font-weight: bold;margin-left: 15px;">
				{$row['name']}
			</div>
			<div style="margin-left: 15px;color: black;">{$row['ext_prop']}</div>
		</div>
		<button class="right_line1_img_bottom">
			
		</button>
	</div>
EOT;
    							         
    							        
    							    }
    							    echo '</div>';
    							    
    							    
    							    
    							    // 分页信息
    							    echo '<div class="right_line3" >';
    							    echo $index_page;
    							    echo $pri_page;
    							    	
    							    // 数字翻页
    							    if($now_page == 1){
    							        //当前为第一页，前面没任何页，直接输出后面页面
    							        $i = $now_page;
    							        echo '<a class="right_line3_contentg" rel="1" id="bottom_content1" >1</a>';
    							        for (++$i;$i <= $total_page;$i++){
    							            if ($i > 10){
    							                //最多显示1-10
    							                break;
    							            }
//     							            $pri_page = '<a href="?type='.$type.'&brand='.$show_brand.'&page='.($now_page-1).'" class="right_line3_content" rel="2" id="bottom_content2">上一页</a>';
    							            echo '<a href="?type='.$type.'&brand='.$show_brand.'&page='.$i.'" class="right_line3_content" rel="2" id="bottom_content2">'.$i.'</a>';
    							        }
    							    }else {
    							        //不为首页的时候
    							        // 如果为 尾几页  应该前面显示的多
    							        $max_count = 4;
    							        if ($total_page - $now_page < 5){
    							            $max_count = 10 - ($total_page - $now_page ) - 1;
    							        }
    							        	
    							        $i = $max_count;
    							        $count = 0;
    							        for ($count = 1;$i > 0;$i--,$count++){
    							             
    							            if ($count > $max_count){
    							                //最多显示4条， 或者索引到0
    							                break;
    							            }
    							             
    							            $j = $now_page - $i;
    							            if ($j <= 0){
    							                $count--;
    							                continue;
    							            }
//     							            $pri_page = '<a href="?type='.$type.'&brand='.$show_brand.'&page='.($now_page-1).'" class="right_line3_content" rel="2" id="bottom_content2">上一页</a>';
    							            echo '<a href="?type='.$type.'&brand='.$show_brand.'&page='.$j.'" class="right_line3_content" id="bottom_content2" rel="2" >'.$j.'</a>';
    							        }
    							    
    							        //当前页
    							        echo '<a class="right_line3_contentg" id="bottom_content1" rel="1" >'.$now_page.'</a>';
    							            	
    							        	
    							        //显示 后面的5条分页页码
    							        $i = $count;
    							        $count = 1;
    							        for (;$i < 10;$count++,$i++){
        							        $j = $now_page+$count;
        							        if ($j > $total_page){
        							        break;
        							        }
        							        echo '<a href="?type='.$type.'&brand='.$show_brand.'&page='.$j.'" class="right_line3_content" id="bottom_content2" rel="2" >'.$j.'</a>';
                					    }
                					
                					}
                			
                					echo $next_page;
                					echo $end_page;
    							    
                					echo '</div>';
							    }
							    
							}
							?>
							
							
					</div>
					
				</div>
			</div>
		</div>



					<div id="	">
							
					</div> 
					
					<?php 
					
					if ($show_data){
					    
					
					$now_i = 1;
					foreach ($show_data as $row){
					    
					    $desc = $row['ext_prop'];
					    
					    echo <<<EOT
<div id="tool_tip$now_i" class="tool_tip">
	<div class="tool_tip_img">
		<div style="width:359px;height:359px;border:1px #aaaaaa solid;">
			<img style="width: 340px;height: 340px;margin-top:9px;margin-left:9px" src="{$row['image']}"/>
		</div>
	</div>
	<div class="tool_tip_detil">
		<div class="tool_tip_detil_top">
			{$row['name']}
		</div>
		<div class="tool_tip_detil_fengexian1">
		</div>
		<div class="tool_tip_detil_mid">
            $desc
        </div>
		<div class="tool_tip_detil_fengexian2">
		</div>
		<div class="tool_tip_shangcheng">
			尚未开通商城功能
		</div>
		<button class="tool_tip_lxwm" value="">
		<p style="margin-top:-9px;">联系我们</p>
		</button>
		<button class="tool_tip_detil_bottom">
			退出快速查看
		</button>
	</div>
</div>
EOT;
					    $now_i++;
					    
					}
					
					}
					
					
					
					?>


        <?php echo_footer(); ?>

		
	</body>

</html>