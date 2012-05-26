<prepend select="#uploadify_goods_result">
	<div id="_jq_response_result" class="success_dialog">标示缩略图成功.</div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
