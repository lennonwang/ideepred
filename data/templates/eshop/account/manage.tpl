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
	
	{smarty_include eshop.common.header}

	
	
<!-- S crumbs -->
<div class="crumbs">
	<div class="c0">
  	<a href="/">首页</a>&gt;<a href="#" class="on">个人中心</a>  &gt;<a href="#" class="on">订单中心</a>  
  </div>
</div>
<!-- E crumbs -->

<!-- S bdy -->
<div class="bdy">
	<div class="c0 A-M">
 	
 	{smarty_include eshop.account.leftnav}

<!-- S main -->
		<div class="MAIN">
			<div class="c">
			
				<!-- S tables -->
				<div class="ap">

					<div class="dataTable dataTable1">
						<table>
							<tbody>
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
															<td>
														<span {if $ord.status eq 1}class="wait" {/if}
														{if $ord.status eq 15}class="success" {/if} >
														{Common_Smarty_DataSet_orderStatus status=$ord.status}
														</span></td>
															<td>{$all_payment_method[$ord.payment_method].name}</td>
															<td><a href="{Common_Smarty_Url_format key='order_detail' id=$ord.id}" >查看详情 »</a></td>
														</tr>
							 	{/foreach}
						</tbody>
						</table>
					</div>
						{assign var=url_prefix value="/app/eshop/profile/trading_order"}
							{smarty_include eshop.common.pager}
 

				</div>
				<!-- E tables -->

			</div>
		</div>
<!-- E main -->

	</div>
</div>
<!-- E bdy -->
 

	
	{smarty_include eshop.common.footer}
	
 
</body>
</html>