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
	<script type="text/javascript" src="/js/a/article_edit.js"></script>
	<script type="text/javascript" src="/js/xheditor/xheditor-1.1.14-zh-cn.min.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>编辑 文章</h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			
			<form id="edit_article_frm" action="/app/admin/content/save" method="post">
				<input type="hidden" name="id" value="{$article.id}" id="article_id" />
				<input type="hidden" name="type" value="1" />
				<input type="hidden" value="{$rand_sign}" name="rand_sign_id" id="rand_sign_id">
				<input type="hidden" value="{$article.status}" name="status" id="article_status">
				
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
									<span>文章附件</span>
								</h3>
								
								<div class="inside">
									<div id="product-photos" class="tagsdiv">
										<label id="uploadify_assets">Select Files</label>
									</div>
									
									<div id="uploadify_goods_result">
										<ul class="goods-pic">
										{foreach from=$asset_list item=a}
										<li id="asset_{$a.id}">
											<a href="/app/admin/article/insert_asset/asset_id/{$a.id}" class="jq_a_ajax">
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
									<span>文章标签</span>
								</h3>
								
								<div class="inside">
									<div id="post_tag" class="tagsdiv">
										<div class="jaxtag">

											<div class="ajaxtag hide-if-no-js">
												<input type="text" value="{$article.tags}" size="16" class="newtag form-input-tip" name="tags" id="tags" tabindex="9" />
											</div>
										</div>
										<p class="howto">多个标签请用英文逗号分开。</p>
										<div class="tagchecklist"></div>
									</div>
									<p class="hide-if-no-js">
										<a id="link-post_tag" class="tagcloud-link" href="#titlediv">从 文章标签 中选择使用最频繁的标签</a>
									</p>
								</div>
							
							</div> 
						</div>
					</div>
					<div id="post-body">
						<div id="post-body-content" style="margin-right:340px;">
							 
							 <table class="form-table">
									<tbody>
									  <tr class="form-field form-required">
											<th scope="row" style="width:120px;" >
												<label for="name">名称：</label>
											</th>
											<td colspan="3"> 
											 <input type="text"  id="name" value="{$article.name}" tabindex="1" size="30" name="name">
											</td> 
								       </tr>
										<tr class="form-field form-required">
											<th scope="row"  >
												<label for="author">来源或作者：</label>
											</th>
											<td colspan="3"> 
											 <input type="text"  id="author" value="{$article.author}" tabindex="1" size="30" name="author">
											</td> 
								       </tr>
										
										<tr class="form-field form-required">
											<th scope="row"  >
												<label for="title">标题：</label>
											</th>
											<td colspan="3"> 
											 <input type="text"  id="title" value="{$article.title}" tabindex="1" size="30" name="title">
											</td> 
								       </tr>
							 </table> 
								 
							
							<div id="postexcerpt" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>文章摘要</span></h3>
									<div class="inside">
										<label for="excerpt" class="screen-reader-text">摘要</label>
										<textarea id="excerpt" tabindex="8" name="excerpt" cols="40" rows="1">{$article.excerpt}</textarea>
										<p>摘要是您可以手动添加的内容概要。</p>
									</div>
							 </div>
							 
							<div id="postdivrich" class="meta-box-sortables ui-sortable">
								<div id="editorcontainer" class="postbox">
									<div title="显示/隐藏" class="handlediv"><br></div>
									<h3 class="hndle"><span>正 文：</span></h3>
								<script type="text/javascript">
										var ary_content = {$ary_content};
										var ary_count = {$ary_count};
									</script> 
										<div class="clear"></div>
									<!--	<textarea id="cbody" name="body" rows="15">{$article.body|stripslashes}</textarea> -->
										<textarea id="body" name="body" class="xheditor" rows="12" cols="140" style="width: 95%">{$article.body|stripslashes}</textarea>
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