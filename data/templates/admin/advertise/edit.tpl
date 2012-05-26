<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>编辑广告</title>
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/a/adqueue.js"></script>
</head>

<body>
	<div class="wrap">
		<div class="icon32" id="icon-edit">
			<br>
		</div>
		<h2>{if $edit_mode eq 'create'}添加新广告{else}编辑广告信息{/if}</h2>
		<div class="clear"></div>
		<div id="ajax_request_progress"></div>
		<div id="ajax-response"></div>

		<div id="col-container">
				<div class="form-wrap">
					<form action="/app/admin/advertise/save" method="post" id="addoption" name="addoption">					
						<input type="hidden" value="{$advertise.id}" name="id" id="advertise_id">
						<input type="hidden" value="{$rand_sign}" name="rand_sign_id" id="rand_sign_id">
						
						<table class="form-table">
							<tbody>
								<tr class="form-field form-required">
									<th valign="top" scope="row"><label for="number">广告编号</label></th>
									<td>
										<input type="text" size="40" value="{$advertise.number}" id="number" name="number" />  <a href="#show_block" class="jq_a_ajax">已使用的位置编号</a>
										<div id="used_pos_number" class="hidden">
											{foreach from=$number_list item=adp}
											<a href="#put_context" class="jq_a_ajax">{$adp.number}|{$adp.alias}</a> , 
											{/foreach}
										</div>	
									</td>
								</tr>
								<tr class="form-field form-required">
									<th valign="top" scope="row"><label for="alias">编号别名</label></th>
									<td>
										<input type="text" size="40" value="{$advertise.alias}" id="alias" name="alias" />
									</td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="title">广告标题</label></th>
									<td><input type="text" size="40" value="{$advertise.title}" id="title" name="title" /><br>
						            </td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="link">广告链接</label></th>
									<td><input type="text" size="40" value="{$advertise.link}" id="link" name="link" /><br>
						            </td>
								</tr>

								<tr class="form-field form-upload">
									<th valign="top" scope="row"></th>
									<td>
										<div id="uploadify_goods_result">

											<ul class="goods-pic">
												{foreach from=$asset_list item=asset}
												<li id="asset_{$asset.id}">
													<img src="{$asset.asset_url}" width="120" height="90" name="{$asset.id}" class="art_ast" />
													<div class="row-actions">
														<span>尺寸: {$asset.width}x{$asset.height}px</span>
														[<a href="/app/admin/asset/delete?id={$asset.id}" class="jq_a_ajax">删除</a>]
													</div>
												</li>
												{/foreach}
											</ul>
											
										</div>
									</td>
								</tr>
								<tr class="form-field form-upload">
									<th valign="top" scope="row"><label for="thumb">广告展示图</label></th>
									<td><label id="uploadify_thumb">Select Files</label></td>
								</tr>
								<tr class="form-field">
									<th valign="top" scope="row"><label for="body">广告描述</label></th>
									<td><textarea rows="7" id="body" name="body">{$advertise.body}</textarea><br>
						            </td>
								</tr>
									</tbody>
								</table>

								<p class="submit">
									<input type="submit" value="更新广告信息" name="submit" class="button">
								</p>
					</form>
				</div>

		</div>

	</div><!--endwrap-->
</body>
</html>