<prepend select="#edit_role_frm">
	<div id="_jq_response_result" class="success_dialog">用户组[{$role_id}]信息保存成功.</div>
</prepend>

<val select="input#role_id" value="{$role_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}