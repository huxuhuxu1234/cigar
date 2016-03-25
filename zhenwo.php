<?php 
require 'util.php';

$now_page = 1;

if (isset($_GET['page'])){
    if(is_numeric($_GET['page'])){
        $now_page = intval($_GET['page']);
    }
}

$data = false;
$total_page = -1;

if (isset($_GET['sw'])){
    $sw = $_GET['sw'];
    $data = C::t('cigar_zhenwo')->searchName($sw);
    $total_page = data_count($data, 16);
}else{
    $total_page = C::t('cigar_zhenwo')->pageCount();
}

if($now_page > $total_page || $now_page <= 0){
    $now_page = 1;
}

if (!$data){
    $data = C::t('cigar_zhenwo')->page($now_page);
}else{
    $data = util_page($data, $now_page, 16);    
}



//处理一下底部的翻页信息
$index_page = '';
$pri_page = '';
if($now_page != 1){
    if (isset($sw) && $sw){
        $index_page = '<a class="shouye" href="?page=1&sw='.$sw.'">首&nbsp;页</a>';
        $pri_page = '<a href="?page='.($now_page-1).'&sw='.$sw.'" class="yema pre" > &lt; </a>';
    }else{
        $index_page = '<a class="shouye" href="?page=1">首&nbsp;页</a>';
        $pri_page = '<a href="?page='.($now_page-1).'" class="yema pre" > &lt; </a>';
    }
}

$end_page = '';
$next_page = '';
if($now_page != $total_page){
    if (isset($sw) && $sw){
        $end_page = '<a href="?page='.$total_page.'&sw='.$sw.'"" class="shouye">尾页</a>';
        $next_page = '<a href="?page='.($now_page + 1).'&sw='.$sw.'"" class="yema pre" > &gt; </a>';
    }else{
        $end_page = '<a href="?page='.$total_page.'" class="shouye">尾页</a>';
        $next_page = '<a href="?page='.($now_page + 1).'" class="yema pre" > &gt; </a>';
    }
}

// <a class="shouye" href="#">首&nbsp;页</a>
// <a class="yema pre" href="#">&lt;</a>
// <a class="yema" href="#">1</a>
// <a class="yema" href="#">2</a>
// <a class="yema" href="#">3</a>
// <a class="yema" href="#">&hellip;</a>
// <a class="yema" href="#">8</a>
// <a class="yema" href="#">9</a>
// <a class="yema pre" href="#">&gt;</a>
// <a class="shouye" href="#">尾&nbsp;页</a>

$jia_this_pics = '';



global $_MCONFIG;

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>真我风采   - <?php echo $_MCONFIG['title'];?> </title>
		<link rel="stylesheet" type="text/css" href="css/zhenwofengcai.css"/>
		<link rel="stylesheet" type="text/css" href="css/top.css" />
		<link rel="stylesheet" type="text/css" href="css/foot.css" />
		<link rel="stylesheet" href="css/index_cebianlan.css" />
		<script src="js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
		
	</head>
	<body>
	
	<?php echo_header();?>
	
	<?php echo_slide();?>
	
		<div class="zhenwofengcai_bag">
			
			<div class="bag_zwfc">
				
                            <div class="show_datu" style="display:none">
					<a href="" target="_blank"><p style="color: gray;display: block;font-size: 18px;margin-left: 20px;">点击图片进入帖子查看详情</p></a>
					<a href=""><img src=""/></a>
					<a href=""><h2 class="show_datu_text">
						
					</h2></a>
				<img class="show_guanbi" src="img/guanbi.png"/>
				</div>
				
				<div class="mianbaoxie_zwfc">
					<a href="./">首页</a>&nbsp;&gt;&nbsp;
					<a href="">真我风采</a>
				</div>
				<div class="daoyu_zwfc">
					<div class="show_qq">
						<p style="display:block; float:left; font-size: 18px; line-height: 26px;">雪茄是和朋友分享的最好选择。</p>
						<img style="display:block;float:left;font-weight: bolder; " id="share_zone_button" class="qqkj_zwfc" src="img/fenxiangkongjian2.png"/>
					</div>
					<div class="photo_zwfc">
						<div class="left">
							<div class="show_photo">
								张贴你的照片
							</div>
							<div class="show_photo_text">
								给我们展示你最喜欢的雪茄回忆。
							</div>
						</div>
						<div class="right">
						  <form action="#" method="get">
							<div class="search_text">
								通过名字搜索照片
							</div>
							<div class="search_kuang">
								<input type="image" class="search_right" src="img/seach_right.png"/>
								<input class="search_mid" type="text" name="sw" id="" value="<?php echo $sw;?>" placeholder="Search" />
								<img class="search_left" src="img/seach_left.png"/>
							</div>
						  </form>
						</div>
					</div>
					<div class="daoyu_line">
						
					</div>
				</div>
				<div class="content_bag">
					<div class="upload_bg">
						<div class="upload_photo">
							<a href="">上传照片</a>
						</div>
					</div>
					<div class="content_zwfc">
						<div class="items">
						
						      
						      <?php 
						      
							  $limit = 1;
						      foreach ($data as $index => $row){
								  if($index < $limit){
									$tmp_path = $row['image'];
									if(!strstr($tmp_path,'https://') && !strstr($tmp_path,'http://')){
										$jia_this_pics .= 'http://www.cigarcn.com/';
									}
									
									$jia_this_pics .= $tmp_path;
									if($index < $limit-1){
										$jia_this_pics .= '||';
									}
									
								  }
						          echo <<<EOT
<div class="content1_bg">					
	<div class="content_img_bag">
		<img class="content_img" src="{$row['image']}"/>
	</div>					
	<a href="{$row['link']}"><div class="content_text">
		{$row['name']}
	</div></a>
</div>
EOT;
						          
						      }
						      
						      
						      ?>
						      
						</div>
						
						<div class="clear">
						</div>
						
						
						<div class="fanye">
