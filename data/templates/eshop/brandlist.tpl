<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>品牌专区-{smarty_include eshop.common.xtitle}</title>
	<meta name="author" content="xiaoyi">
	<link rel="stylesheet" href="/csstyle/itablet.css" type="text/css" />
	{smarty_include eshop.js-common}
	{smarty_include eshop.js-form}
</head>

<body>
<div id="wrapper">
	
	{smarty_include eshop.common.header}
	
	<div id="container">
		<!--  add by wangjia -->
		<div class="box">
			<h2><img src="/images/eshop/titxt/brand_title.png" alt="品牌专区" /></h2>
			<div class="bordor brandlist">
				<ul class="clearfix">
					{foreach from=$brand_list item=brand}
					<li>
						{if $brand.thumb}
						<a href="{Common_Smarty_Url_format key=brand_product id=$brand.id page=1}" title="{$brand.title}">
							<img src="{$brand.thumb}" alt="{$brand.title}" width="445" height="145" />
						</a>
						{else}
						<a href="{Common_Smarty_Url_format key=brand_product id=$brand.id page=1}" title="{$brand.title}">{$brand.title}</a>
						{/if}
					</li>
					{/foreach}
				</ul>
				
			</div>
		</div>
		
	</div>

	{smarty_include eshop.common.site-help}
	
	{smarty_include eshop.common.footer}
</div>
</body>
</html>