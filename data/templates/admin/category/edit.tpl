<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/a/category.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>分类目录 <a href="/app/admin/category/edit" title="创建新分类目录" class="button add-new-h2">创建新分类目录</a></h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
			<div class="form-wrap">
				<h3>添加分类目录</h3>
				<form action="/app/admin/category/save" method="post" id="addcat" name="addcat">					
					<input type="hidden" value="{$category.id}" name="id" id="category_id">
					<input type="hidden" value="{$category.code}" name="code" id="code">
					<input type="hidden" value="{$rand_sign}" name="rand_sign_id" id="rand_sign_id">
					<table class="form-table">
						<tbody>
							<tr class="form-field form-required">
								<th valign="top" scope="row"><label for="type">分类级别</label></th>
								<td>
									<input type="radio" name="type" value="1" {if $type eq 1}checked="checked"{/if} />一级
									<input type="radio" name="type" value="2" {if $type eq 2}checked="checked"{/if} />二级
									<input type="radio" name="type" value="3" {if $type eq 3}checked="checked"{/if} />三级
								</td>
							</tr>
							<tr class="form-field form-required">
								<th valign="top" scope="row"><label for="name">分类目录名</label></th>
								<td><input type="text" size="40" value="{$category.name}" id="name" name="name" /></td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="slug">分类目录别名</label></th>
								<td><input type="text" size="40" value="{$category.slug}" id="slug" name="slug" /><br>
					            <span class="description">“别名” 是URL友好的另外一个名称。它通常为小写并且只能包含字母，数字和连字符。</span></td>
							</tr>
							
							{if $is_open_thumb eq 'open'}
							<tr class="form-field form-upload">
								<th valign="top" scope="row"></th>
								<td>
									<div id="uploadify_goods_result">

										<ul class="goods-pic">
											{if $category_thumb}
											<li id="asset_{$category_thumb.id}">
												<img src="{$category_thumb.asset_url}" width="120" height="90" name="{$category_thumb.id}" class="art_ast" />
												<div class="row-actions">
													<span>尺寸: {$category_thumb.width}x{$category_thumb.height}px</span>
													[<a href="/app/admin/asset/delete/id/{$category_thumb.id}" class="jq_a_ajax">删除</a>]
												</div>
											</li>
											{/if}
										</ul>
									</div>
								</td>
							</tr>
							<tr class="form-field form-upload">
								<th valign="top" scope="row"><label for="thumb">分类缩略图</label></th>
								<td><label id="uploadify_thumb">Select Files</label></td>
							</tr>
							{/if}
							
							<tr class="form-field">
								<th valign="top" scope="row"><label for="parent_id">分类目录上级</label></th>
								<td>
									<div class="site_node_list">
										{foreach from=$all_category item=cate}
										<span class="{$cate.classname}"> <input type="radio" name="parent_code" value="{$cate.code}" {if $category.code eq $cate.code}checked="checked"{/if} /> <strong> {$cate.name}  --  {$cate.code} </strong> </span>
										{/foreach}
									</div>
					                <span class="description">分类目录，和标签不同，它可以有层级关系。</span>
						  		</td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="stick">是否推荐</label></th>
								<td>
								<input type="radio" name="stick" value="1" {if $category.stick eq 0}checked="checked"{/if} />是
								<input type="radio" name="stick" value="0" {if $category.stick eq 0}checked="checked"{/if} />否
								<br>
					            <span class="description">若有频道页，推荐分类可以优先显示。</span></td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="description">描述</label></th>
								<td><textarea cols="50" rows="5" id="description" name="description">{$category.description}</textarea><br>
					            <span class="description">“描述”不一定会被显示，但有的主题会显示它。</span></td>
							</tr>
								</tbody>
							</table>

							<p class="submit">
								<input type="submit" value="更新分类目录" name="submit" class="button">
							</p>
				</form>
			</div>
		
	</div>

</div><!--endwrap-->
</body>
</html>