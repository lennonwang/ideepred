{if $edit_mode eq 'create' or $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated">广告位[{$advertise_id}]信息保存成功.</div>
</prepend>

<val select="input#advertise_id" value="{$advertise_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'delete'}
{foreach from=$ids item=id}
<remove select="#advertise_tr_{$id}" />
{/foreach}
{/if}

{if $edit_mode eq 'publish'}
<replace select="#done_{$id}">
	<div id="done_{$id}">
		{if $state eq 1}
		<a href="/app/admin/advertise/checking/id/{$id}/state/0" title="点击'不发布'" class="jq_a_ajax">
			<img src="/images/admin/icon_accept.gif" alt="发布" />
		</a>
		{/if}
		{if $state eq 0}
		<a href="/app/admin/advertise/checking/id/{$id}/state/1" title='点击"发布"' class="jq_a_ajax">
			<img src="/images/admin/icon_cancel.gif" alt="未发布" />
		</a>
		{/if}
	</div>
</replace>
{/if}