<!-- 							<a class="shouye" href="#">首&nbsp;页</a> -->
<!-- 							<a class="yema pre" href="#">&lt;</a> -->
<!-- 							<a class="yema" href="#">1</a> -->
<!-- 							<a class="yema" href="#">2</a> -->
<!-- 							<a class="yema" href="#">3</a> -->
<!-- 							<a class="yema" href="#">&hellip;</a> -->
<!-- 							<a class="yema" href="#">8</a> -->
<!-- 							<a class="yema" href="#">9</a> -->
<!-- 							<a class="yema pre" href="#">&gt;</a> -->
<!-- 							<a class="shouye" href="#">尾&nbsp;页</a> -->
						
						<?php 
						
						//处理翻页信息
						
						echo $index_page;
						echo $pri_page;
						
						
						// 数字翻页
						if($now_page == 1){
						    //当前为第一页，前面没任何页，直接输出后面页面
						    $i = $now_page;
						    echo '<a class="focus" href="javascript:void(0);">1</a>';
						    for (++$i;$i <= $total_page;$i++){
						        if ($i > 10){
						            //最多显示1-10
						            break;
						        }
						        if (isset($sw) && $sw){
						            echo '<a href="?page='.$i.'&sw='.$sw.'" class="yema" >'.$i.'</a>';
						        }else{
    						        echo '<a href="?page='.$i.'" class="yema" >'.$i.'</a>';
						        }
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
						         
						        if (isset($sw) && $sw){
						            echo '<a href="?page='.$j.'&sw='.$sw.'" class="yema"  >'.$j.'</a>';
						        }else{
						            echo '<a href="?page='.$j.'" class="yema"  >'.$j.'</a>';
						        }
						        
						    }
						
						    //当前页
						    echo '<a class="focus" >'.$now_page.'</a>';
						        	
						    	
						    //显示 后面的5条分页页码
						    $i = $count;
						    $count = 1;
						    for (;$i < 10;$count++,$i++){
						    $j = $now_page+$count;
						    if ($j > $total_page){
						    break;
						    }
						    if (isset($sw) && $sw){
						        echo '<a href="?page='.$j.'&sw='.$sw.'" class="yema"  >'.$j.'</a>';
						    }else{
						        echo '<a href="?page='.$j.'" class="yema"  >'.$j.'</a>';
						    }
					    }
					
					}
						
						
						echo $next_page;
						echo $end_page;
						
						
						
						?>
						
						
						</div>
						<div class="clear">
							
						</div>
						<div class="kongbai">
							
						</div>
					</div>
				</div>
			
			</div>
			
		</div>	
		
		<div class="show_datu_bg">
							
		</div>
		
		
		<!-- 分享到空间 -->
		<!-- JiaThis Button BEGIN -->
		<div class="jiathis_style" style="display: none;">
			<a id="shareZone" class="jiathis_button_qzone"></a>
		</div>
		<script type="text/javascript" >
		var jiathis_config={
			summary:"",
			pic:"<?php echo $jia_this_pics;?>",
			shortUrl:false,
			hideMore:false
		}
		</script>
		<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
		<!-- JiaThis Button END -->
		
		
		
		<?php echo_footer(); ?>
		
		
		<script>
//			$(function(){
//				$(".yema").click(function(){
//					$(".yema").css("background-image","url('../img/dianji.png')");
//				})
//			})
			$(function(){
				
				$(".show_datu_bg").hide();
				$(".show_datu").hide();
				$(".show_guanbi").hide();
				
				
				$(".show_guanbi").click(function(){
					$(".show_datu_bg").hide();
					$(".show_datu").hide();
					$(".show_guanbi").hide();
					
				});
				
				$(".content_img").click(function(){

				    $('.show_datu img:eq(0)').attr('src',$(this).attr('src'));
				    
				    var text = $(this).parent().parent().find('.content_text').html();
				    $('.show_datu_text:eq(0)').html(text);
				    var href = $(this).parent().parent().find('a:eq(0)').attr('href');

				    $('.show_datu a').each(function(){
				        $(this).attr('href',href);
					});
					
					$(".show_datu_bg").show();
					$(".show_datu").show();
					$(".show_guanbi").show();
					
				});
				
				$('#share_zone_button').click(function(){
					$('#shareZone').trigger('click');
				});
			});
			
		</script>
	</body>
</html>
