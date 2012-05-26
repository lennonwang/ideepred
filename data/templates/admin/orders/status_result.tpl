{if $edit_step eq 'list'}
<remove select="#order_tr_{$id}" />
{/if}

{if $edit_step eq 'view'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>订单状态操作成功！</p></div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}