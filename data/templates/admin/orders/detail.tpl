<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	{literal}
	<script type="text/javascript">
	$(function(){
		$('#dockout').click(function(){
			var order_id = $('#order_id').val();
			var url = "/app/admin/orders/update_status";
			$.get(url,{id:order_id,status:-2});
		});
	});
	</script>
	{/literal}
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>订单详情</h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="post" action="/app/admin/orders/display">
				<ul class="subsubsub">
					<li><a href="/app/admin/orders">全部<span class="count">({$all_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=20">已成功订单<span class="count">({$published_records})</span></a> | </li>
					<li><a href="/app/admin/orders/display/status/1">等待付款<span class="count">({$wait_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=10">正在配货<span class="count">({$ready_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=15">已发货订单<span class="count">({$send_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=-1">过期订单<span class="count">({$expired_records})</span></a> | </li>
					<li><a class="current" href="/app/admin/orders/display?status=0">已取消订单<span class="count">({$canceled_records})</span></a> | </li>
				</ul>
				
				<p class="search-box">
					<label for="post-search-input" class="screen-reader-text">搜索订单:</label>
					<input type="text" value="{$query}" name="query" id="post-search-input" gtbfieldid="220">
					<input type="submit" class="button" value="搜索订单" />
				</p>
				
				<div class="clear"></div>

				<div class="tablenav">
					<div class="alignleft actions">
						<label>订单操作/状态:（{Common_Smarty_DataSet_orderStatus status=$order.status}）</label>
						<label>{if $order.status eq 10}
						<a href="/app/admin/orders/update_status?id={$order.id}&status=15&edit_step=view" class="jq_a_ajax">开始发货</a>{/if} 
							{if $order.status eq 1} 
						<a href="/app/admin/orders/update_status?id={$order.id}&status=0&edit_step=view" jq_confirm="确定要取消订单？" class="jq_a_ajax">取消订单</a>{/if}
						 {if $order.status eq 15}
						 <a href="/app/admin/orders/update_status?id={$order.id}&status=20&edit_step=view" class="jq_a_ajax">完成订单</a>{/if}</label>
					</div>
				</div>
				
				<div class="meta-box-sortables ui-sortable" id="order_item_info">

					<div class="postbox" id="postexcerpt">
						<div class="handlediv" title="显示/隐藏"><br></div>
						<h3 class="hndle"><span>订单基本信息</span></h3>
						<div class="inside">
							<table class="form-table">
								<tr>
									<td><label>订单编号：</label>{$order.reference}</td>
									<td><label>下单日期：</label>{$order.created_on}</td>
								</tr>
								<tr>
									<td><label>订单总金额：</label>{$order.pay_money}元 = {$order.total_money}元 + {$order.freight}元 - {$order.card_money|default:0}元</td>
									<td><label>支付方式：</label>{$payment_methods[$order.payment_method].name}</td>
								</tr>
								<tr>
									<td><label>客户姓名：</label>{$order.name}</td>
									<td><label>E-mail邮箱：</label>{$order.email}</td>
								</tr>
								<tr>
									<td><label>联系电话：</label>{$order.mobie} ({$order.telephone})</td>
									<td><label>地 址：</label>{Common_Smarty_DataSet_placeName id=$order.province} {Common_Smarty_DataSet_placeName id=$order.city} {$order.address}</td>
								</tr>
								
								<tr>
									<td><label>送货方式：</label>{$transfer_methods[$order.transfer].name}</td>
									<td><label>送货时间：</label>{$transfer_times[$order.transfer_time]}</td>
								</tr>
								<tr>
									<td colspan="2"><label>备 注：</label>{$order.summary}</td>
								</tr>
							</table>
						</div>

					</div>
					
					<br />
					
					<div class="postbox" id="postexcerpt">
						<div class="handlediv" title="显示/隐藏"><br></div>
						<h3 class="hndle"><span>订单明细</span></h3>
						<div class="inside">
							<table class="form-table">
								<thead>
									<tr>
										<th>产品信息</th>
										<td>产品名称</td>
										<td>产品sku</td>
										<td>价 格</td>
										<td>数 量</td>
									</tr>
								</thead>
								<tbody>
									{foreach from=$plist item=product}
									<tr>
										<th>
											<img src="{Common_Smarty_Product_photoThumb thumb_path=$product.thumb w=107 h=107 is_resize=true}" alt="{$product.title}" />
										</th>
										<td>
											{$product.title}
										</td>
										<td>
											{$product.id}
										</td>
										<td>
											{$product.sale_price} 元
										</td>
										<td>
											{$product.quantity} {$product.unit}
										</td>
									</tr>
									{/foreach}
								</tbody>
							</table>
						</div>
					</div>
				
					<br />
					
				
				</div>
			</form>
		</div>
		
	</div>
</div><!--endwrap-->
</body>
</html>