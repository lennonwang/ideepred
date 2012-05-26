<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>栏目管理－新花样</title>
	<link href="/csstyle/forms.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/a/sort_edit.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>添加 栏目</h1>
		<div id="content-main">
			<form id="edit_sort_frm" action="/app/admin/sort/save" method="post">
				<input type="hidden" name="id" value="{$sort.id}" id="sort_id" />
				
				<div class="row">
					<label for="name">名称：</label>
					<input type="text" name="name" value="{$sort.name}" maxlength="60" size="25"/>
				</div>
				
				<div class="row">
					<label for="parent_id">父级类：</label>
					<select name="parent_id">
						<option value="" >-选择父分类-</option>
						{foreach from=$parent item=c}
							{if $c.id eq $sort.parent_id}
								<option value="{$c.id}" selected="selected" >{$c.name}</option>
							{else}
								<option value="{$c.id}" >{$c.name}</option>
							{/if}
						{/foreach}
					</select>
				</div>

				<div class="row">
					<input class="default" type="submit" name="_submit" value="  ok,保存  "/>
					<input type="button" name="_back" value=" 撤 销 "/>
				</div>
					
			</form>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/sort/edit" title="添加栏目">添加栏目</a>
			</p>
			<p>
				> <a href="/app/admin/sort/display?state=1" title="可用栏目列表">可用栏目列表</a>
			</p>
			<p>
				> <a href="/app/admin/sort/display?state=0" title="禁用栏目列表">禁用栏目列表</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
</body>
</html>