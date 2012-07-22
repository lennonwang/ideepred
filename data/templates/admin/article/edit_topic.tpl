<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>编辑专题－新花样</title>
	<link href="/csstyle/forms.css" type="text/css" rel="stylesheet" />
	<link href="/csstyle/uploadify.css" type="text/css" rel="stylesheet" />
	{smarty_include admin.jscript}
	<script type="text/javascript" src="/js/c/jquery.uploadify.js"></script>
	<script type="text/javascript" src="/js/d/jquery.checkboxes.js"></script>
	<script type="text/javascript" src="/js/a/article_edit.js"></script>
</head>

<body>
<div id="container">
	<div id="header">
		{smarty_include admin.header}
	</div>
	<div id="content">
		<h1>编辑 专题</h1>
		<div id="content-main">
			<div id="action_steps">
				<a href="#show_block" name="article_sorts" class="jq_a_ajax">选择栏目</a>  <a href="#show_block" name="article_asset" class="jq_a_ajax">上传附件</a> 
			</div>
			<div id="article_info">
				<form id="edit_article_frm" action="/app/admin/article/save" method="post">
					<input type="hidden" name="id" value="{$article.id}" id="article_id" />
					<input type="hidden" name="type" value="2" />
					
					<div class="row">
						<label for="name">标 识：</label>
						<input type="text" name="name" value="{$article.name}" />
					</div>
					<div class="row">
						<label for="title">标 题：</label>
						<input type="text" name="title" value="{$article.title}" maxlength="80" size="60"/>
					</div>
				
					<div class="row">
						<label for="tags">标 签：</label>
						<input type="text" name="tags" value="{$article.tags}" maxlength="80" size="60"/>
						<label class="help">每个标签用空格隔开。</label>
					</div>
				
					<div class="row">
						<label for="author">作 者：</label>
						<input type="text" name="author" value="{$article.author}" />
					</div>
				
					<div class="row">
						<label for="excerpt">简 介：</label>
						<textarea name="excerpt" cols="50" rows="3">{$article.excerpt}</textarea>
					</div>
					<div class="row">
						{if $article.type eq 2}
						<a href="/app/admin/article/reload/name/{$article.name}" title="重载专题" class="jq_a_ajax">重载专题</a>{/if}
						<textarea id="cbody" name="content" cols="72" rows="15">{$article.content|stripslashes}</textarea>
					</div>
					<div class="row">
						<input class="default" type="submit" name="_submit" value="  ok,保存  "/>
						<input type="button" name="_back" id="_back" value=" 撤 销 "/>
					</div>
					
				</form>
			</div>
			<div id="article_other_info" class="els_hidden">
				<div id="article_sorts" >
					<form id="article_sort_frm" action="/app/admin/article/belong_sort" method="post"  >
						<h3 class="info_title">> 所属栏目 <span class="close"><a class="jq_a_ajax" href="#close_panel" title="close" >X</a></span></h3>
						<div class="sorts">
							{if $edit_mode eq 'update'}
							{foreach from=$sorts item=sort}
							
							<input type="checkbox" name="sort_ids[]" value="{$sort.id}" {if (in_array($sort.id,$article.sort_ids)) eq 1}checked="checked"{/if} /><label>{$sort.name}</label>
							{/foreach}
							{/if}
							{if $edit_mode eq 'create'}
							{foreach from=$sorts item=sort}
							<input type="checkbox" name="sort_ids[]" value="{$sort.id}" /><label>{$sort.name}</label>
							{/foreach}
							{/if}
						</div>
						<div class="media-buttons">
							<input type="button" name="_submit" value="  更新栏目  " id="update_art_sort"/>
						</div>
					</form>
				</div>

				<div id="article_asset" >
					<h3 class="info_title">> 选择附件 <span class="close"><a class="jq_a_ajax" href="#close_panel" title="close">X</a></span></h3>
					<div class="sorts">
						<div class="slt">选择：<a href="#selected_all" class="jq_a_ajax">全选</a> <a href="#selected_reverse" class="jq_a_ajax">反选</a> <a href="#selected_none" class="jq_a_ajax">无</a></div>
						<div class="actions">
					    	<label id="uploadify_assets">Select Files</label>
						</div>
						<div id="uploadify_result">
							{foreach from=$assets item=a}
							<div id="asset_{$a.id}" class="pic_accessory">
								<table>
									<tr>
										<td>
											<input type="checkbox" value="{$a.id}" class="ckb_accessory" />
										</td>
										<td>
											<img src="{$a.url}" width="100" height="75" name="{$a.id}" class="art_ast" />
										</td>	
										<td>
											<div class="asset_info" name="{$a.id}">
												<p name="name">{$a.file_name}</p>
												<p name="mime">{$a.mime}</p>
												<p name="created_on">{$a.created_on}</p>
											</div>
										</td>
									</tr>
								</table>								
							</div>
							{/foreach}
						</div>
					</div>
					<div class="media-buttons">
						<input type="button" id="uploadify_start" value="  开始上传  "/>
						<span>
							<a href="/app/admin/article/insert_asset#insert_asset" class="jq_a_ajax">插入</a> <a href="/app/admin/article/assign_thumb#assign_thumb" class="jq_a_ajax">标为缩略图</a> <a href="#remove_assets" class="jq_a_ajax">删 除</a>
						</span>
					</div>
				</div>
				
			</div>
			
		</div>
		<div id="content-related">
			<h3>可进行操作</h3>
			<p>
				> <a href="/app/admin/article/create" title="创建专题">创建专题</a>
			</p>
			<p>
				> <a href="/app/admin/article/display/type/2" title="专题库">专题库</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/article/display?status=0&type=2" title="未发布专题">未发布专题</a>
			</p>
			<p class="action_second">
				> <a href="/app/admin/article/display?status=1&type=2" title="已发布专题">已发布专题</a>
			</p>
		</div>
		<div class="clearer"></div>
	</div>
</div>
<div id="bakup_area"></div>
</body>
</html>
