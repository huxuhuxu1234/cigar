<?php 
require_once 'util.php';
require_once 'salt.php';

$total_page = C::t('cigar_big_shots')->pageCount();

$now_page = 1;

if (isset($_GET['page'])){
    if(is_numeric($_GET['page'])){
        $now_page = intval($_GET['page']);
    }
}

if($now_page > $total_page || $now_page <= 0){
    $now_page = 1;
}

$data = C::t('cigar_big_shots')->page($now_page);

//处理一下底部的翻页信息
$index_page = '';
$pri_page = '';
if($now_page != 1){
    $index_page = '<a href="?page=1" class="second_part_left_second_content1">首页 </a>';
    $pri_page = '<a href="?page='.($now_page-1).'"class="second_part_left_second_content1" style="margin-left: 0px;">上一页</a>';
}

$end_page = '';
$next_page = '';
if($now_page != $total_page){
    $end_page = '<a href="?page='.$total_page.'" class="second_part_left_second_content9">尾页</a>';
    $next_page = '<a href="?page='.($now_page + 1).'" class="second_part_left_second_content10" >下一页</a>';
}


global $_MCONFIG;

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>雪茄大咖  - <?php echo $_MCONFIG['title'];?></title>
		<?php echo_web_keywords_and_descr();?>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/top.css"/>
		<link rel="stylesheet" type="text/css" href="css/xuejiadaka.css"/>
		<link rel="stylesheet" type="text/css" href="css/foot.css"/>
		<link rel="stylesheet" href="css/index_cebianlan.css" />
	
	</head>
	<body>
		
		<?php echo_header();?>
		
		<?php echo_slide();?>
		
		
		<div class="daka_bag">
			<div class="daka">
				<div class="daka_mianbaoxie">
					<a href="./">&nbsp;首页</a>&nbsp;&gt;&nbsp;
					<a href="#">雪茄大咖</a>
				</div>
				<div class="daka_bg">
				<div class="daka_daoyu">
					Legendary cigars are born of a deep passion for the leaf. <br/>Meet our artisans. 
				</div>
				<p style="width: 600px;font-size: 24px;display:block;margin-bottom:18px;font-family:方正硬笔行书简体;">经典的传承源自与对烟叶的感悟</p>
				<div class="daka_pp">
				    <?php 
				    //输出所有雪茄大咖的信息
				    $i = 0;
				    foreach ($data as $row){
						$sName = sub_str($row['sName'],10);
						$pName = sub_str($row['pName'],10);
				        $line = 'daka_pp_1';
				        if($i++ >= 4){
				            $line = 'daka_pp_2';
				        }
				        $id = $salt->encode(2,$row['bid']);
				        echo <<<EOT
					<div class="$line">
						<div class="daka_pp_1_img">
							<a href="big_shots_talk.php?id={$id}"><img src="{$row['img']}" width="212px" height="150px"/></a>
						</div>
						<div class="daka_pp_1_name">
							<a style="color:#543421;font-size:17px;" href="big_shots_talk.php?id={$id}">{$row['name']}</a>
						</div>
						<div class="daka_pp_1_foot">
							<div style="color:#543421;" class="daka_pp_foot_left">
								{$sName}<br/>{$pName}
							</div>
							<button class="daka_pp_foot_right" onclick="location='big_shots_talk.php?id=$id'">
								<div class="daka_pp_more">
									more
								</div>
							</button>
						</div>
					</div>
EOT;
				    }
				    

				    ?>
				    
				</div>
				
				<div class="second_part_left_second">
				
				
				<?php 
					//输出分页
					
					echo $index_page;
					echo $pri_page;
					
					// 数字翻页
					if($now_page == 1){
					    //当前为第一页，前面没任何页，直接输出后面页面
					    $i = $now_page;
					    echo '<a class="second_part_left_second_contentg" id="bottom_content1" rel="1" state="1" style="margin-left: 345px">1</a>';
					    for (++$i;$i <= $total_page;$i++){
					        if ($i > 10){
					            //最多显示1-10
					            break;
					        }
// 					        echo '<a href="?id='.$id_code.'&page='.$i.'" class="fanyelan_content" id="bottom_content2" rel="2" state="0">'.$i.'</a>';
					        echo '<a href="?page='.$i.'" class="second_part_left_second_content" id="bottom_content2" rel="2" state="0">'.$i.'</a>';
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
					        
// 					        echo '<a href="?id='.$id_code.'&page='.$j.'" class="fanyelan_content" id="bottom_content2" rel="2" state="0">'.$j.'</a>';
					        echo '<a href="?page='.$j.'" class="second_part_left_second_content" id="bottom_content2" rel="2" state="0">'.$j.'</a>';
					    }
// 					    echo '<a class="fanyelan_content" id="bottom_content1" rel="1" state="1">'.$total_page.'</a>';
                        
					    //当前页
// 					    echo '<a class="fanyelan_contentg" id="bottom_content1" rel="1" state="1" >'.$now_page.'</a>';
					    echo '<a class="second_part_left_second_contentg" id="bottom_content1" rel="1" state="1">'.$now_page.'</a>';
					    
					    
					    //显示 后面的5条分页页码
					    $i = $count;
					    $count = 1;
					    for (;$i < 10;$count++,$i++){
					        $j = $now_page+$count;
					        if ($j > $total_page){
					            break;
					        }
//         				    echo '<a href="?id='.$id_code.'&page='.$j.'" class="fanyelan_content" id="bottom_content2" rel="2" state="0">'.$j.'</a>';
					        echo '<a href="?page='.$j.'" class="second_part_left_second_content" id="bottom_content2" rel="2" state="0">'.$j.'</a>';
					    }
					    
					}
					
					echo $next_page;
					echo $end_page;
					
					?>
						
				</div>	
				</div>
			</div>
			
		</div>

	<?php echo_footer();?>
	</body>
</html>
