<div id="friend-links" class="mt-10 p-10 mb-10 c3">
	<p>友情链接： {foreach from=$link_list item=link name="link"}<a href="{$link.url}" target="_blank">{$link.title}</a> {if !$smarty.foreach.link.last } |{/if} {/foreach}</p>
</div>