{if $edit_mode eq 'create' or $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>页面信息保存成功.</p></div>
</prepend>

<val select="input#link_id" value="{$link_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'delete'}
{foreach from=$ids item=id}
<remove select="#link_tr_{$id}" />
{/foreach}
{/if}