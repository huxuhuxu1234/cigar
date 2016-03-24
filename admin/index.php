<?php 
require_once '../source/class/class_core.php';

$discuz = C::app();
$discuz->init();

global $_G;
if ($_G['uid'] != 0 && $_G['adminid'] == 1){
    //跳过登录
    header('Location: ./admin.php');
    exit();
}

//get error code.
// error = 1 , password error
// error = 2 , invaild user or not admin
$error_script = '';
if (isset($_GET['error'])){
    $error = $_GET['error'];
    if ($error == 1){
        $error_script = 'alert(\'您输入的密码或帐号有误，请检测\'); ';
    }else if ($error == 2){
        $error_script = 'alert(\'该用户不存在或者不是管理员！\'); ';
    }
}

if ($error_script){
    
    echo <<<EOT
<html>
<head>
    <script>
        $error_script;
        location = './';
    </script>        
</head>

<body></body>
        
</html>
EOT;
    
}

?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>雪茄中国网站后台管理系统</title>

<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<body>


<div class="wrapper">

	<div class="container">
		<h1>Welcome</h1>
		<form class="form" action="../admin.php?" method="post">
			<input type="text" name="admin_username" autocomplete="off" placeholder="用户名">
			<input type="password" name="admin_password" autocomplete="off" placeholder="密码">
			<button type="submit" id="login-button">登录</button>
			<!--        hidden form values.    -->
            <input type="hidden" name="admin_questionid" value="0" />
            <input type="hidden" name="flag" value="1" />
            <input type="hidden" name="sid" value="FrUhPU">
            <input type="hidden" name="frames" value="yes">
            <input type="hidden" name="admin_answer" value="" />
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
	
</div>

<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
$('#login-button').click(function(event){
	event.preventDefault();
	var ret = checkSubmit();
	if(ret){
		$('form').fadeOut(500);
		$('.wrapper').addClass('form-success');
		
		setTimeout(function(){
			$('form').submit();
		},800);
	}
	
});

function checkSubmit(){
	var name = $(':input[name=admin_username]');
	if(!name.val()){
		alert('请输入用户名！');
		name.select();
		return false;
	}
	var pwd = $(':input[name=admin_password]');
	if(!pwd.val()){
		alert('请输入密码！');
		pwd.select();
		return false;
	}
	return true;
}

</script>

</body>
</html>