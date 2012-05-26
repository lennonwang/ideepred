<prepend select="#content-main">
	<div id="_jq_response_result" class="success_dialog"><p>重建资讯完成.</p></div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}