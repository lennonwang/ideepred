{foreach from=$category_path item=cp name=catepath} 
						{if $smarty.foreach.catepath.first}
						>   <a href="{Common_Smarty_Url_format key=channel name=$cp.slug}" title="{$cp.name}">{$cp.name}</a>
						{elseif $smarty.foreach.catepath.last}
						>  {$cp.name}
						{else}
						>  <a href="{Common_Smarty_Url_format key=category_list id=$cp.id}" title="{$cp.name}">{$cp.name}</a>
						{/if}
					 	{if !$smarty.foreach.catepath.last}
						 
						{/if} 
					{/foreach}
					   
					{if $wine_mode}
						{foreach from=$wine_mode_array item=cur_item } 
								{if $cur_item.id eq $wine_mode} > {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $country}
						{foreach from=$wine_country_array item=cur_item } 
								{if $cur_item.id eq $country} > {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $grape_breed}
						{foreach from=$grape_breed_array item=cur_item } 
								{if $cur_item.id eq $grape_breed} > {$cur_item.name}  {/if} 
						{/foreach}
					{/if}
					
					{if $high_price &&  $high_price>0}
						{if ($high_price <= 100) && ($high_price gt 0)} > 0元-100元 {/if}
						{if ($high_price <= 200) && ($high_price gt 101)} > 101元-200元 {/if}
						{if ($high_price <= 300) && ($high_price gt 201)} > 201元-300元 {/if}
						{if ($high_price <= 500) && ($high_price gt 301)} > 301元-500元 {/if}
						{if ($high_price gt 500)} > 500元以上 {/if}
					{/if}

					
					{if $query}> 搜索词:{$query} {/if}