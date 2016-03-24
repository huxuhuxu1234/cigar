<script>
			var now_img;
			var list_left= 0;
			
				$(function(){
					
					var aaa = $(".img_list").css("left");
					
					now_img =  -(parseInt(aaa)/1000)+1;
					
//					$(".btn").click(function(){
//						
//						var aim_img = $(this).attr("ref");
//						now_img = aim_img;
//						list_left = -1000*(aim_img-1);
//						$(".item_list").stop().animate({left:list_left},1000)
//					})
					
					
				})
//				
//				
//				function _show(){
//					$(".move").stop().animate({opacity:1},1000)
//				}
//				
//				function _hidden(){
//					$(".move").stop().animate({opacity:0},1000)
//				}
//				
				function _banner_click1(){
					if(now_img ==1){						
						list_left = -2000;
						$(".img_list").stop().animate({left:list_left},1000);						
						now_img=3;
						
					}
					else{
						list_left = -1000*(now_img-2);
						$(".img_list").stop().animate({left:list_left},1000)
						now_img --;
					}
				}
				
				function _banner_click2(){
					if(now_img ==3){
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
		</script>