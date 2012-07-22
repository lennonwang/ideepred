<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>上传商品－新花样</title>
	<link href="/csstyle/forms.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/c/jquery.uploadify.js"></script>
	<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>添加 商品</h1>
		<div id="content-main">
			<form id="edit_product_frm" action="/app/admin/product/save" method="post">
				<input type="hidden" name="id" value="{$product.id}" id="product_id" />
				<input type="hidden" name="work_id" value="{$product.work_id|default:1}" />
				<input type="hidden" name="device_id" value="{$product.device_id|default:-1}" />
				<input type="hidden" name="designer_id" value="{$product.designer_id|default:10}" />
				<input type="hidden" name="sortid" value="{$product.sortid|default:2}" />
				
				<div class="row">
					<label for="category_id">选类别：</label>
					<select name="category_id" id="category_area">
						<option value="">-请选择分类-</option>
						{foreach from=$categorys item=category}
						<option value="{$category.id}" {if $category.id eq $product.category_id}selected{/if}>{$category.title}</option>
						{/foreach}
					</select>
					<label id="device-style">
						{foreach from=$choosed_color item=c}
							<input type="checkbox" {if in_array($c.id, $rem_idea)}checked="checked"{/if} name="idea[]" value="{$c.id}" />{$c.cntitle}
						{/foreach}
					</label>
					<a rel="/app/admin/category/get_color" id="info_category_url"></a>
				</div>
				
				<div class="row">
					<label for="title">标  题：</label>
					<input type="text" name="title" value="{$product.title|stripslashes}" maxlength="60" size="45" id="pro_title" />
				</div>
				
				<div class="row">
					<label for="tags">标  签：</label>
					<textarea name="tags" cols="50" rows="2" id="pro_tags">{$product.tags}</textarea>
					<label class="help">每个标签用空格隔开。</label>
				</div>
				
				<div class="row">
					<label for="retail_price">市场价：</label>
					<input type="text" name="retail_price" value="{$product.retail_price}" size="15"/>
					
					<label for="sale_price" class="l_lef">优惠价：</label>
					<input type="text" name="sale_price" value="{$product.sale_price}" size="15" />
				</div>
				
				<div class="row">
					<label for="picture">商品图：</label>
					<label id="uploadify_assets">Select Files</label>
					<input type="button" id="uploadify_start" value="  开始上传  "/>
				</div>
				<div id="uploadify_goods_result">
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
									[<a href="/app/admin/goods/assign_thumb/id/{$product.id}/asset_id/{$a.id}" class="jq_a_ajax">标记为缩略图</a>] [<a href="/app/admin/goods/remove_assets/id/{$a.id}" class="jq_a_ajax">删除</a>]
								</td>
							</tr>
						</table>								
					</div>
					{/foreach}
					<div class="clearer"></div>
				</div>
				
				<div class="row">
					<label for="summary">简  述：</label>
					<textarea name="summary" cols="50" rows="5">{$product.summary|stripslashes}</textarea>
				</div>
				
				<script type="text/javascript" src="/js/a/goods_edit.js"></script>
				<div class="row">
					<textarea id="cbody" name="content" cols="60" rows="25">{$product.content|stripslashes}</textarea>
				</div>

				<div class="row">
					<input class="default" type="submit" name="_submit" value="  ok,保存  "/>
					<input type="button" name="_back" id="_back" value=" 撤 销 "/>
				</div>
					
			</form>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/goods/edit" title="添加新商品">添加新商品</a>
			</p>
			<p>
				> <a href="/app/admin/goods/display" title="所有商品列表">所有商品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/goods/display/state/0" title="未上架商品列表">未上架商品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/goods/display/state/1" title="已发布商品列表">已发布商品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/goods/display?state=-1" title="已下架商品列表">已下架商品列表</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
<div id="imgPreviewWithStyles"></div>
</body>
</html>