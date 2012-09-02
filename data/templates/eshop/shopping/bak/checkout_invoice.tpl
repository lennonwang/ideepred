<replace select="#chkinv_info"><![CDATA[
<div class="sho_step editable" id="chkinv_info">
	<h3>发票信息<a href="/app/eshop/shopping/close/step/invoice" class="a_close jq_a_ajax">[关闭]</a></h3>
	<form method="post" action="/app/eshop/shopping/do_process" id="invoice_ofrm">
		<table>
			<tr>
				<td class="td_lab">发票类型：</td>
				<td><input type="radio" name="invoice_type" value="1" checked="checked" /><label>普通发票</label></td>
			</tr>
			<tr>
				<td class="td_lab">发票抬头：</td>
				<td>
					<input type="radio" name="invoice_caty" value="p" {if $data.invoice_caty eq 'p'}checked="checked"{/if}/><label>个人</label>
					<input type="radio" name="invoice_caty" value="c" {if $data.invoice_caty eq 'c'}checked="checked"{/if}/><label>单位</label>
				</td>
			</tr>
			
			<tr id="tr_invoice_title" {if $data.invoice_caty neq 'c'}class="hidden"{/if}>
				<td class="td_lab">单位名称：</td>
				<td colspan="2">
					<table>
						<tr>
							<td>
					        <input type="text" name="invoice_title" value="{$data.invoice_title}" id="invoice_title" /><br />
					        <span class="s_tips">温馨提示：您填写的所有内容都将被系统自动打印到发票上，所以请千万别填写和发票抬头无关的信息。</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td class="td_lab">发票内容：</td>
				<td>
					{foreach from=$invoice_category item=c key=key}
					<input type="radio" name="invoice_content" value="{$key}" {if $key eq  $data.invoice_content}checked="checked"{/if}/><label>{$c}</label>
					{/foreach}
				</td>
			</tr>
			<tr>
				<td class="td_lab"></td>
				<td><a href="#submit_order" class="go_submit jq_a_ajax" name="invoice_ofrm">保存发票信息</a></td>
			</tr>
		</table>
		<input type="hidden" name="step" value="invoice" />
	</form>
</div>
]]></replace>