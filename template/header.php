<?php
if (! defined('IN_CIGAR_UTIL')) {
    header('Location: ../');
    exit();
}

//登录信息
global $_G;

// $list = print_r($_G,true);
// error_log($list);
// exit();

global $dir_pre;
// if (!isset($dir_pre) || !$dir_pre){
    
// }

$qq_login_url = 'connect.php?mod=login&op=init&referer=' . urlencode($_SERVER["REQUEST_URI"]) . '&statfrom=login_simple';

$sechash = !isset($sechash) ? 'S'.($_G['inajax'] ? 'A' : '').$_G['sid'] : $sechash.random(3);
$FORMHASH = FORMHASH;

// $_G['member']['username']
//     <a class="zhuce" href="#" onclick="click_zhuce()">注册</a>
$login_content = <<<EOT
<div class="login1">
	<a class="denglu" href="#" onclick="click_denglu()">登录</a>&nbsp;| 
    <a class="zhuce" href="member.php?mod=register" >注册</a>
</div>
EOT;
if($_G['uid'] != 0){
    $login_content = <<<EOT
<div class="login1">
<a href="home.php?mod=spacecp" >{$_G['member']['username']} </a> | 
<a href="home.php?mod=space&do=pm">消息</a> | 
<a href="home.php?mod=space&do=notice">提醒</a> | 
<a href="home.php?mod=spacecp&amp;ac=credit&showcredit=1">积分: {$_G['member']['credits']}</a> | 
<a href="member.php?mod=logging&action=logout&formhash={$FORMHASH}">退出</a>

</div>
EOT;

}

?>

<script>
		
function click_denglu()
{
	var obj = document.getElementById("bag_denglu");
	obj.style.display = "block";
	var obj1 = document.getElementById("denglu_bag");
	obj1.style.display = "block";

}
function click_zhuce()
{
	var obj = document.getElementById("bag_denglu");
	obj.style.display = "block";
	var obj1 = document.getElementById("zhuce_bag");
	obj1.style.display = "block";

}
function click_quxiao(){
	var obj = document.getElementById("bag_denglu");
	obj.style.display = "none";
	var obj1 = document.getElementById("denglu_bag");
	obj1.style.display = "none";
}
function click_quxiao_reg(){
	var obj = document.getElementById("bag_denglu");
	obj.style.display = "none";
	var obj1 = document.getElementById("zhuce_bag");
	obj1.style.display = "none";
}

    
		$(function(){
			$('#top_search').click(function (){
				var v = $(this);
				v.attr('href','result.php?q=' + $('#login_search').val());
			});
			$('#denglu_emailbag').focus(function(){
				$('#account_tip').html('');
			});
			$('#denglu_emailbag').blur(function (){
				// 失去焦点
				//$.post('action.php',{id: $(this).val()},function(){
				//
				//});
// 				$('#account_tip').html('您输入的账号不存在 ');
			});
			$('input[name=password]').focus(function(){
				$('#account_tip').html('');
			});
			
			$('#reg_emailbag').focus(function(){
				$('#account_tip1').html('');
			});
			$('#reg_emailbag').blur(function (){
				// 失去焦点
				//$.post('action.php',{id: $(this).val()},function(){
				//
				//});
// 				$('#account_tip1').html('您输入的账号已存在 '); 
			});
			
			
			$('#reg_emailbag1').focus(function(){
				$('#account_tip2').html('');
			});
			$('#reg_emailbag1').blur(function (){
				// 失去焦点
				//$.post('action.php',{id: $(this).val()},function(){
				//
				//});
// 				$('#account_tip2').html('您输入的昵称已存在 ');
			});

			//窗体提交检测
			$('form[name="logging"]').submit(function(){
				var name = $('input[name="username"]');
				if(!name.val()){
					$('#account_tip').html('请输入用户名');
					return false;
				}
				
				var pwd = $('input[name=password]');
				if(!pwd.val()){
					$('#account_tip').html('请输入密码');
					return false;
				}
				return true;
			});

		});
		
		
	</script>


