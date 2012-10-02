 

<div class="sho_step" id="chkpay_info">
	<h3>支付方式及配送方式<a href="/app/eshop/shopping/modify/step/payment{if $next_step}?next_step={$next_step}{/if}#chkpay_info" class="a_edit">修改</a></h3>
	<div class="dataTable dataTable3">
		<table class="odrable_show">
			<tr>
				<th>支付方式：</th>
				<td>{$payment_methods[$data.payment_method].name}</td>
			</tr>
			<tr>
				<th>配送方式：</th>
				<td>{$transfer_methods[$data.transfer].name} (费用：{$transfer_methods[$data.transfer].freight}元) </td>
			</tr>
			<tr>
				<th>送货时间：</th>
				<td> {$transfer_times[$data.transfer_time]} </span></td>
			</tr>
			<tr>
				<th>订单备注：</th>
				<td>{$data.summary}</td>
			</tr>
		</table> 
	 
</div>
