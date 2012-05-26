<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/a/store.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>全部品牌 <a href="/app/admin/store/edit" title="添加品牌店铺" class="button add-new-h2">添加品牌</a></h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
			<div class="form-wrap">
				<form action="/app/admin/store/save" method="post" id="addcat" name="addcat">					
					<input type="hidden" value="{$store.id}" name="id" id="store_id">
					<input type="hidden" value="{$rand_sign}" name="rand_sign_id" id="rand_sign_id">
					<table class="form-table">
						<tbody>
							<tr class="form-field form-required">
								<th valign="top" scope="row"><label for="title">品牌名称</label></th>
								<td><input type="text" size="40" value="{$store.title}" id="title" name="title" /></td>
							</tr>
							<tr class="form-field form-required">
								<th valign="top" scope="row"><label for="service">经营范围</label></th>
								<td><input type="text" size="40" value="{$store.service}" id="service" name="service" /></td>
							</tr>
							<tr class="form-field form-upload">
								<th valign="top" scope="row"></th>
								<td>
									<div id="uploadify_goods_result">

										<ul class="goods-pic">
											{foreach from=$asset_list item=a}
											<li id="asset_{$a.id}" {if $a.parent_type eq 44}class="logo"{/if}>
												<img src="{$a.asset_url}" width="120" height="90" name="{$a.id}" class="art_ast" />
												<div class="row-actions">
													<span>尺寸: {$a.width}x{$a.height}px</span>
													{if $a.parent_type eq 45}[<a href="/app/admin/asset/assign_thumb?id={$a.id}&parent_type=44" class="jq_a_ajax">标记为Logo</a>]{/if} [<a href="/app/admin/asset/delete?id={$a.id}" class="jq_a_ajax">删除</a>]
												</div>
											</li>
											{/foreach}
										</ul>
									</div>
								</td>
							</tr>
							<tr class="form-field form-upload">
								<th valign="top" scope="row"><label for="thumb">品牌展示图</label></th>
								<td><label id="uploadify_thumb">Select Files</label></td>
							</tr>
							
							<tr class="form-field">
								<th valign="top" scope="row"><label for="catcode">品牌所属类别</label></th>
								<td>
									<div class="site_node_list">
										{foreach from=$all_category item=cate}
										<span class="{$cate.classname}"> <input type="radio" name="catcode" value="{$cate.code}" {if $store.catcode eq $cate.code}checked="checked"{/if} /> <strong> {$cate.name}  --  {$cate.code} </strong> </span>
										{/foreach}
									</div>
						  		</td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="stick">是否推荐</label></th>
								<td>
									<input type="radio" name="stick" value="1" {if $store.stick eq 1}checked="checked"{/if} />是
									<input type="radio" name="stick" value="0" {if $store.stick eq 0}checked="checked"{/if} />否
									<br>
						            <span class="description">若有频道页，推荐品牌可以优先显示。</span>
								</td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="state">是否通过审核</label></th>
								<td>
									<input type="radio" name="state" value="1" {if $store.state eq 1}checked="checked"{/if} />是
									<input type="radio" name="state" value="0" {if $store.state eq 0}checked="checked"{/if} />否
								
								</td>
							</tr>
							<tr class="form-field">
								<th valign="top" scope="row"><label for="content">品牌介绍</label></th>
								<td><textarea cols="50" rows="5" id="content" name="content">{$store.content}</textarea><br>
					            </td>
							</tr>
						</tbody>
					</table>

					<p class="submit">
						<input type="submit" value="更新品牌信息" name="submit" class="button">
					</p>
				</form>
			</div>
		
	</div>

</div><!--endwrap-->
</body>
</html>