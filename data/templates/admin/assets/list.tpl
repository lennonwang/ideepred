<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/c/jquery.checkboxes.js"></script>
	<script type="text/javascript" src="/js/a/assets.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>媒体库</h2>
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
					<input type="hidden" value="699ee67094" name="_wpnonce" id="_wpnonce"><input type="hidden" value="/wp-admin/upload.php" name="_wp_http_referer">
					<select name="m" gtbfieldid="165">
						<option value="0">显示所有日期</option>
						<option value="201008">八月 2010</option>
						<option value="201007">七月 2010</option>
						<option value="201006">六月 2010</option>
						<option value="201005">五月 2010</option>
					</select>
					<input type="submit" class="button-secondary" value="过滤" id="post-query-submit">
				</div>
				
				{assign var=url_prefix value="/app/admin/asset/listing"}
				{smarty_include admin.pager}
			</div>
			<table cellspacing="0" class="widefat fixed picxe">
				<thead>
					<tr>
						<th class="check-column"> <input type="checkbox" /> </th>
						<th class="column-icon media-icon"> </th>
						<th class="manage-column column-name"> 文件 </th>
						<th class="manage-column column-name"> 附加到 </th>
						<th class="manage-column column-name"> 日期 </th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="check-column"> <input type="checkbox" /> </th>
						<th class="column-icon media-icon"> </th>
						<th class="manage-column column-name"> 文件 </th>
						<th class="manage-column column-name"> 附加到 </th>
						<th class="manage-column column-name"> 日期 </th>
					</tr>
				</tfoot>
				<tbody id="category-lister">
					{foreach from=$assets item=asset name="asset"}
					<tr id="asset_tr_{$asset.id}" class="iedit{if $smarty.foreach.asset.iteration%2 } alternate{/if}">
						<th class="check-column" scope="row">
							<input type="checkbox" value="{$asset.id}" class="xe-shid" name="delete[]" />
						</th>
						<td>
							<img height="60" width="80" class="attachment-80x60" src="{$asset.asset_url}">
						</td>
						<td>
							<strong><a href="/app/admin/asset/edit/id/{$asset.id}" class="row-title">{$asset.file_name}</a></strong>
							<div class="row-actions"><span class="delete"><a href="/app/admin/asset/delete/id/{$asset.id}" class="jq_a_ajax">删除</a></span></div>
						</td>
						<td>
							{Admin_Smarty_DataSet_assetParent parent_id=$asset.parent_id parent_type=$asset.parent_type var=link}
							<strong>{$link}</strong>
						</td>
						<td>{$asset.created_on|date_format:"%Y/%m/%d"}</td>
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