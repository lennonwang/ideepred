<div class="tablenav-pages">
	<span class="displaying-num">显示 {$start}&ndash;{$end} 共 {$records} </span>
	{if $page gt 1}
	<a href="{$url_prefix}&page={$page-1}" class="prev page-numbers">«</a>
	{/if}
	{if $page gte 6 && $total gt 8}
	<a href="{$url_prefix}&page=1" class="page-numbers">1</a>
	<span class="page-numbers dots">...</span>
	{/if}
	{foreach from=$page_list item=p}
	{if $p eq $page}
	<span class="page-numbers current">{$p}</span>
	{else}
	<a href="{$url_prefix}&page={$p}" class="page-numbers">{$p}</a>
	{/if}
	{/foreach}
	{if $page lte $total-5 && $total gt 8}
	<span class="page-numbers dots">...</span>
	<a href="{$url_prefix}&page={$total}" class="page-numbers">{$total}</a>
	{/if}
	{if $page lt $total}
	<a href="{$url_prefix}&page={$page+1}" class="next page-numbers">»</a>
	{/if}
</div>