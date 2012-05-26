<replace select="#pay_money_{$id}">
	<label id="pay_money_{$id}">{$pay_money}</label>
</replace>

<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>订单[{$id}]快递费用已修改成功！</p></div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}