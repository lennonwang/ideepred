<replaceContent select="#uploadify_goods_result"><![CDATA[
	<ul class="goods-pic">
	{foreach from=$assets item=a}
	<li id="asset_{$a.id}">
		<img src="{$a.asset_url}" width="120" height="90" name="{$a.id}" class="art_ast" />
		<div class="row-actions">
			<span>尺寸: {$a.width}x{$a.height}px</span>
			[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=44" class="jq_a_ajax">标记为logo</a>] [<a href="/app/admin/asset/remove?id={$a.id}" class="jq_a_ajax">删除</a>]
		</div>
	</li>
	{/foreach}
	</ul>
	<div class="clear"></div>
]]></replaceContent>