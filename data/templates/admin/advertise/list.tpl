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
	<h2>广告列表</h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="get" action="">
				<div class="tablenav">
					<div class="alignleft actions">
						<select class="select-action" name="action" gtbfieldid="164">
							<option selected="selected" value="-1">批量动作</option>
							<option value="delete">永久删除</option>
						</select>
						<input type="submit" class="button-secondary action" id="doaction" name="doaction" value="应用">
					</div>
					{assign var=url_prefix value="/app/admin/advertise/display/state/$state"}
					{smarty_include admin.pager}
				</div>
				<table cellspacing="0" class="widefat fixed picxe">
					<thead>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="manage-column column-name"> 广告标题 </th>
							<th class="manage-column column-name"> 广告编号 </th>
							<th class="manage-column column-name"> 广告链接 </th>
							<th class="manage-column column-name"> 创建日期 </th>
							<th class="manage-column column-name"> 状 态 </th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="column-icon media-icon"> </th>
							<th class="manage-column column-name"> 广告标题 </th>
							<th class="manage-column column-name"> 广告编号 </th>
							<th class="manage-column column-name"> 广告链接 </th>
							<th class="manage-column column-name"> 创建日期 </th>
							<th class="manage-column column-name"> 状 态 </th>
						</tr>
					</tfoot>
					<tbody id="category-lister">
						{foreach from=$advertise_list item=advertise name="advertise"}
						<tr id="advertise_tr_{$advertise.id}" class="iedit{if $smarty.foreach.advertise.iteration%2 } alternate{/if}">
							<th class="check-column" scope="row">
								<input type="checkbox" value="{$advertise.id}" name="delete[]" />
							</th>
							<td>
								{if $advertise.thumb}
								<img height="60" width="80" class="attachment-80x60" src="{$advertise.thumb}">
								{/if}
							</td>
							<td>
								<strong><a href="/app/admin/advertise/edit?id={$advertise.id}" class="row-title">{$advertise.title}</a></strong>
								<div class="row-actions"><span class="edit"><a href="/app/admin/advertise/edit?id={$advertise.id}">编辑</a> | </span><span class="delete"><a href="/app/admin/advertise/delete?id={$advertise.id}" class="jq_a_ajax">删除</a></span></div>
							</td>
							<td>{$advertise.number}</td>
							<td><a href="{$advertise.link}" target="_blank" title="点击预览">{$advertise.link}</a></td>
							<td>{$advertise.created_on}</td>
							<td>
								<div id="done_{$advertise.id}">
									{if $advertise.state eq 1}
									<a href="/app/admin/advertise/checking?id={$advertise.id}&state=0" title="点击'不发布'" class="jq_a_ajax">
										<img src="/images/admin/icon_accept.gif" alt="发布" />
									</a>
									{/if}
									{if $advertise.state eq 0}
									<a href="/app/admin/advertise/checking?id={$advertise.id}&state=1" title='点击"发布"' class="jq_a_ajax">
										<img src="/images/admin/icon_cancel.gif" alt="未发布" />
									</a>
									{/if}
								</div>
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