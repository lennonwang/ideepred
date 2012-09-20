<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>新用户注册-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi"> 
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<!--  <link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	 -->
	<script type="text/javascript" src="/js/e/register.js"></script>
</head>

<body>
	
	{smarty_include eshop.common.tophead} 
	{smarty_include eshop.common.header}
	
	<!-- S body -->
<div class="bdy regPage">
	<div class="c0">
		<div class="regSection">
				<h4>新用户注册</h4>
				<div class="registerForm">
					<!--  <p class="hotlink">带*的项目为必填项</p>  -->
				
      				<form method="post" action="/app/eshop/profile/do_register" name="profile" id="user_register"> 
					<input type="hidden" name="id" value="" id="user_id" /> 
					<div class="frm">
						<p class="frmT"> 请填写您的Email地址：</p>
						<div class="frmC">
							<i class="txt txt2"> <input type="text" name="account" value="" class="middle-text" /> </i>
							<p class="frmTip4">请填写有效的Email地址，作为下次登录的用户名 </p>
						</div>
					</div>
					
					<div class="frm">
						<p class="frmT"> 请设定密码：</p>
						<div class="frmC">
							<i class="txt txt2"> <input type="password" name="password" value="" class="middle-text" id="password" /> </i>
							<p class="frmTip4"> 密码请设为6-16位字母或数字 </p>
						</div>
					</div>
					
					<div class="frm">
						<p class="frmT"> 请再次输入设定密码：</p>
						<div class="frmC">
							<i class="txt txt2"> <input type="password" name="confrimpassword" value="" class="middle-text" id="confrimpassword" /> </i> 
							<p class="frmTip4"> 两次密码请保持一致 </p>
						</div>
					</div>
					
					<div class="frm">
						<p class="frmT"> 昵 称：</p>
						<div class="frmC">
							<i class="txt txt2"> <input type="text" name="username" value="" class="middle-text" /> </i>
							<p class="frmTip4"> 请输入中英文、数字、下划线或它们的组合 </p>
						</div>
					</div>
					
					<div class="frm">
						<p class="frmT"> 请输入验证码：</p>
						<div class="frmC">
							<i class="txt"> 
								<input type="text" name="checkcode" value="" class="small-text" id="input_checkcode" />
									<a href="#change_check_code" class="jq_a_ajax" id="change_checkcode">看不清，换一张</a>
							 </i>
							<p class="frmTip4"> 验证码不区分大小写 </p>
						</div>
					</div>
					
					<div class="frm">
						<div class="frmC">
							<input type="submit" name="_submit" class="submited signup btn" value="&nbsp;提 交 &nbsp;"></input> 
						</div>
					</div>
					
					<div class="frmDesc">
						已注册成功用户，点击<a href="{Common_Smarty_Url_format key=login}">登陆</a> 	<br/>
						有任何疑问请点击 <a href="{Common_Smarty_Url_format key=helper name=register}" class="hotlink">帮助中心</a> 
						或 <a href="{Common_Smarty_Url_format key=introduce name=contact}" class="hotlink">联系客服</a>
					 	<br/>
						
					</div>  
				</form>
			</div>
		</div>
	</div>
</div>

	{smarty_include eshop.common.site-help} 
	{smarty_include eshop.common.footer}
 
</body>
</html>