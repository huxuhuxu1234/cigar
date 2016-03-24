<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if($bind['uid']) { ?>
<p class="pbm bbda xi1">您已将本站帐号 <strong><?php echo $_G['username'];?></strong> 与新浪微博绑定</p>
<table cellspacing="0" cellpadding="0" class="tfm mbw bbda">
<tr>
<th>已绑定微博</th>
<td><a href="http://weibo.com/u/<?php echo $bind['sina_uid'];?>" class="xw1" target="_blank"><?php echo $bind['sina_username'];?></a><td>
</tr>
<tr>
<th>绑定时间</th>
<td><?php echo $bind['dateline'];?><td>
</tr>
</table>
<h2><a href="javascript:;" onclick="display('unbind');" class="xi2">解除已绑定帐号？</a></h2>
<div id="unbind" style="display:none;">
<form action="home.php?mod=spacecp&amp;ac=plugin&amp;id=mpage_weibo:bind" method="post" autocomplete="off">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="unbindsubmit" value="true" />
<p class="mtm mbm">您确认要解除与本站帐号的绑定关系？</p>
<p><button type="submit" class="pn pnc"><strong>确认解除</strong></button></p>
</form>
</div>
<?php } else { ?>
<div class="mtw bm2 cl">
<div class="bm2_b bw0 hm" style="padding-top: 70px;">
<a href="plugin.php?id=mpage_weibo:login"><img src="source/plugin/mpage_weibo/image/sina_bind_btn.png"></a>
<p class="mtn xg1">点击按钮，立刻绑定新浪微博</p>
</div>
<div class="bm2_b bm2_b_y bw0">
<dl class="xld">
<h2 class="xi1 xs2">使用新浪微博账号绑定本站，您可以...</h2>
<dt>用新浪微博帐号轻松登录</dt>
<dd class="xg1">无需记住本站的帐号和密码，随时使用新浪微博帐号密码轻松登录</dd>
<dt>发表主题同时推送到新浪微博</dt>
<dd class="xg1">将您的论坛主题推送到新浪微博，让粉丝全方面了解您</dd>
<dt>把本站精彩内容分享到新浪微博</dt>
<dd class="xg1">每一个精彩内容绝不放过，简单快捷的将论坛主题分享给好友和粉丝</dd>
</dl>
</div>
</div>
<?php } ?>