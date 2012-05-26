<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>个人帐户管理-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<div class="box">
			<div class="bordor profile">
				<h2>个人帐户管理</h2>
				
				<div class="box clearfix">
					<div class="leftref noborder" id="channelside">
						{smarty_include eshop.account.leftnav}
					</div>
					<div class="righttwo2" id="contentlist">
						<div class="a_item contentbox">
							<div class="contentbaby ablue">
								<table>
									<tr class="tr_lin">
										<td colspan="7">个人订单列表</td>
									</tr>
									<tr class="gs">
										<td>订单号</td>
										<td>订单金额</td>
										<td>收货人姓名</td>
										<td>下单时间</td>
										<td>状 态</td>
										<td>支付方式</td>
										<td>操 作</td>
									</tr>
									{foreach from=$order_list item=ord}
									<tr class="gs">
										<td><a href="{Common_Smarty_Url_format key='order_detail' id=$ord.id}" >{$ord.reference}</a></td>
										<td>{$ord.pay_money}元</td>
										<td>{$ord.name}</td>
										<td>{$ord.created_on}</td>
										<td>{Common_Smarty_DataSet_orderStatus status=$ord.status}</td>
										<td>{$all_payment_method[$ord.payment_method].name}</td>
										<td><a href="{Common_Smarty_Url_format key='order_detail' id=$ord.id}" >查看详情 »</a></td>
									</tr>
									{/foreach}
								</table>
							</div>
							{assign var=url_prefix value="/app/eshop/profile/trading_order"}
							{smarty_include eshop.common.pager}
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