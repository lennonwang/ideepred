<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>购物车-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
	<script type="text/javascript" src="/js/e/cart.js"></script>
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		
		<div class="box">
			<div class="bordor profile">
				<h2>我的购物车</h2>
				
				<form name="ibox_cart" action="/app/eshop/shopping/checkout" method="post" class="box_cart_frm">
					<div class="car_item_list" id="cartbarket">	
						<table class="picxe">
							<tr>
								<th class="leftside">商品</th>
								<th>名称</th>
								<th>尺码</th>
								<th>赠送积分</th>
								<th>单价</th>
								<th>数量</th>
								<th>优惠</th>
								<th>小计</th>
								<th class="rightside">操作</th>
							</tr>
							{foreach from=$products item=product name=car}
							<tr id="cart_tr_{$product.sku}" {if $smarty.foreach.car.iteration%2 eq 0}class="odd"{/if}>
								<td class="leftside">
									<a href="{Common_Smarty_Url_format key='product' id=$product.sku}" title="{$product.title}">
										<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb w=90 h=90 is_resize=true}" alt="{$product.title}" />
									</a>
								</td>
								<td class="titd">{$product.title}</td>
								<td>{$product.size}</td>
								<td> - </td>
								<td>{$product.sale_price}</td>
								<td>
									<a href="/app/eshop/shopping/buy_more?id={$product.sku}&size={$product.size}" id="car_product_{$product.sku}"></a>
									<input type="text" name="quantity_{$product.sku}" value="{$product.quantity}" class="small-text jquantity" />
								</td>
								<td> - </td>
								<td><span id="{$product.sku}_money">{$product.quantity*$product.sale_price}</span></td>
								<td class="aorange rightside">
									<a href="/app/eshop/shopping/remove?id={$product.sku}&size={$product.size}" class="jq_a_ajax">删除</a>
								</td>
							</tr>
							{foreachelse}
							<tr class="odd">
								<td colspan="9">
									<p>您还没找到喜欢的产品吗？<a href="{Common_Smarty_Url_format key='domain'}">赶快去选购吧</a></p>
								</td>
							</tr>
							{/foreach}
							<tr class="statistics">
								<td colspan="9">
									<div id="car_subtotal">
										<span>产品数量总计:<em id="cart_items_total">{$items_count}</em>件</span>  <span>产品金额总计(不含运费):<em id="items_total_money">{$total_money}</em>元</span>
									</div>
								</td>
							</tr>
						</table>
						<table class="picxe">
							<tr class="done">
								<td class="txtlef clearfix">
									<a href="/app/eshop/shopping/clear" title="清空购物车" class="jq_a_ajax">
										<img src="/images/eshop/icon-clearnull.png" alt="清空购物车" />
									</a>  
									<a href="javascript:history.go(-1);" title="继续购物">
										<img src="/images/eshop/icon-gobuy.png" alt="继续购物" />
									</a>
								</td>
								<td class="txtrig">
									<input type="image" name="_submit" src="/images/eshop/icon-checkout.png" />
								</td>
							</tr>
						</table>
					</div>	
				</form>
				
			</div>
		</div>

	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>