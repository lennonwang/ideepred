<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>链接管理</title>
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
	<h2>链接管理 <a href="/app/admin/link/edit" title="创建新链接" class="button add-new-h2">创建新链接</a></h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<div class="form-wrap">
				<form id="posts-filter" method="get" action="/app/admin/link">
					<div class="clear"></div>
					<div class="tablenav">
						<div class="alignleft actions">
							<select class="select-action" name="action" gtbfieldid="164">
								<option selected="selected" value="-1">批量动作</option>
								<option value="delete">永久删除</option>
							</select>
							<input type="button" class="button-secondary action" id="doaction" name="doaction" value="应用">
							
						</div>
						{assign var=url_prefix value="/app/admin/link/display"}
						{smarty_include admin.pager}
					</div>
					<table cellspacing="0" class="widefat fixed picxe">
						<thead>
							<tr>
								<th class="check-column"> <input type="checkbox" class="selectscope" /> </th>
								<th class="manage-column column-name"> ID </th>
								<th class="manage-column column-name"> 名称 </th>
								<th class="manage-column column-name"> 链接 </th>
								<th class="manage-column column-name"> 排序 </th>
								<th class="manage-column column-name"> 更新时间 </th>
								<th class="manage-column column-name"> 操作 </th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th class="check-column"> <input type="checkbox" class="selectscope" /> </th>
								<th class="manage-column column-name"> ID </th>
								<th class="manage-column column-name"> 名称 </th>
								<th class="manage-column column-name"> 链接 </th>
								<th class="manage-column column-name"> 排序 </th>
								<th class="manage-column column-name"> 更新时间 </th>
								<th class="manage-column column-name"> 操作 </th>
							</tr>
						</tfoot>
						<tbody id="category-lister">
							{foreach from=$links item=link name="link"}
							<tr id="link_tr_{$link.id}" class="iedit{if $smarty.foreach.link.iteration%2 } alternate{/if}">
								<th class="check-column" scope="row">
									<input type="checkbox" value="{$link.id}" name="delete[]" class="xe-shid" />
								</th>
								<td>{$link.id}</td>
								<td>{$link.title}</td>
								<td>{$link.url}</td>
								<td>{$link.sort}</td>
								<td>{$link.created_at}</td>
								<td>
									<div class="row-actions"><span class="edit"><a href="/app/admin/link/edit?id={$link.id}">编辑</a></span> | <span class="delete"><a href="/app/admin/link/remove?id={$link.id}" class="jq_a_ajax">删除</a></span> </div>
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