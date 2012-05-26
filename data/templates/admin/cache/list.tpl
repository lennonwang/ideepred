<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>缓存管理-新花样</title>
	<meta name="author" content="purpen">
	<link href="/csstyle/changelist.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/a/role_list.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>缓存管理</h1>
		<div id="content-main">
			<div id="changelist">
				<ul>
					<li>首页大图轮换缓存 <a href="/app/admin/cache/update?ckey=idx_big" class="jq_a_ajax">更新</a></li>
					<li>设计师数据缓存 <a href="/app/admin/cache/update?ckey=designer" class="jq_a_ajax">更新</a></li>
					<li>设计作品数据缓存 <a href="/app/admin/cache/update?ckey=work" class="jq_a_ajax">更新</a></li>
					<li>花样产品数据缓存 <a href="/app/admin/cache/update?ckey=product" class="jq_a_ajax">更新</a></li>
					<li>广告数据缓存 <a href="/app/admin/cache/update?ckey=advertise" class="jq_a_ajax">更新</a></li>
				</ul>
			</div>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/cache/display" title="缓存管理">缓存管理</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
</body>
</html>