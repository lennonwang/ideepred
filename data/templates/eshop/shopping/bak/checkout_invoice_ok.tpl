<replace select="#chkinv_info"><![CDATA[
<div class="sho_step" id="chkinv_info">
	<h3>发票信息<a href="/app/eshop/shopping/modify/step/invoice" class="a_edit jq_a_ajax">[修改]</a></h3>
	<div class="middle">
		<table>
			<tr>
				<td>发票类型：</td>
				<td>{if $data.invoice_type eq 1}普通发票{/if}</td>
			</tr>
			<tr>
				<td>发票抬头：</td>
				<td>{if $data.invoice_caty eq 'p'}个人{else}单位:{$data.invoice_title}{/if}</td>
			</tr>
			<tr>
				<td>发票内容：</td>
				<td>{$invoice_category[$data.invoice_content]}</td>
			</tr>
		</table>
	</div>
</div>
]]></replace>