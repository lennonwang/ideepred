{if $edit_mode eq 'create' or $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>促销活动信息保存成功.</p></div>
</prepend>

<val select="input#marketing_id" value="{$marketing_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'delete'}
{foreach from=$ids item=id}
<remove select="#marketing_tr_{$id}" />
{/foreach}
{/if}

{if $edit_mode eq 'publish'}
<remove select="#marketing_tr_{$id}" />
{/if}