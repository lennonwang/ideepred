{if $edit_mode eq 'create' or $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated">用户[{$user_id}]信息保存成功.</div>
</prepend>

<val select="input#user_id" value="{$user_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'delete'}
{foreach from=$ids item=id}
<remove select="#user_tr_{$id}" />
{/foreach}
{/if}