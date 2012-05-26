{if $edit_mode eq 'create' or $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>文章信息保存成功.</p></div>
</prepend>

<val select="input#article_id" value="{$article_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'delete'}
{foreach from=$ids item=id}
<remove select="#article_tr_{$id}" />
{/foreach}
{/if}

{if $edit_mode eq 'stick'}
{foreach from=$ids item=id}
{if $stick eq 0}
<remove select="#stick_img_{$id}" />
{/if}
{if $stick eq 1}
<append select="#done_show_{$id}">
	<img src="/images/admin/icon_editor_choice.gif" id="stick_img_{$id}" />
</append>
{/if}
{/foreach}
{/if}
