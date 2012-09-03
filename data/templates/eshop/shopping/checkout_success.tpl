<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>成功提交订单--{smarty_include eshop.common.xtitle}</title>
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
					<div class="ord_inf clearfix">
						<div class="inf_l">
							<img src="/images/eshop/ok.png" />
						</div>
						<div class="inf_r">
							<h2>订单已提交成功，请尽快付款。 <span>正在跳转到第三方平台支付。。。</span></h2>
							<p>您的订单号: <span class="pri_red">{$order_ref}</span> 应付金额: <span class="pri_red">{$order.pay_money}</span>元  支付方式：<span  class="pri_org">{$payment_method.name}</span></p>
						</div>
					</div>
					
					
					<div id="paymethod" class="clearfix">
						<div class="ord_sta">
							<span>还差一步，请立即支付（请您在3日内完成支付，否则订单被自动移除）</span>
						</div>
						{if $pm_key eq 'a'}
						<div class="ord_ext clearfix">
							<h6>请选择以下支付平台支付</h6>
							<ul>
								<li>
									<a href="/app/eshop/alipay/payment?order_ref={$order_ref}" title="支付宝" target="_blank">
										<img src="/images/eshop/alipay.png" alt="支付宝" />
									</a>
								</li>
							</ul>
						</div>
						{literal}
						<script type="text/javascript">
						setTimeout(function(){
						{/literal}
							window.location.href='/app/eshop/alipay?order_ref={$order_ref}';
						{literal}	
						},11300);
						</script>
						{/literal}
						{/if}
						{if $pm_key eq 'c'}
						<div class="ord_ext">
							<p><span  class="pri_org">提示：</a>您的订单已经在处理中，请时时关注订单状态；</p>
						</div>
						{/if}
						<div class="ablue do_oth">
							{if $pm_key eq 'a'}
							<a href="{Common_Smarty_Url_format key=helper name=payment}" class="loo_help" target="_blank">查看在线支付帮助</a>
							{/if}
							<a href="{Common_Smarty_Url_format key='domain'}" class="go_on">« 继续购物</a>
							<div class="clear"></div>
						</div>
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