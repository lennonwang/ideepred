{if $edit_mode eq 'create' or $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>变更信息保存成功，请等待审核！</p></div>
</prepend>

<val select="input#purchase_id" value="{$purchase_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'delete' or $edit_mode eq 'check'}
{foreach from=$ids item=id}
<remove select="#purchase_tr_{$id}" />
{/foreach}
{/if}