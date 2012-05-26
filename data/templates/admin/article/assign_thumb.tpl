<prepend select="#uploadify_result">
	<div id="_jq_response_result" class="success_dialog"><p>标示缩略图成功.</p></div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}