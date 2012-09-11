<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>登录--{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	{smarty_include eshop.common.header_compart} 
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/login.js"></script>
	
</head>

<body>
 
	{smarty_include eshop.common.header}
	
	<!-- S body -->
<div class="bdy regPage">
	<div class="c0">
  	
    <div class="noUserName">
    	<p>没有深红账号？</p> 
       <p><a href="{Common_Smarty_Url_format key=register}" class="btn"><b>10秒钟轻松注册</b></a></p> 
      
    </div>
    
    <div class="regSection">
    	<h4>登录</h4>
      <div class="regForm">
      	<form method="post" action="/app/eshop/profile/do_login" name="profile" id="user_login">
      		<div id="reqstatus_boxes"></div>
      	<div class="frm frmUsr"><i class="txt">
      	<input type="text" name="account" id="userName" class="userName" value="请输入邮箱" /></i></div>
        <div class="frm frmPass"><i class="txt">
        <input type="password" name="password" id="password" class="password" value="请输入密码." /></i></div>
        <div class="frm remember"><label class="cbox"><input type="checkbox" />记住密码，下次免登录</label><i class="tip" id="regTip">用户名或密码不正确</i></div>
        <div class="frm regSubmit">
        	<!--  <button type="submit" name="submit" class="btn" ><b>登录</b></button> -->
        	 <input type="submit" name="_submit" value="完成" class="btn" /> 
        	<!--<a href="#" class="forgot">忘记密码？</a>-->
        	<!-- onClick="checkRegInfo()" -->
        </div>
		</form>     
      </div>
      <!--
      <div class="regOther">
      	您也可以使用以下账号登录
        <a href="#">新浪微博</a><a href="#">QQ</a> 
      </div>
      -->
    </div> 
  </div>
</div>
<!-- E body -->

	{smarty_include eshop.common.site-help} 
	{smarty_include eshop.common.footer}
 
</body>
</html>