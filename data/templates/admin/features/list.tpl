<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/a/features.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>定义产品属性 <a class="button add-new-h2" title="添加产品属性" href="/app/admin/features/edit">添加产品属性</a></h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div id="col-right">
			<div class="tablenav">
				<div class="alignleft actions"></div>
				{assign var=url_prefix value="/app/admin/category/display"}
				{smarty_include admin.pager}
			</div>
			<table cellspacing="0" class="widefat fixed">
				<thead>
					<tr>
						<th class="check-column"> <input type="checkbox" /> </th>
						<th class="manage-column column-name"> 属性名称 </th>
						<th class="manage-column column-name"> 属性标识 </th>
						<th class="manage-column column-name"> 所属分类目录 </th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="check-column"> <input type="checkbox" /> </th>
						<th class="manage-column column-name"> 属性名称 </th>
						<th class="manage-column column-name"> 属性标识 </th>
						<th class="manage-column column-name"> 所属分类目录 </th>
					</tr>
				</tfoot>
				<tbody id="category-lister">
					{foreach from=$features_list item=feature name="cat"}
					<tr id="features_tr_{$feature.id}" class="iedit{if $smarty.foreach.cat.iteration%2 } alternate{/if}">
						<th class="check-column" scope="row">
							<input type="checkbox" value="{$feature.id}" name="delete[]" />
						</th>
						<td>
							<strong><a href="#" class="row-title">{$feature.featurename}</a></strong>
							<div class="row-actions"><span class="edit"><a href="/app/admin/features/edit/id/{$feature.id}">编辑</a> | </span><span class="delete"><a href="/app/admin/features/remove/id/{$feature.id}" class="jq_a_ajax">删除</a></span></div>
						</td>
						<td>{$feature.featurekey}</td>
						<td><a href="/app/admin/category/edit/id/{$feature.category.id}" >{$feature.category.name}</a></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
		
		<div id="col-left">
			<div class="form-wrap">
				<form action="/app/admin/features/save" method="post" id="addcat" name="addcat">					
					<input type="hidden" value="" name="id" id="features_id">
					
					<div class="form-field form-required">
						<label for="featurename">属性名称</label>
						<input type="text" size="40" value="" id="featurename" name="featurename" />
					    <p>用来渲染模板显示名称。</p>
					</div>

					<div class="form-field">
						<label for="featurekey">属性标识</label>
						<input type="text" size="40" value="" id="featurekey" name="featurekey" />
					    <p>用来便于系统标识key。它通常为小写并且只能包含字母，数字和连字符。</p>
					</div>

					<div class="form-field">
						<label for="parent_id">所属分类目录</label>
						
						<div class="site_node_list">
							{foreach from=$all_category item=cate}
							<span class="{$cate.classname}"> <input type="radio" name="parent_id" value="{$cate.id}" /> <strong> {$cate.name}  --  {$cate.code} </strong> </span>
							{/foreach}
						</div>
						
					    <p>某一分类产品共同具有的属性。</p>
					</div>

					<p class="submit">
						<input type="submit" value="添加产品属性" name="submit" class="button">
					</p>
					
				</form>
			</div>
		</div>
		
	</div>

</div><!--endwrap-->
</body>
</html>