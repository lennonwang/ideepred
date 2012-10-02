<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>提交订单--{smarty_include eshop.common.xtitle}</title>
	<link type="image/x-icon" href="/favicon.ico" rel="shortcut icon"/>  s
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/confirm.js"></script>
</head>

<body> 

		{smarty_include eshop.common.header}

		<div id="container"> 
			<div class="box">
				<div class="bordor" id="orderfrom">
					<h2>结算步骤: <span id="shoppingstep_1">1.登录注册</span> >> <span id="shoppingstep_2">2.填写核对订单信息</span> >> <span id="shoppingstep_3" class="current_step">3.提交订单</span></h2>
					
					<p class="hotlink">带*的项目为必填项</p>
			 
					
					{smarty_include eshop.shopping.checkout_payment_ok}
					{*
					{smarty_include eshop.shopping.checkout_notice_ok}
					*}
					
					<div class="sho_step">
						<h3>商品清单 <a href="{Common_Smarty_Url_format key='cart'}" class="a_edit b_cart">« 返回修改购物车</a></h3>
						<div class="car_item_list">
							<table class="ablue picxe">
								<tr>
									<th>商 品</th>
									<th>名 称</th>
									<th>单 价</th>
									<th>数 量</th>
									<th>小 计</th>
								</tr>
								{foreach from=$products item=p}
								<tr>
									<td class="leftside">
										<img src="{Common_Smarty_Product_photoThumb thumb_path=$p.thumb w=107 h=107 is_resize=true}" alt="{$p.title}" />
									</td>
									<td>
										<a href="{Common_Smarty_Url_format key='product' id=$p.sku}" target="_blank">{$p.title}{if $p.size} ({$p.size}){/if}</a>
									</td>
									<td>
										{$p.sale_price}元
									</td>
									<td>{$p.quantity}</td>
									<td>{$p.quantity*$p.sale_price}元</td>
								</tr>
								{/foreach}
							</table>
						</div>
					</div>
					
					<div class="sho_step last" id="chklist_info">
						<h3>结算信息1</h3>
						<div class="car_item_list">
							<table class="picxe">
								<tr>
									<th>商品金额（元）</th>
									<th>运 费（元）</th>
									<th>优惠金额（元）</th>
									<th class="td_size">应付金额（元）</td>
								</tr>
								<tr class="tr_col">
									<td>{$total_money}</td>
									<td><span id="transfer_money">{$freight}</span></td>
									<td><span>{$sale_amount|default:0}</span></td>
									<td><span id="pay_total_money">{$pay_money}</span></td>
								</tr>
							</table>
						</div>
					</div>
					
					<div id="do_buy" class="ablue">
						<a href="{Common_Smarty_Url_format key='cart'}" class="a_back">« 返回购物车</a>
						  <a href="#checkout_confirm" class="confirm_chk jq_a_ajax" rel="{Common_Smarty_Url_format key='confirm_order'}">提交订单</a>  
					</div>
					
				</div>
			</div>  

		{smarty_include eshop.site-help}

		{smarty_include eshop.footer}
	</div>
	
</body>
</html>