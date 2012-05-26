<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>热门搜索词管理-新花样</title>
	<meta name="author" content="purpen">
	<link href="/csstyle/changelist.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/a/keydict_list.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>热门搜索词列表</h1>
		<div id="content-main-other">
			<div id="hotword_area">
				{foreach from=$words item=word}
				<label>{$word.name}[{$word.ref_count}]</label>
				{/foreach}
			</div>
			<div class="clearer"></div>
		</div>
	</div>
	
</div>
</body>
</html>