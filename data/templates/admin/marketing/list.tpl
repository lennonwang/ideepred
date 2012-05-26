<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>促销活动列表 <a class="button add-new-h2" title="添加促销活动" href="/app/admin/marketing/edit">添加促销活动</a></h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="get" action="">
				<ul class="subsubsub">
					<li><a href="#">全部活动</a> |</li>
					<li><a href="/app/admin/marketing/display?status=1">进行中<span class="count">({$publishing_records})</span></a> |</li>
					<li><a class="current" href="/app/admin/marketing/display?status=0">未进行<span class="count">({$unpublished_records})</span></a></li>
					<li><a class="current" href="/app/admin/marketing/display?status=-1">已结束<span class="count">({$published_records})</span></a></li>
				</ul>
				
				<div class="tablenav">
					<div class="alignleft actions">
						<select class="select-action" name="action" gtbfieldid="164">
							<option selected="selected" value="-1">批量动作</option>
							<option value="delete">永久删除</option>
						</select>
						<input type="submit" class="button-secondary action" id="doaction" name="doaction" value="应用">
					</div>
					{assign var=url_prefix value="/app/admin/marketing/display/status/$status"}
					{smarty_include admin.pager}
				</div>
				<table cellspacing="0" class="widefat fixed picxe">
					<thead>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="manage-column column-name"> 活动标题 </th>
							<th class="manage-column"> 活动说明 </th>
							<th class="manage-column column-name"> 活动类型 </th>
							<th class="manage-column column-name"> 创建日期 </th>
							<th class="manage-column column-name"> 状 态 </th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="manage-column column-name"> 活动标题 </th>
							<th class="manage-column"> 活动说明 </th>
							<th class="manage-column column-name"> 活动类型 </th>
							<th class="manage-column column-name"> 创建日期 </th>
							<th class="manage-column column-name"> 状 态 </th>
						</tr>
					</tfoot>
					<tbody id="category-lister">
						{foreach from=$marketing_list item=marketing name="marketing"}
						<tr id="marketing_tr_{$marketing.id}" class="iedit{if $smarty.foreach.marketing.iteration%2 } alternate{/if}">
							<th class="check-column" scope="row">
								<input type="checkbox" value="{$marketing.id}" name="delete[]" />
							</th>
							<td>
								<strong><a href="/app/admin/marketing/edit?id={$marketing.id}" class="row-title">{$marketing.title}</a></strong>
								<div class="row-actions"><span class="edit"><a href="/app/admin/marketing/edit?id={$marketing.id}">编辑</a></span> | <span class="delete"><a href="/app/admin/marketing/delete?id={$marketing.id}" class="jq_a_ajax">删除</a></span>{if $marketing.status eq 0} | <span class="check"><a href="/app/admin/marketing/checking?id={$marketing.id}&status=1" class="jq_a_ajax">发布</a></span>{/if}{if $marketing.status eq 1} | <span class="check"><a href="/app/admin/marketing/checking?id={$marketing.id}&status=-1" class="jq_a_ajax">结束活动</a></span>{/if}</div>
							</td>
							<td>{$marketing.summary}</td>
							<td>
								{if $marketing.type eq 1}买就送{/if}
							</td>
							<td>{$marketing.created_on}</td>
							<td>
								{if $marketing.status eq 1}进行中{elseif $marketing.status eq -1}已结束{else}未进行{/if}
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