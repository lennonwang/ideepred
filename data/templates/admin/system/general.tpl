<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/a/xe-option.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-options-general">
		<br>
	</div>
	<h2>常规选项</h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<form action="/app/admin/xoption/save" method="post" id="addoption" name="addoption">					
				<table class="form-table">
					<tbody>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="website_name">网站标题</label></th>
						<td><input type="text" size="40" value="{$option.website_name}" id="website_name" name="website_name" />
						</td>
					</tr>
					<tr class="form-field form-required">
						<th valign="top" scope="row"><label for="website_description">网站描述</label></th>
						<td><input type="text" size="40" value="{$option.website_description}" id="website_description" name="website_description" /> <span class="description">用简洁的文字描述该网站。</span>
						</td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="website_url">网址(URL)</label></th>
						<td><input type="text" size="40" value="{$option.website_url}" id="website_url" name="website_url" /></td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="website_mode">站点模式</label></th>
						<td><input type="radio" value="B2B" name="website_mode" {if $option.website_mode eq 'B2B'}checked="checked"{/if} />电子商务 <input type="radio" value="BD" name="website_mode" {if $option.website_mode eq 'BD'}checked="checked"{/if} />普通展示</td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="admin_email">电子邮箱</label></th>
						<td><input type="text" size="40" value="{$option.admin_email}" id="admin_email" name="admin_email" />
							<span class="description">这个电子邮件地址仅为了管理方便而索要，例如新注册用户通知。</span></td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="default_comment_status">评论设置</label></th>
						<td>
							<label for="default_comment_status">
							<input type="checkbox" {if $option.default_comment_status}checked="checked"{/if} value="open" id="default_comment_status" name="default_comment_status" class="small" />允许人们发表新文章的评论</label>
						</td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="category_thumb">分类缩略图</label></th>
						<td>
							<input type="radio" {if $option.category_thumb eq 'open'}checked="checked"{/if} value="open" name="category_thumb" class="small" />启用 <input type="radio" {if $option.category_thumb 	eq 'close'}checked="checked"{/if} value="close" name="category_thumb" class="small" />不启用
						</td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="upload_path">默认上传路径</label></th>
						<td>
							<label for="upload_path">
							<input type="text" class="regular-text code" value="{$option.upload_path}" id="upload_path" name="upload_path" gtbfieldid="113"><span class="description">默认为 <code>uploads</code></span></label>
						</td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="upload_url_path">文件的完整URL地址</label></th>
						<td><input type="text" class="regular-text code" value="{$option.upload_url_path}" id="upload_url_path" name="upload_url_path" gtbfieldid="104">
						<span class="description">配置是可选的，默认情况下为空白。</span>
						</td>
					</tr>
					<tr class="form-field">
						<th valign="top" scope="row"><label for="upload_url_path">缩略图大小</label></th>
						<td>
						<label for="thumbnail_size_w">宽</label>
							<input type="text" class="small-text" value="{$option.thumbnail_size_w}" id="thumbnail_size_w" name="thumbnail_size_w" gtbfieldid="105">
						<label for="thumbnail_size_h">高</label>
							<input type="text" class="small-text" value="{$option.thumbnail_size_h}" id="thumbnail_size_h" name="thumbnail_size_h" gtbfieldid="106"><br>
							<input type="checkbox" {if $option.thumbnail_crop}checked="checked"{/if} value="1" id="thumbnail_crop" name="thumbnail_crop">
							<label for="thumbnail_crop">忽略原始比例，总是裁剪缩略图到这个尺寸 (一般情况缩略图是保留原始比例的)</label>
						</td>
					</tr>
				</tbody>
			</table>

				<p class="submit">
					<input type="submit" value=" 保存更改 " name="submit" class="button">
				</p>
			</form>
		</div>
		
	</div>

</div><!--endwrap-->
</body>
</html>