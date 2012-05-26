<prepend select="#uploadify_goods_result">
	<div id="_jq_response_result" class="updated"><p>标记为缩略图成功.</p></div>
</prepend>

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}

{if $parent_type eq 4}
<removeClass select="#asset_{$asset_id}" value="blue" />
<removeClass select="#asset_{$asset_id}" value="green" />
<addClass select="#asset_{$asset_id}" value="red" />
{elseif $parent_type eq 5}
<removeClass select="#asset_{$asset_id}" value="blue" />
<removeClass select="#asset_{$asset_id}" value="red" />
<addClass select="#asset_{$asset_id}" value="green" />
{elseif $parent_type eq 7}
<removeClass select="#asset_{$asset_id}" value="green" />
<removeClass select="#asset_{$asset_id}" value="red" />
<addClass select="#asset_{$asset_id}" value="blue" />
{else}
<addClass select="#asset_{$asset_id}" value="blue" />
{/if}