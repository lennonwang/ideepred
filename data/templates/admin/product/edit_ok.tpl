{if $edit_mode eq 'create' or $edit_mode eq 'edit'}
<prepend select="#ajax-response">
	<div id="_jq_response_result" class="updated"><p>产品信息保存成功.</p></div>
</prepend>

<val select="input#product_id" value="{$product_id}" />

{literal}
<eval><![CDATA[
$('#_jq_response_result').fadeOut(3000,function(){$(this).remove();});
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'create'}
{literal}
<eval><![CDATA[
var product_id=$('#product_id').val(); 
window.location.href="/app/admin/product/edit/id/"+product_id; 
]]></eval>
{/literal}
{/if}

{if $edit_mode eq 'create'}
<before select="#tagsdiv-post_tag"><![CDATA[
	<div id="picturediv-stuff" class="postbox ">
		<div title="显示/隐藏" class="handlediv"><br></div>
		<h3 class="hndle">
			<span>产品照片</span>
		</h3>
	
		<div class="inside">
			<p class="howto">图例说明：标正(正面大图)、标细(细节图片)、标内(内容图片)。</p>
			<div id="product-photos" class="tagsdiv">
				<label id="uploadify_assets">Select Files</label>
			</div>
			
			<div id="uploadify_goods_result"></div>
		</div>
	</div>
]]></before>
<append select="head">
	<script type="text/javascript" src="/js/a/upload_photo.js"></script>
</append>
{/if}

{if $edit_mode eq 'delete'}
{foreach from=$ids item=id}
<remove select="#product_tr_{$id}" />
{/foreach}
{/if}

{if $edit_mode eq 'publish'}
{foreach from=$ids item=id}
{if $stick eq 1}
<append select="#done_show_{$id}">
	<img src="/images/admin/icon_editor_choice.gif" id="stick_img_{$id}" />
</append>
{else}
<remove select="#stick_img_{$id}" />
{/if}
{/foreach}
{/if}

{if $edit_mode eq 'marked'}
{foreach from=$ids item=id}
{if $is_markshop eq 1}
<append select="#done_show_{$id}">
	<img src="/images/admin/icon_accept.gif" id="markshop_img_{$id}" />
</append>
{else}
<remove select="#markshop_img_{$id}" />
{/if}
{/foreach}
{/if}