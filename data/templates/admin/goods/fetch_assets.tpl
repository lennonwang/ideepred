<replaceContent select="#uploadify_goods_result"><![CDATA[
{foreach from=$assets item=a}
<div id="asset_{$a.id}" class="goods-pic">
	<table>
		<tr>
			<td>
				<img src="{$a.url}" width="176" name="{$a.id}" class="art_ast" />
				<br />
				<span>尺寸: {$a.width}x{$a.height}px</span>
			</td>
		</tr>	
		<tr>
			<td>
				[<a href="/app/admin/goods/assign_thumb/id/{$id}/asset_id/{$a.id}" class="jq_a_ajax">标记为缩略图</a>] [<a href="/app/admin/goods/remove_assets/id/{$a.id}" class="jq_a_ajax">删除</a>]
			</td>
		</tr>
	</table>								
</div>
{/foreach}
]]></replaceContent>