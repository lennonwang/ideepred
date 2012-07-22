<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>页面管理</title>
	<meta name="author" content="purpen">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/d/jquery.checkboxes.js"></script>
	<script type="text/javascript" src="/js/a/page_list.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>页面管理 <a href="/app/admin/page/edit" title="创建新文章" class="button add-new-h2">创建新页面</a></h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<div class="form-wrap">
				<form id="posts-filter" method="get" action="/app/admin/page">
					<ul class="subsubsub">
						<li><a href="/app/admin/page">全部<span class="count">({$all_records})</span></a> |</li>
						<li><a href="/app/admin/page/display/status/1">已发布<span class="count">({$published_records})</span></a> |</li>
						<li><a class="current" href="/app/admin/page/display?status=0">草稿<span class="count">({$unpublished_records})</span></a></li>
					</ul>

					<div class="clear"></div>
					<div class="tablenav">
						<div class="alignleft actions">
							<select class="select-action" name="action" gtbfieldid="164">
								<option selected="selected" value="-1">批量动作</option>
								<option value="delete">永久删除</option>
							</select>
							<input type="button" class="button-secondary action" id="doaction" name="doaction" value="应用">
							
						</div>
						{assign var=url_prefix value="/app/admin/page/display"}
						{smarty_include admin.pager}
					</div>
					<table cellspacing="0" class="widefat fixed picxe">
						<thead>
							<tr>
								<th class="check-column"> <input type="checkbox" class="selectscope" /> </th>
								<th class="manage-column column-name"> ID </th>
								<th class="manage-column column-name"> 页面名称 </th>
								<th class="manage-column column-name"> 页面标题 </th>
								<th class="manage-column column-name"> 更新时间 </th>
								<th class="manage-column column-name"> 操作 </th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th class="check-column"> <input type="checkbox" class="selectscope" /> </th>
								<th class="manage-column column-name"> ID </th>
								<th class="manage-column column-name"> 页面名称 </th>
								<th class="manage-column column-name"> 页面标题 </th>
								<th class="manage-column column-name"> 更新时间 </th>
								<th class="manage-column column-name"> 操作 </th>
							</tr>
						</tfoot>
						<tbody id="category-lister">
							{foreach from=$articles item=article name="article"}
							<tr id="article_tr_{$article.id}" class="iedit{if $smarty.foreach.article.iteration%2 } alternate{/if}">
								<th class="check-column" scope="row">
									<input type="checkbox" value="{$article.id}" name="delete[]" class="xe-shid" />
								</th>
								<td>{$article.id}</td>
								<td>{$article.name}</td>
								<td>
									<strong><a href="/app/admin/article/edit/id/{$article.id}" class="row-title">{$article.title} </a> {if $article.status eq 0}-草稿{/if}</strong>
									<div class="row-actions"><span class="edit"><a href="/app/admin/page/edit/id/{$article.id}">编辑</a></span> | <span class="delete"><a href="/app/admin/page/remove/id/{$article.id}" class="jq_a_ajax">删除</a></span> | <span><a href="/app/eshop/index/epage/id/{$article.id}" target="_blank">预览</a></span></div>
								</td>
								<td>{$article.created_on}</td>
								<td> 
									<div id="done_show_{$article.id}"></div>
								</td>
								
							</tr>
							{/foreach}
						</tbody>
					</table>
				</form>
		</div>

	</div>

</div><!--endwrap-->
</body>
</html>