<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/a/link_edit.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	{if $edit_mode eq 'create'}
	<h2>添加新链接</h2>
	{else}
	<h2>编辑链接</h2>
	{/if}
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			
			<form id="edit_article_frm" action="/app/admin/link/save" method="post">
				<input type="hidden" name="id" value="{$link.id}" id="link_id" />
				
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
											<input type="submit" value=" 确认发布 " name="submit" class="button" />
										</p>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<div id="post-body">
						<div id="post-body-content">
							<div id="titlediv">
								<div id="titlewrap">
									<label for="title">名称：</label>
									<input type="text"  value="{$link.title}" tabindex="1" size="30" name="title">
								</div>
							</div>
							<div class="titlediv">
								<div class="titlewrap">
									<label for="sort">排序：</label>
									<input type="text"  value="{$link.sort}" tabindex="2" size="30" name="sort"><br/>
									<span class="description">页面通常以字母排序，你也可以设置一个数字来改变它们的排序方式。</span>
								</div>
							</div>
							<div class="titlediv">
								<div class="titlewrap">
									<label for="url">链接：</label>
									<input type="text"  value="{$link.url}" tabindex="3" size="100" name="url">
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