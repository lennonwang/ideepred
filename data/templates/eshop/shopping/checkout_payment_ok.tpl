<div class="sho_step" id="chkadd_info">
<!--
	<h3>收货人信息<a href="/app/eshop/shopping/modify/step/address{if $next_step}?next_step={$next_step}{/if}" class="a_edit">修改</a></h3>
	-->
	<h3>收货人信息<a href="/app/eshop/shopping/modify/step/payment{if $next_step}?next_step={$next_step}{/if}#chkpay_address" class="a_edit">修改</a></h3>
	<div class="middle">
		<table class="odrable_show">
			<tr>
				<th><span class="star">*</span>收货人姓名：</th>
				<td>{$data.name}</td>
			</tr>
			<tr>
				<th><span class="star">*</span>地址：  </th>
				<td>
				{if isset($data.province) and $data.province >0 }
					{Common_Smarty_DataSet_placeName id=$data.province} 
				{/if}
				{if isset($data.city) and $data.city >0 }
				{Common_Smarty_DataSet_placeName id=$data.city} 
				{/if}
				{$data.address}</td>
			</tr>
			<tr>
				<th>邮编：</th>
				<td>{$data.zip}</td>
			</tr>
			<tr>
				<th>固定电话：</th>
				<td>{$data.telephone}</td>
			</tr>
			<tr>
				<th><span class="star">*</span>手机号码：</th>
				<td>{$data.mobie}</td>
			</tr>
			<tr>
				<th><span class="star">*</span>电子邮件：</th>
				<td>{$data.email}</td>
			</tr>
		</table>
	</div>
</div>


<div class="sho_step" id="chkpay_info">
	<h3>支付方式及配送方式<a href="/app/eshop/shopping/modify/step/payment{if $next_step}?next_step={$next_step}{/if}#chkpay_info" class="a_edit">修改</a></h3>
	<div class="middle">
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
