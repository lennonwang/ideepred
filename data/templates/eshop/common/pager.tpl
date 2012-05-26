<div class="pager">
	<span class="prev">
		{if $page gt 1}<a href="{$url_prefix}/page/{$page-1}">« 前页</a>{else}« 前页{/if}
	</span>
	{if $page gte 6 && $total gt 8}
	<a href="{$url_prefix}/page/1" class="p">1</a>
	<span class="break">...</span>
	{/if}
	{Common_Smarty_Pager_newpager page=$page total=$total}
	{if $p eq $page}
	<span class="c">{$p}</span>
	{else}
	<a href="{$url_prefix}/page/{$p}" class="p">{$p}</a>
	{/if}
	{/Common_Smarty_Pager_newpager}
	{if $page lte $total-5 && $total gt 8}
	<span class="break">...</span>
	<a href="{$url_prefix}/page/{$total}">{$total}</a>
	{/if}
	<span class="next">
		{if $page lt $total}<a href="{$url_prefix}/page/{$page+1}">后页 »</a>{else}后页 »{/if}
	</span>
</div>