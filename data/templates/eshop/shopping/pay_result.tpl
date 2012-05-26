<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>订单支付成功--{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			<div class="bordor profile" id="payment">

				<div class="rd_content">
					
					<div class="ord_inf">
						{if $msg }
						<div class="inf_l">
							<img src="/images/ins/err_icon.png" />
						</div>
						<div class="inf_r">
							<h2>{$msg}</h2>
							<p>订单号: <span class="pri_red">{$order_ref}</span></p>
						</div>
						{else}
						<div class="inf_l">
							<img src="/images/eshop/ok.png" />
						</div>
						<div class="inf_r">
							<h2>订单已支付成功，系统正在配货中。</h2>
							<p>您的订单号: <span class="pri_red">{$order_ref}</span> 应付金额: <span class="pri_red">{$payAmount}</span>元 </p>
						</div>
						<div class="clear"></div>
						{/if}
					</div>
					
				</div>

			</div>
		</div>

	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>