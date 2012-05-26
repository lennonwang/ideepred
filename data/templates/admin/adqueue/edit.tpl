<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>添加广告－新花样</title>
	<link href="/csstyle/forms.css" type="text/css" rel="stylesheet" />
	<link href="/csstyle/datePicker.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/c/date.js"></script>
	<script type="text/javascript" src="/js/c/jquery.bgiframe.js"></script>
	<script type="text/javascript" src="/js/c/jquery.datePicker.js"></script>
	<script type="text/javascript" src="/js/a/adqueue.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>添加 广告</h1>
		<div id="content-main">
			<form id="edit_advertise_frm" action="/app/admin/adqueue/save" method="post">
					<input type="hidden" name="id" value="{$queue.id}" id="adqueue_id"/>
					<div class="row">
						<label>选择广告位:</label>
						<select name="advertise_id" >
							<option value="">-请选择广告位-</option>
							{foreach from=$advertises item=advertise}
							<option value="{$advertise.id}" {if $queue.advertise_id eq $advertise.id}selected="selected"{/if} >{$advertise.title}:{$advertise.name}</option>
							{/foreach}
						</select>
						<a href="/app/admin/advertise/fetch_info" id="get_advertise_link"></a>
						<label class="notice" id="advertise_format"></label>
					</div>
					<div class="row">
						<label>广告标题:</label>
						<input type="text" value="{$queue.title}" name="title" size="50" />
					</div>
					<div class="row">
						<label>广告链接:</label>
						<input type="text" value="{$queue.link}" name="link" size="50" />
					</div>
					{if $edit_mode eq 'create'}
					<div class="row">
						<label for="thumb">广告图：</label>
						<input type="file" name="thumb" size="35" />
					</div>
					{/if}
					{if $edit_mode eq 'update'}
					<div class="row" id="big_thumb_upload">
						<label for="thumb">广告图：</label>
						<img src="{$queue.thumb}" width="355" height="175" />
						<a href="#replace_to_upload" class="jq_a_ajax">修改</a>
					</div>
					{/if}
					<div class="row date">
						<label>起始日期:</label>
						<input type="text" value="{$queue.start_date}" name="start_date" size="15" class="date-pick" /> <label>--</label> <input type="text" value="{$queue.end_date}" name="end_date" size="15" class="date-pick" /> <label class="help">最长不能超过5天。</label>
						<div class="clearer"></div>
					</div>
					<div class="row">
						<input type="submit" value=" 保 存 " />
					</div>
			</form>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/advertise/display" title="广告位管理">广告位管理</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/advertise/edit" title="新建广告位">新建广告位</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/advertise/display" title="广告位列表">广告位列表</a>
			</p>
			<p>
				> <a href="/app/admin/adqueue/display" title="广告管理">广告管理</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/adqueue/edit" title="添加广告">添加广告</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/adqueue/display?state=0" title="未审核广告">未审核广告</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/adqueue/display?state=1" title="已审核广告">已审核广告</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
<div id="bakup_area">
	<div class="row" id="b_big_thumb_upload">
		<label for="thumb">广告图：</label>
		<input type="file" name="thumb" size="35" />
		<a href="#replace_to_show" class="jq_a_ajax">取消</a>
	</div>
</div>
</body>
</html>