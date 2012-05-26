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
	<div class="icon32" id="icon-users">
		<br>
	</div>
	<h2>所有{if $state eq 1}已激活{else}未激活{/if}用户  <a class="button add-new-h2" href="/app/admin/user/edit">添加新用户</a> </h2>
	<div class="clear"></div>
	
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	
	<div id="col-container">
		<div class="form-wrap">
			<form id="posts-filter" method="get" action="">
				<ul class="subsubsub">
					<li><a href="/app/admin/user/group">全部<span class="count">({$all_count})</span></a> |</li>
					<li><a href="/app/admin/user/group?role_id=9&state=1">管理员<span class="count">({$admin_count})</span></a> |</li>
					<li><a href="/app/admin/user/group?role_id=3">编辑<span class="count">({$editor_count})</span></a> |</li>
					<li><a href="/app/admin/user/group?role_id=2">客服<span class="count">({$service_count})</span></a> |</li>
					<li><a href="/app/admin/user/group?role_id=1">普通用户<span class="count">({$vip_count})</span></a> |</li>
					<li><a href="/app/admin/user/group?state=1">已激活用户<span class="count">({$active_count})</span></a> |</li>
				</ul>
				
				<p class="search-box">
					<label for="post-search-input" class="screen-reader-text">搜索用户:</label>
					<input type="text" value="" name="s" id="post-search-input" gtbfieldid="220">
					<input type="submit" class="button" value="搜索用户">
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
					{assign var=url_prefix value="/app/admin/user/group/state/$state"}
					{smarty_include admin.pager}
				</div>
				<table cellspacing="0" class="widefat fixed">
					<thead>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="manage-column column-name"> 用户名 </th>
							<th class="manage-column column-name"> 昵称 </th>
							<th class="manage-column column-name"> 性别 </th>
							<th class="manage-column column-name"> 角色 </th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="check-column"> <input type="checkbox" /> </th>
							<th class="manage-column column-name"> 用户名 </th>
							<th class="manage-column column-name"> 昵称 </th>
							<th class="manage-column column-name"> 性别 </th>
							<th class="manage-column column-name"> 角色 </th>
						</tr>
					</tfoot>
					<tbody id="category-lister">
						{foreach from=$users item=user name="user"}
						<tr id="user_tr_{$user.id}" class="iedit{if $smarty.foreach.user.iteration%2 } alternate{/if}">
							<th class="check-column" scope="row">
								<input type="checkbox" value="{$user.id}" name="delete[]" />
							</th>
							<td>
								<strong><a href="#" class="row-title">{$user.account}</a>{if $user.state eq 1}--已激活{/if}</strong>
								<div class="row-actions"><span class="edit"><a href="/app/admin/user/edit?id={$user.id}">编辑</a> | </span><span class="edit"><a href="/app/admin/user/activate?id={$user.id}" class="jq_a_ajax">激活用户</a> | </span><span class="delete"><a href="/app/admin/user/remove?id={$user.id}" class="jq_a_ajax">删除</a></span></div>
							</td>
							<td>{$user.username}</td>
							<td>{$user.sex}</td>
							<td>{if $user.role_id eq 1}普通用户{elseif $user.role_id eq 2}客服人员{elseif $user.role_id eq 3}编辑人员{elseif $user.role_id eq 9}管理员{else}未知{/if}</td>
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