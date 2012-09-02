<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>选择支付方式</title>
	<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/>
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/confirm.js"></script>
</head>

<body>
	<div id="wrapper">

		{smarty_include eshop.common.header}

		<div id="container">

			<div class="box">
				<div class="bordor" id="orderfrom">
					<h2>结算步骤: <span id="shoppingstep_1">1.登录注册</span> >> <span id="shoppingstep_2" class="current_step">2.填写核对订单信息</span> >> <span id="shoppingstep_3">3.提交订单</span></h2>
					
					<p class="hotlink">带*的项目为必填项</p>
					
					
					{smarty_include eshop.shopping.checkout_address_ok}
					
					{smarty_include eshop.shopping.checkout_payment_ok}
					
					<div class="sho_step editable" id="chknotice_info">
						<h3>订单备注</h3>
						<form method="post" action="/app/eshop/shopping/do_notice" id="notice_ofrm">
							<input type="hidden" name="next_step" value="{$next_step}" />
							<table class="odrable">
								<tr>
									<th class="td_lab">备注：</th>
									<td class="pal_note">
										<textarea name="summary" cols="60">{$data.summary}</textarea>
										<p>(*请在文本框内填写您的留言,最好别超过100个字符)</p>
									</td>
								</tr>
							</table>
							<div id="do_buy">
								<p>
									<input type="submit" name="notice_ofrm" value="保存备注信息"  class="go_submit" />
								</p>
							</div>
						</form>
					</div>
					
				</div>
			</div>

		</div>

		{smarty_include eshop.site-help}

		{smarty_include eshop.footer}
	</div>
	
</body>
</html>