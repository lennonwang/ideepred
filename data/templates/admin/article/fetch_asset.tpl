<append select="#uploadify_goods_result"><![CDATA[
<ul class="goods-pic">
	{foreach from=$assets item=a}
	<li id="asset_{$a.id}">
		<a href="/app/admin/content/insert_asset/asset_id/{$a.id}" class="jq_a_ajax">
			<img src="{$a.asset_url}" width="120" height="90" name="{$a.id}" class="art_ast" />
		</a>
		<div class="row-actions">
			<span>尺寸: {$a.width}x{$a.height}px</span>
			[<a href="/app/admin/asset/delete?id={$a.id}" class="jq_a_ajax">删除</a>]
		</div>
	</li>
	{/foreach}
</ul>
<div class="clear"></div>
]]></append>