<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-themes">
		<br>
	</div>
	<h2>编辑主题</h2>
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
									<span>主题文件</span>
								</h3>
								
								<div class="inside">
									
									<div id="uploadify_goods_result">
										<ul class="goods-pic">
											{foreach from=$files key=key item=file}
											<li><a href="/app/admin/appearance/edit?name={$key}" class="jq_a_ajax">{$key}</a></li>
											{/foreach}
										</ul>
										<div class="clear"></div>
									</div>
									
								</div>
							</div>
							
							
						</div>
					</div>
					<div id="post-body">
						<div id="post-body-content">
							
							<div id="postdivrich" class="postarea">
								<div id="editorcontainer">
									<textarea id="cbody" name="content" cols="40" rows="45">{$content}</textarea>
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