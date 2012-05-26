<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>编辑礼品－新花样</title>
	<link href="/csstyle/forms.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/a/gift_edit.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>上传 礼品</h1>
		<div id="content-main">
			<form id="edit_gift_frm" action="/app/admin/gift/save" method="post">
				<input type="hidden" name="id" value="{$gift.id}" id="gift_id" />
				
				<div class="row">
					<label for="title">礼品名称：</label>
					<input type="text" name="title" value="{$gift.title}" maxlength="80" size="60"/>
				</div>
				<div class="row">
					<label for="price">现市场价：</label>
					<input type="text" name="price" value="{$gift.price}" size="20"/>
				</div>
				<div class="row">
					<label for="point">兑换积分：</label>
					<input type="text" name="point" value="{$gift.point}" size="20"/>
				</div>
				<div class="row">
					<label for="start_date">有效时间：</label>
					<input type="text" name="start_date" value="{$gift.start_date}" size="20"/>--<input type="text" name="end_date" value="{$gift.end_date}" size="20"/>
				</div>
				
				{if $edit_mode eq 'create'}
				<div class="row">
					<label for="thumb">小缩略图：</label>
					<input type="file" name="thumb" size="45" />
					<label class="help">尺寸205x125px的jpg格式图片。</label>
				</div>
				<div class="row">
					<label for="show">大展示图：</label>
					<input type="file" name="show" size="45" />
					<label class="help">尺寸712x350px的jpg格式图片。</label>
				</div>
				{/if}
				{if $edit_mode eq 'update'}
				<div class="row" id="work_thumb_upload">
					<label for="thumb">小缩略图：</label>
					<img src="{$gift.thumb}" width="190" height="140" />
					<a href="#replace_to_upload" class="jq_a_ajax">修改</a>
				</div>
				<div class="row" id="work_show_upload">
					<label for="show">大展示图：</label>
					<img src="{$gift.show}" width="355" height="175" />
					<a href="#replace_to_upload" class="jq_a_ajax">修改</a>
				</div>
				{/if}
				
				<div class="row">
					<label for="content">礼品说明：</label>
					<textarea name="content" cols="60" rows="10">{$gift.content}</textarea>
				</div>

				<div class="row">
					<input class="default" type="submit" name="_submit" value="  ok,保存  "/>
				</div>
					
			</form>
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/gift/edit" title="上架新礼品">上架新礼品</a>
			</p>
			<p>
				> <a href="/app/admin/gift/display" title="礼品列表">礼品列表</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/gift/display/state/0" title="未审核礼品">未审核礼品</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/gift/display/state/1" title="可兑换礼品">可兑换礼品</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
<div id="bakup_area">
	<div class="row" id="b_work_thumb_upload">
		<label for="thumb">小缩略图：</label>
		<input type="file" name="thumb" size="45" />
		<a href="#replace_to_show" class="jq_a_ajax">取消</a>
		<label class="help">尺寸190x140px的jpg格式图片。</label>
	</div>
	<div class="row" id="b_work_show_upload">
		<label for="show">大展示图：</label>
		<input type="file" name="show" size="45" />
		<a href="#replace_to_show" class="jq_a_ajax">取消</a>
		<label class="help">尺寸712x350px的jpg格式图片。</label>
	</div>
</div>
</body>
</html>