<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>品牌管理</title>
	<meta name="author" content="purpen">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/d/jquery.checkboxes.js"></script>
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/a/store.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>全部品牌 <a href="/app/admin/store/edit" title="添加品牌店铺" class="button add-new-h2">添加品牌</a></h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="get" action="/app/admin/store">
				<ul class="subsubsub">
					<li><a href="/app/admin/store/display">全部<span class="count">({$all_count})</span></a> | </li>
					<li><a href="/app/admin/store/display?state=1">已审核品牌<span class="count">({$checked_count})</span></a> | </li>
					<li><a href="/app/admin/store/display?state=0">未审核品牌<span class="count">({$unchecked_count})</span></a> | </li>
				</ul>
				
				<p class="search-box">
					<label for="post-search-input" class="screen-reader-text">搜索品牌:</label>
					<input type="text" value="" name="query" id="post-search-input" gtbfieldid="220">
					<input type="submit" class="button" value=" 搜 索 ">
				</p>
				<div class="clear"></div>
				<div class="tablenav">
					<div class="alignleft actions">
						<select class="select-action" name="action" gtbfieldid="164">
							<option selected="selected" value="-1">批量动作</option>
							<option value="delete">永久删除</option>
						</select>
						<input type="submit" class="button-secondary action" id="doaction" name="doaction" value="应用">
						
						
					</div>
					{assign var=url_prefix value="/app/admin/store/display"}
					{smarty_include admin.pager}
				</div>
				<table cellspacing="0" class="widefat fixed picxe">
					<thead>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="manage-column"> 品牌名称 </th>
							<th class="manage-column column-name"> 分类目录 </th>
							<th class="manage-column column-name"> 经营范围 </th>
							<th class="manage-column column-name"> 操作 </th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="manage-column"> 品牌名称 </th>
							<th class="manage-column column-name"> 分类目录 </th>
							<th class="manage-column column-name"> 经营范围 </th>
							<th class="manage-column column-name"> 操 作 </th>
						</tr>
					</tfoot>
					<tbody id="category-lister">
						{foreach from=$store_list item=store name="store"}
						<tr id="store_tr_{$store.id}" class="iedit{if $smarty.foreach.store.iteration%2 } alternate{/if}">
							<th class="check-column" scope="row">
								<input type="checkbox" value="{$store.id}" name="delete[]" />
							</th>
							<td><img src="{$store.logo}" width="80" height="60" /></td>
							<td>
								<strong><a href="/app/admin/store/edit/id/{$store.id}" class="row-title">{$store.title} </a></strong>
								<div class="row-actions"><span class="edit"><a href="/app/admin/store/edit/id/{$store.id}">编辑</a></span> | <span class="delete"><a href="/app/admin/store/delete/id/{$store.id}" class="jq_a_ajax">删除</a></span></div>
							</td>
							<td>{$store.category}</td>
							<td>
								{$store.service}
							</td>
							<td> 
								<div id="done_show_{$store.id}">
								{if $store.stick eq 1}
									<img src="/images/admin/icon_editor_choice.gif" id="stick_img_{$store.id}" />
								{/if} 
								</div>
							</td>
							
						</tr>
						{/foreach}
					</tbody>
				</table>
			</form>

	</div>

</div><!--endwrap-->
</body>
</html>