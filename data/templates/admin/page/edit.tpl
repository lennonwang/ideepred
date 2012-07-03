<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/uploadify/swfobject.js"></script>
	<script type="text/javascript" src="/js/uploadify/jquery.uploadify.v2.1.0.js"></script>
	<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/js/a/page_edit.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	{if $edit_mode eq 'create'}
	<h2>添加新页面</h2>
	{else}
	<h2>编辑页面</h2>
	{/if}
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			
			<form id="edit_article_frm" action="/app/admin/page/save" method="post">
				<input type="hidden" name="id" value="{$article.id}" id="article_id" />
				<input type="hidden" name="type" value="1" />
				<input type="hidden" value="{$rand_sign}" name="rand_sign_id" id="rand_sign_id">
				<input type="hidden" value="{$article.status|default:0}" name="status" id="article_status">
				
				<div id="poststuff" class="metabox-holder has-right-sidebar">
					<div id="side-info-column" class="inner-sidebar">
						<div id="side-sortables" class="meta-box-sortables ui-sortable">
							<div id="submitdiv" class="postbox">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle">
									<span>发布</span>
								</h3>
								<div class="inside">
									
									<div id="major-publishing-actions">
										<p class="submit">
											<input type="button" value=" 存草稿 " name="saveproduct" class="button" id="save_product_draft" />
											<input type="button" value=" 确认发布 " name="submit" class="button"  id="submit_product" />
										</p>
									</div>
								</div>
							</div>
							
							<div id="picturediv-stuff" class="postbox ">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle">
									<span>页面附件</span>
								</h3>
								
								<div class="inside">
									<div id="product-photos" class="tagsdiv">
										<label id="uploadify_assets">Select Files</label>
									</div>
									
									<div id="uploadify_goods_result">
										<ul class="goods-pic">
										{foreach from=$asset_list item=a}
										<li id="asset_{$a.id}">
											<a href="/app/admin/article/insert_asset/asset_id/{$a.id}#insert_asset" class="jq_a_ajax">
											<img src="{$a.asset_url}" width="120" height="90" name="{$a.id}" class="art_ast" />
											</a>
											<div class="row-actions">
												<span>尺寸: {$a.width}x{$a.height}px</span>
												[<a href="/app/admin/asset/delete?id={$a.id}" class="jq_a_ajax">删除</a>]
											</div>
										</li>
										{/foreach}
										</ul>
										<div class="clear"></div>
									</div>
									
								</div>
							</div>
							
							<div id="tagsdiv-post_tag" class="postbox">
								<div title="显示/隐藏" class="handlediv"><br></div>
								<h3 class="hndle">
									<span>属 性</span>
								</h3>
								
								<div class="inside">
									<h5>父级</h5>
									<label for="parent_id" class="screen-reader-text">上一级页面</label>
									<select id="parent_id" name="parent_id" gtbfieldid="247">
										<option value="">主页面 (无上级)</option>
									</select>
									<p>您可以以层级的方式组织您的页面，例如，你可以设置一个“关于”页面，它的下级有“人生”和“我的宠物”。层级深度没有任何限制。</p>
									<h5>模版</h5>
									<label for="page_template" class="screen-reader-text">页面模版</label>
									<select id="page_template" name="page_template" gtbfieldid="248">
										<option value="page-default-template">默认模版</option>
										<option value="page-list-template">列表模版</option>
										<option value="page-service-template">通栏模版</option>
									</select>
									<p>某些主题有定制的模板，你可以用在一些你想添加新功能或者自定义的布局的页面上。如果这样，你可以在上面看到。</p>
									<h5>排列</h5>
									<p><label for="menu_order" class="screen-reader-text">页面排序</label><input type="text" value="0" id="menu_order" size="4" name="menu_order" gtbfieldid="249"></p>
									<p>页面通常以字母排序，你也可以设置一个数字来改变它们的排序方式。</p>
								</div>
								
							
							</div>
							
						</div>
					</div>
					<div id="post-body">
						<div id="post-body-content"  style="margin-right:340px;">
							<div class="titlediv">
								<div class="titlewrap">
									<label for="name">页面名称：</label>
									<input type="text"  class="title" id="name" value="{$article.name}" tabindex="1" size="30" name="name">
								</div>
							</div>
							<div id="titlediv">
								<div id="titlewrap">
									<label for="title">页面标题：</label>
									<input type="text"  id="title" value="{$article.title}" tabindex="2" size="30" name="title">
								</div>
							</div>
							<div id="postdivrich" class="postarea">
								<script type="text/javascript" src="/js/a/init_tiny.js"></script>
								<div id="editorcontainer">
									<textarea class="userData" name="body" id="cbody" style="height:200;width:650;">{$article.body|stripslashes}</textarea>
									
								</div>
							</div>
							
							<div id="normal-sortables" class="meta-box-sortables ui-sortable">
								<div id="postexcerpt" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>页面摘要</span></h3>
									<div class="inside">
										<label for="excerpt" class="screen-reader-text">摘要</label>
										<textarea id="excerpt" tabindex="4" name="excerpt" cols="40" rows="1">{$article.excerpt}</textarea>
										<p>摘要是您可以手动添加的内容概要。</p>
									</div>
									
								</div>
								
							</div>
							
							<div id="postcustom-sortables" class="meta-box-sortables ui-sortable">
								<div id="postexcerpt" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>扩展属性</span></h3>
									<div class="inside">
										<div id="postcustomstuff">
											<table id="list-table">
												<thead>
													<tr>
														<th class="left">名称</th>
														<th>值</th>
													</tr>
												</thead>
												<tbody class="list:meta" id="the-list">
													{foreach from=$meta_list item=meta}
													<tr id="meta-{$meta.id}">
														<td class="left">
															<label for="meta_key_{$meta.id}" class="screen-reader-text">键</label>
															<input type="text" value="{$meta.key}" size="20" id="meta_title_{$meta.id}" name="meta_title_{$meta.id}" />
															<input type="hidden" value="{$meta.name}" id="meta_key_{$meta.id}" name="meta_key_{$meta.id}" />
															<div class="submit">
																<input type="button" value="删除" class="deletemeta" name="{$meta.id}" />
																<input type="button" class="updatemeta" value="更新" name="{$meta.id}" />
															</div>
														</td>
														<td>
															<textarea cols="30" rows="2" tabindex="6" id="meta_value_{$meta.id}" name="meta_value_{$meta.id}">{$meta.value}</textarea>
														</td>
													</tr>
													{/foreach}
													</tbody>
												</table>
											<p><strong>添加扩展属性：</strong></p>
											<table id="newmeta">
												<thead>
													<tr>
														<th class="left"><label for="metakeyselect">名称</label></th>
														<th><label for="metavalue">值</label></th>
													</tr>
												</thead>

												<tbody>
													<tr>
														<td class="left" id="newmetaleft">
															<input type="text" value="" size="20" id="metakeyselect" name="metakeyselect" tabindex="8" />
														</td>
														<td>
															<textarea tabindex="8" cols="25" rows="2" name="metavalue" id="metavalue"></textarea>
														</td>
													</tr>

													<tr>
														<td class="submit" colspan="2">
															<input type="button" value="添加扩展属性" tabindex="9" class="addnewmeta" name="addmeta" id="addmetasub">
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										
									</div>
									
								</div>
								
							</div>
									
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</form>
		</div>
		
	</div>

</div><!--endwrap-->
</body>
</html>