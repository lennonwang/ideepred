<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>常规选项信息保存成功.</p></div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}