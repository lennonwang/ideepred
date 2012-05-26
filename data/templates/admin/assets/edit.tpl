<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>编辑附件</title>
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/a/asset.js"></script>
</head>

<body>
	<div class="wrap">
		<div class="icon32" id="icon-edit">
			<br>
		</div>
		<h2>{if $edit_mode eq 'create'}添加新媒体{else}编辑媒体信息{/if}</h2>
		<div class="clear"></div>
		<div id="ajax_request_progress"></div>
		<div id="ajax-response"></div>

		<div id="col-container">
			<div class="form-wrap">
				<form action="/app/admin/asset/save" method="post" id="addoption" name="addoption">					
					<input type="hidden" value="{$asset.id}" name="id" id="asset_id">
					<input type="hidden" value="{$rand_sign}" name="rand_sign_id" id="rand_sign_id">
					
					<table class="form-table">
						<tbody>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="thumb">附件图片</label></th>
								<td>
									<div id="uploadify_goods_result"></div>
					            </td>
							</tr>
							<tr class="form-field form-upload">
								<th valign="top" scope="row"><label for="thumb">上传新附件</label></th>
								<td><label id="uploadify_thumb">Select Files</label></td>
							</tr>
						</tbody>
					</table>

					<p class="submit">
						<input type="submit" value=" 确认更新 " name="submit" class="button">
					</p>
				</form>
			</div>

		</div>

	</div><!--endwrap-->
</body>
</html>