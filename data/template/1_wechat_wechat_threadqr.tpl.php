<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('wechat_threadqr');?><?php include template('common/header'); if($_GET['share']) { ?>
<div class="f_c">
<h3 class="flb">
<em id="return_<?php echo $_GET['handlekey'];?>">分享到微信</em>
<span>
<a href="javascript:;" class="flbc" onclick="hideWindow('<?php echo $_GET['handlekey'];?>')" title="关闭">关闭</a>
</span>
</h3>
<div class="c" align='center'>
<img src="plugin.php?id=wechat:qrcode&amp;tid=<?php echo $tid;?>&amp;access=yes" width="200" height="200" />
<br />
用微信扫一扫，互动赢积分
</div>
</div>
<?php } elseif($_GET['showactivity']) { ?>
<div class="f_c">
<h3 class="flb">
<em id="return_<?php echo $_GET['handlekey'];?>">分享到微信</em>
<span>
<a href="javascript:;" class="flbc" onclick="hideWindow('<?php echo $_GET['handlekey'];?>')" title="关闭">关闭</a>
</span>
</h3>
<div class="c" align='center'>
<img src="plugin.php?id=wechat:qrcode&amp;tid=<?php echo $tid;?>&amp;pid=<?php echo $_GET['pid'];?>&amp;access=yes" width="200" height="200" />
<br />
通过微信扫描二维码为我拉票
</div>
</div>
<?php } else { ?>
<div class="f_c xg1" align="center">
<img src="plugin.php?id=wechat:qrcode&amp;tid=<?php echo $tid;?>&amp;access=yes" width="98" /><br />用微信扫一扫<br />互动赢积分
</div>
<?php } include template('common/footer'); ?>