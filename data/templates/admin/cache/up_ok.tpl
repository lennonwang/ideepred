<prepend select="#changelist">
	<div id="_jq_response_result" class="success_dialog">缓存更新成功.</div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
