<div class="categories">
	<ul>
		{foreach from=$category_channel item=chk name=cha}
		<li>
			<a href="{Common_Smarty_Url_format key=channel slug=$chk.slug}" title="{$chk.name}" class="firstcate {if $chk.code eq $channel.code}js-open{/if} {if $smarty.foreach.cha.last}lastcha{/if}">{$chk.name}</a>
			
			{if $chk.code eq $channel.code}
				<ul>
				{foreach from=$children_category item=category name=cate}
					<li class="ifarther {$category.classname} {if $smarty.foreach.cate.last}last{/if}">
						<a href="{Common_Smarty_Url_format key=category_list catcode=$category.code}" title="{$category.name}-" {if $category.code eq $current_category.code}class="current"{/if}>
							<span> {$category.name}</span>
						</a>
					</li>
				{/foreach}
					<div class="clear"></div>
				</ul>
			{/if}
			
		</li>
		{/foreach}
	</ul>
	
</div>