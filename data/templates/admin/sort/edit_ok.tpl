<prepend select="#edit_sort_frm">
	<div id="_jq_response_result" class="success_dialog">分类[{$sort_id}]信息保存成功.</div>
</prepend>

<val select="input#sort_id" value="{$sort_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}