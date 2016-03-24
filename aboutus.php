<?php 
    require_once 'util.php';
    
    global $_MCONFIG;
    
    $data = get_about_us_();
    
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>关于我们  - <?php echo $_MCONFIG['title'];?></title>
		<link rel="stylesheet" type="text/css" href="css/top.css" />
		<link rel="stylesheet" type="text/css" href="css/guanyuwomen.css" />
		<link rel="stylesheet" type="text/css" href="css/foot.css" />
		<?php echo_web_keywords_and_descr();?>
		<script type="text/javascript" src="js/jquery-1.9.1.min.js" ></script>
		<link rel="stylesheet" href="css/index_cebianlan.css" />

		<!--       guanyuwomen切换divJS         -->
		<script>
			$(function() {

			    //右侧内容
			    var right_array = new Array();
			    var r_header1 = $('div[class=second_line_right_top] div[class=top]');
			    var r_header2 = $('div[class=second_line_right_top] div[class=bottom]');
			    var r_content = $('div[class=second_line_right_bottom]');
			    var r_img = $('div[class=second_line_right_middle] img:eq(0)');
			    
			    <?php 
                    
			         $i = 1;
			         foreach ($data as $row){
			             $a = explode('@', $row['right_header']);
			             $c = nl2br($row['right_content']);
			             $a0 = trim($a[0]);
			             echo <<<EOT
right_array[$i] = new Array();
right_array[$i]['r_header1'] = '{$a0}';
right_array[$i]['r_header2'] = '{$a[1]}';
right_array[$i]['r_content'] = '{$c}';
right_array[$i]['r_img'] = '{$row['right_img']}'; 
		    

EOT;
			             $i++;
			         }
			    
			    ?>
				
				$('#cnt1').show();
				
				$(".line1_img,.line1_img_active").click(function(){
					
					$(".line1_img,.line1_img_active").attr("class","line1_img");
					
					$(this).attr("class","line1_img_active");
					
					////////////
					var num =$(this).attr("flag");
					
					$(".second_line_left_content").hide();
					
					$("#cnt"+num).show();

					//修改右侧内容
					r_header1.html(right_array[num]['r_header1']);
					r_header2.html(right_array[num]['r_header2']);
					r_content.html(right_array[num]['r_content']);
					r_img.attr('src',right_array[num]['r_img']);
				})
				
			})
		</script>
	
	</head>

	<body>
	
		<?php echo_header();?>
		
		<?php echo_slide();?>
		
		<div class="banner_bag">
			<div class="banner_bag_top">
				<div class="banner_bag_top_list">
					<a href="./" class="banner_bag_top_a">首页</a>&nbsp;>&nbsp;
					<a href="" class="banner_bag_top_a">关于我们</a>
				</div>
			</div>

			<div class="banner_middle">
				<div class="middle_first_line">
				    <?php 
				        //输出标题
				        echo <<<EOT
				    <div class="line1_img_active" flag="1" id="gywm_img1">
						{$data[0]['header']}
					</div>
EOT;
					
						for ($i = 1; $i < count($data); $i++){
						    $t = $i+1;
						    echo <<<EOT
 					<div class="line1_img" flag="$t" id="gywm_img$t">
						{$data[$i]['header']}
					</div>   
EOT;
						}
						
				    ?>
				</div>

				<div class="middle_second_line">
					<div class="second_line_left">
					   
					   <?php 
					       
					       $i = 1;
					       foreach ($data as $row){
					           $c = nl2br($row['content']);
					           echo <<<EOT
   						<div class="second_line_left_content" id="cnt$i">
		                  $c
						</div>
EOT;
					           $i++;
					       }
					   
					   ?>
					   
					</div>
					<div class="second_line_right">
						<div class="second_line_right_top">
						      <?php 
						          //输出第一个右侧图片和头部底部
						          $t = $data[0]['right_header'];
						          $a = explode('@', $t);
				
//                                   $b = str_replace('\n','\n<br/>',$a[1]);
						          echo <<<EOT
						          <div class="top">{$a[0]}</div>
						          <div class="bottom">
						          $a[1]
						          </div>
EOT;
						      
						      ?>
						</div>
						<div class="second_line_right_middle">
							<img src="<?php echo $data[0]['right_img'];?>"  width="234px" height="109px"/>
						</div>
						<div class="second_line_right_bottom">
							<?php echo nl2br($data[0]['right_content']);?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php echo_footer();?>
	</body>
</html>