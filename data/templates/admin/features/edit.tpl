<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="/csstyle/xe-mainstyle.css" type="text/css" />
	{smarty_include admin.system.jscript}
	<script type="text/javascript" src="/js/a/features.js"></script>
</head>

<body>
<div class="wrap">
	<div class="icon32" id="icon-edit">
		<br>
	</div>
	<h2>定义产品属性 <a class="button add-new-h2" title="添加产品属性" href="/app/admin/features/edit">添加产品属性</a></h2>
	<div class="clear"></div>
	<div id="ajax_request_progress"></div>
	<div id="ajax-response"></div>
	<div id="col-container">
		<div class="form-wrap">
			<form action="/app/admin/features/save" method="post" id="addcat" name="addcat">				
				<input type="hidden" value="{$feature.id}" name="id" id="features_id">
				<table class="form-table">
					<tbody>
						<tr class="form-field form-required">
							<th valign="top" scope="row"><label for="featurename">属性名称</label></th>
							<td>
								<input type="text" size="40" value="{$feature.featurename}" id="featurename" name="featurename" />
							    <br><span class="description">用来渲染模板显示名称。</span>
							</td>
						</tr>
						<tr class="form-field">
							<th valign="top" scope="row"><label for="featurekey">属性标识</label></th>
							<td><input type="text" size="40" value="{$feature.featurekey}" id="featurekey" name="featurekey" /><br>
				            <span class="description">用来便于系统标识key。它通常为小写并且只能包含字母，数字和连字符。</span></td>
						</tr>
						<tr class="form-field">
							<th valign="top" scope="row"><label for="parent_id">所属分类目录</label></th>
							<td>
								<div class="site_node_list">
									{foreach from=$all_category item=cate}
									<span class="{$cate.classname}"> <input type="radio" name="parent_id" value="{$cate.id}" {if $feature.parent_id eq $cate.id}checked="checked"{/if} /> <strong> {$cate.name}  --  {$cate.code} </strong> </span>
									{/foreach}
								</div>
				                <span class="description">某一分类产品共同具有的属性。</span>
					  		</td>
						</tr>
					</tbody>
				</table>

				<p class="submit">
					<input type="submit" value="更新产品新属性" name="submit" class="button">
				</p>
			</form>
		</div>
		
	</div>

</div><!--endwrap-->
</body>
</html>
