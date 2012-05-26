<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated">{$msg}</div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}