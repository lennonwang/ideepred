<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>edit</title>
	<link href="/csstyle/forms.css" type="text/css" rel="stylesheet" />
	<link href="/csstyle/widgets.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/a/role_edit.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>添加 用户组</h1>
		<div id="content-main">
			<form id="edit_role_frm" action="/app/admin/role/save" method="post">
				<input type="hidden" name="id" value="{$role.id}" id="role_id" />
				
				<div class="row">
					<label for="name">用户组名称：</label>
					<span>
						<input type="text" name="name" value="{$role.name}" maxlength="80" size="30"/>
					</span>
				</div>
					
				<div class="row">
					<label>权限:</label>
					<input type="hidden" name="permission_ids" id="permission_ids"/>
					<div class="selector">
						<div class="selector-available">
							<h2>可用 权限</h2>
							<select id="permissions_from" class="filtered" multiple="multiple" size="15" name="permissions_old">
								{foreach from=$permissable item=pera}
								<option value="{$pera.id}">{$pera.title} | {$pera.resource} | {$pera.privilege}</option>
								{/foreach}
							</select>
							<a href='#chooseall' class="selector-chooseall jq_a_ajax">全选</a>
						</div>
						<ul class="selector-chooser">
							<li><a href="#add_premission" class="jq_a_ajax" title="添加">+></a></li>
							<li><a href="#remove_premission" class="selector-remove jq_a_ajax" title="删除"><-</a></li>
						</ul>
						<div class="selector-chosen">
							<h2>选中的 权限</h2>
							<select id="permissions_to" class="filtered" multiple="multiple" size="15" name="permissions">
								{foreach from=$permission item=rcl}
								{Admin_Smarty_System_ownPermission resource=$rcl.resource privilege=$rcl.privilege var=per}
								<option value="{$per.id}">{$per.title} | {$per.resource} | {$per.privilege}</option>
								{/foreach}
							</select>
							<a href='#clearall' class="selector-clearall jq_a_ajax">清除全部</a>
						</div>
					</div>
				</div>
				<div class="clearer"></div>
				<div class="row">
					<input class="default" type="submit" value="  ok,保存  "/>
					<input type="button" name="_back" id="_back" value=" 撤 消 "/>
				</div>
				
			</form>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/role/edit" title="添加用户组">添加用户组</a>
			</p>
			<p>
				> <a href="/app/admin/role/group" title="用户组列表">用户组列表</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
</body>
</html>
