<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/a/category.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>分类目录 <a href="/app/admin/category/edit" title="创建新分类目录" class="button add-new-h2">创建新分类目录</a></h2>
	<div class="clear"></div>
	<div id="ajax_request">
		<img src="/images/admin/loading.gif" alt="loading" />
	</div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<h3>所有分类目录 </h3>
		
		<div class="site_node_list">
			{foreach from=$all_category item=cate}
			<div class="cate-title {$cate.classname}" id="site_category_{$cate.id}"> <a href="/app/admin/category/edit/id/{$cate.id}"
			 title="选择:{$cate.name}" name="{$cate.id}"> <strong> [{$cate.position}] ： {$cate.name}[{$cate.code}]  --  {$cate.slug}  </strong> </a> 
			 {if $cate.id neq 1}<label class="row-actions"><a href="/app/admin/category/edit/id/{$cate.id}" title="{$cate.name}">编辑</a> 
			  <a href="/app/admin/category/delete/id/{$cate.id}" title="{$cate.name}" class="jq_a_ajax">删除</a></label>{/if}</div>
			{/foreach}
		</div>

	</div>

</div><!--endwrap-->
</body>
</html>