<div class="top">
	<div class="login_bag">
		<div class="login">
              <?php echo $login_content;?>
		      <div class="login_right">
		      <form action="search.php?searchsubmit=yes" method="post" target="_blank" autocomplete="off">
		        <input name="mod" id="scbar_mod" type="hidden" value="forum">
                <input name="formhash" type="hidden" value="<?php echo $FORMHASH;?>">
                <input name="srchtype" type="hidden" value="title">
                <input name="srhfid" type="hidden" value="0">
				<a href="plugin.php?id=mpage_weibo:login" class="login2"> </a> 
				<a href="<?php echo $qq_login_url; ?>" class="login3"> </a> 
				<a href="plugin.php?id=wechat:login" class="login4"> </a> 
				<input name="srchtxt" id="login_search" type="text" placeholder="请输入搜索内容" value="" autocomplete="off" speech="" x-webkit-speech="">
				<button style="border: none;" class="search3" href="#" id="top_search"
					type="submit" > </button>
				
                
            </form>

			</div>

		</div>
	</div>

	<div class="logo_bag">
		<a href="./"><div class="logo"></div></a>
	</div>

	<div class="menu_bag">
		<div class="menu">
			<a class="menu1" href="index.php" >首页</a>
			<a class="menu1" id="menu2" href="product.php">产品</a> <a
				class="menu1" href="aboutus.php">关于我们</a> <a class="menu1"
				href="culture.php">雪茄文化</a> <a class="menu1"
				href="my_box.php">我的雪茄盒</a> <a class="menu1"
				href="big_shots.php">雪茄大咖</a> <a class="menu1"
				href="contact_us.php">联系我们</a> <a class="menu1" href="discuz.php">论坛</a>
		</div>
	</div>
</div>

<div class="bag_denglu" id="bag_denglu"></div>

<div class="denglu_bag" id="denglu_bag">

	<form name="logging" action="member.php?mod=logging&amp;action=login&amp;loginsubmit=yes&amp;infloat=yes&amp;lssubmit=yes" method="post" autocomplete="off">
		<div class="denglu_bg">
			<div class="denglu_logo"></div>
			<div class="denglu_fenge"></div>
			<div class="denglu_font1">雪茄账号登录</div>
			<div class="denglu_bag_bag">
				<div class="denglu_font2">
					<div class="denglu_email">帐号</div>
					<div class="account_tip" id="account_tip"></div>
					<div class="denglu_password">密码</div>
				</div>
				<div class="denglu_3bag">
					<input type="text" name="username" id="denglu_emailbag"
						value="" /> <input type="password" name="password"
						id="denglu_passwordbag" value="" />
				</div>
				<div class="denglu_font4">
					
						<input type="checkbox" name="cookietime" id="denglu_rem" value="2592000" />
					<p>记住我的帐号</p>
					
				</div>
				<div class="denglu_font5">
					<a href="member.php?mod=logging&action=login&viewlostpw=1"> 忘记密码？</a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="member.php?mod=register">注册雪茄</a>
				</div>
				<div class="denglu_font6">
					<input type="submit" name="" id="" value="登陆雪茄中国" />
				</div>
				
			</div>
			<div class="denglu_quxiao" onclick="click_quxiao()"></div>
		</div>
	</form>
</div>


<div class="denglu_bag" id="zhuce_bag">
	<form action="member.php?mod=register" enctype="multipart/form-data" method="post" autocomplete="off">
		<div class="denglu_bg">
			<div class="denglu_logo"></div>
			<div class="denglu_fenge"></div>
			<div class="denglu_font1">雪茄账号注册</div>
			<div class="denglu_bag_bag">
				<div class="denglu_font2">
					<div class="denglu_email" id="zhuce_email">帐号</div>
					<div class="account_tip1" id="account_tip1"></div>
					<div class="denglu_password">请输入密码</div>
				</div>
				<div class="denglu_3bag">
					<input type="text" name="<?php echo $_G['setting']['reginput']['username'];?>" id="reg_emailbag"
						value="" />
					<input type="password" name="<?php echo $_G['setting']['reginput']['password'];?>"
						id="reg_passwordbag" value="" />
				</div>

				<div class="denglu_font3">
					<div class="denglu_email" id="zhuce_nicheng">E-mail</div>
					<div class="account_tip2" id="account_tip2"></div>
					<div class="denglu_password">确认密码</div>
				</div>
				<div class="denglu_3bag">
					<input type="text" name="<?php echo $_G['setting']['reginput']['email'];?>" id="reg_emailbag1"
						value="" /> 
						<input type="password" name="<?php echo $_G['setting']['reginput']['password2'];?>"
						id="reg_passwordbag1" value="" />
				</div>
				<div class="denglu_font4_1">
					<div class="left">
						<input type="checkbox" name="denglu_rem" id="denglu_rem" value="" />
						<p>我已经认真阅读并同意雪茄中国的《使用协议》。</p>
					</div>
<!-- 					<div class="right"> -->
<!-- 						<p>验证码：</p> -->
<!-- 						<input class="yanzhengma" type="text" name="seccodeverify" id="" value="" /> -->
<!-- 						<img class="yzm_img" src="misc.php?mod=seccode&update=49942&idhash=cSkFW4OM"/> -->
<!-- 					</div> -->
				</div>
				<div class="denglu_font6_1">
					<input type="button" name="" id="" value="注 册" />
				</div>
			</div>
			<div class="denglu_quxiao" onclick="click_quxiao_reg()"></div>
		</div>
	</form>
</div>
