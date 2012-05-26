<replaceContent select="#uploadify_goods_result"><![CDATA[
	<ul class="goods-pic">
	{foreach from=$assets item=a}
	<li id="asset_{$a.id}" class="{if $a.parent_type eq 4}red{elseif $a.parent_type eq 5}green{elseif $a.parent_type eq 7}blue{/if}">
		<a href="/app/admin/article/insert_asset/asset_id/{$a.id}#insert_asset" class="jq_a_ajax">
			<img src="{$a.water_image}" width="120" height="90" name="{$a.id}" class="art_ast" />
		</a>
		<div class="row-actions">
			<span>尺寸: {$a.width}x{$a.height}px</span>
			[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=4" class="jq_a_ajax">标正</a>] [<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=5" class="jq_a_ajax">标细</a>] [<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=7" class="jq_a_ajax">标内</a>] [<a href="/app/admin/asset/delete?id={$a.id}" class="jq_a_ajax">删除</a>]
		</div>
	</li>
	{/foreach}
	</ul>
	<div class="clear"></div>
]]></replaceContent>